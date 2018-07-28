<!DOCTYPE html>
<html>
<head>
    <title>Inventory Management - Laravel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h2>Inventory Management</h2><br/>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(array('url' => 'create', 'method' => 'post')) !!}
    {!! Form::token()  !!}

    <div class="form-group">
        {!! Form::label('product_name', 'Product Name') !!}
        {!! Form::text('product_name') !!}
    </div>

    <div class="form-group">
        {!! Form::label('quantity', 'Quantity') !!}
        {!! Form::number('quantity') !!}
    </div>

    <div class="form-group">
        {!! Form::label('price_per_item', 'Price per item') !!}
        {!! Form::text('price_per_item') !!}
    </div>

    {!! Form::submit('Add Inventory', array('class' => 'btn btn-success')) !!}

    {!! Form::close() !!}
</div>

<br/>

<div class="container">
    <h2>List of Inventory in stock</h2><br/>

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Product Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Price Per Item</th>
            <th scope="col">Created At</th>
            <th scope="col">Total Value</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($inventory_data as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->price_per_item, 2, '.',',') }}</td>
                <td>{{ $item->created_at }}</td>
                <td>${{ number_format($item->quantity * $item->price_per_item, 2, '.', ',') }}</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="4" align="right">Total Value </td>
            <td>${{ number_format($total, 2, '.', ',') }}</td>
        </tr>
        </tbody>
    </table>
</div>

</body>
</html>


