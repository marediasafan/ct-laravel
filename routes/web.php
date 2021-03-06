<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Inventory@create');

Route::get('/create', 'Inventory@create');
Route::post('/create', 'Inventory@store');

Route::delete('/delete/{id}', 'Inventory@delete');
