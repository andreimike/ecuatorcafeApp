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

Route::get('/', 'HomeController@index')->middleware('auth');

Auth::routes();

Route::get('/register', function () {
    return redirect('/home');
});
// Home Page
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

//Customers Routes
Route::get('/clienti', 'CustomersController@index')->name('customer.view')->middleware('auth');
Route::get('clienti/creeaza', 'CustomersController@create')->name('customer.create')->middleware('auth');
Route::post('clienti/adauga', 'CustomersController@store')->name('customer.store')->middleware('auth');
Route::get('clienti/editare/{contractor_ean}', 'CustomersController@edit')->name('customer.edit')->middleware('auth');
Route::post('clienti/{contractor_ean}', 'CustomersController@update')->name('customer.update')->middleware('auth');
Route::delete('clienti/eliminare/{contractor_ean}', 'CustomersController@destroy')->name('customer.delete')->middleware('auth');
Route::get('clienti/fisiere-incarcate', 'UploadCustomersFiles@index')->name('upload.viewfiles');
Route::get('clienti/descarcare-fisier/{id}', 'UploadCustomersFiles@viewFile')->name('download.customerfile');
Route::delete('clienti/sterge-fisier/{id}', 'UploadCustomersFiles@destroy')->name('delete.customerfile');
Route::get('clienti/importa', 'UploadCustomersFiles@create')->name('upload.customers');
Route::post('import/clienti', 'UploadCustomersFiles@store')->name('import.customers');


//Order Routes
Route::get('/comenzi/adaga', 'OrdersController@create')->name('order.create')->middleware('auth');