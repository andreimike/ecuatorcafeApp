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
Route::get('clienti/fisiere-incarcate', 'UploadCustomersFiles@index')->name('upload.viewfiles')->middleware('auth');
Route::get('clienti/descarcare-fisier/{id}', 'UploadCustomersFiles@viewFile')->name('download.customerfile')->middleware('auth');
Route::delete('clienti/sterge-fisier/{id}', 'UploadCustomersFiles@destroy')->name('delete.customerfile')->middleware('auth');
Route::get('clienti/importa', 'UploadCustomersFiles@create')->name('upload.customers')->middleware('auth');
Route::post('import/clienti', 'UploadCustomersFiles@store')->name('import.customers')->middleware('auth');


//Order Routes
Route::get('/comenzi', 'OrdersController@index')->name('order.view')->middleware('auth');
Route::get('comenzi/adaga', 'OrdersController@create')->name('order.create')->middleware('auth');
Route::post('comenzi/import', 'OrdersController@store')->name('order.store')->middleware('auth');
Route::get('comenzi/declaratie-conformitate/{id}', 'OrdersController@generateDeclaration')->name('order.conformity')->middleware('auth');
Route::get('comenzi/generare-declaratii-bulk/', 'OrdersController@generateDeclarations')->name('order.declarations')->middleware('auth');
Route::get('comenzi/generare-aviz/{id}', 'OrdersController@generateNotice')->name('order.single.notice')->middleware('auth');
Route::get('comenzi/generare-avize-bulk/', 'OrdersController@generateNotices')->name('order.all.notices')->middleware('auth');
Route::get('comenzi/descarca-aviz/{id}', 'OrdersController@noticeDownload')->name('order.single.notice.download')->middleware('auth');
Route::get('comenzi/generare-numar-serie', 'OrdersController@serialNumber')->name('order.serial.numbers')->middleware('auth');
Route::get('optiuni/editare-numar-de-serie/', 'OptionsController@editSerialNumber')->name('serial.number.edit')->middleware('auth');
Route::post('optiuni/{id}', 'OptionsController@updateSerialNumber')->name('serial.number.update')->middleware('auth');

//API Routes

Route::get('smart-bill-api', 'OrdersController@smartBillApi');