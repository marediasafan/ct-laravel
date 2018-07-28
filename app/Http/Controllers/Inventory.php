<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class Inventory extends Controller
{

    /**
     * Display form to add inventory and list stock inventory
     */
    public function create()
    {
        // read json file if exists
        $inventory_data = Storage::disk('local')->exists('inventory.json') ?
            json_decode(Storage::disk('local')->get('inventory.json')) : [];

        usort($inventory_data, function($a, $b) {
            return strtotime($b->created_at) - strtotime($a->created_at);
        });

        $total = array_sum(array_map(function($item) {
            return $item->quantity * $item->price_per_item;
        }, $inventory_data));

        return view('inventory/create', compact('inventory_data', 'total'));
    }

    /**
     * Store new inventory data - XML / JSON format
     */
    public function store(Request $request)
    {
        // first perform validation
        $request->validate(
            [
                'product_name'   => 'required',
                'quantity'       => 'required|numeric',
                'price_per_item' => 'required',
            ]
        );

        // fetch existing json file if it exists
        $inventoryData = Storage::disk('local')->exists('inventory.json') ? json_decode(Storage::disk('local')->get('inventory.json')) : [];

        // store validated form data as JSON or XML
        $id = !empty($inventoryData) && is_array($inventoryData) ? end($inventoryData)->id + 1 : 1;
        $formData = [
            'id' => $id,
            'product_name' => $request->get('product_name'),
            'quantity' => $request->get('quantity'),
            'price_per_item' => $request->get('price_per_item'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        array_push($inventoryData, $formData);

        Storage::disk('local')->put('inventory.json', json_encode($inventoryData));

        return Redirect::to('create');
    }

    public function delete($id)
    {
        if (empty($id)) {
            return Redirect::to('create');
        }

        // fetch existing json file if it exists
        $inventoryData = Storage::disk('local')->exists('inventory.json') ? json_decode(Storage::disk('local')->get('inventory.json')) : [];

        // unset item based on requested delete id
        foreach($inventoryData as $key => $item) {
            if ($item->id == $id)
                unset($inventoryData[$key]);
        }

        Storage::disk('local')->put('inventory.json', json_encode($inventoryData));

        return Redirect::to('create');
    }
}
