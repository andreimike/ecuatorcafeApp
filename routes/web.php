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
Route::get('clienti/fisiere-incarcate', 'CustomersUploadsFiles@index')->name('upload.viewfiles')->middleware('auth');
Route::get('clienti/descarcare-fisier/{id}', 'CustomersUploadsFiles@viewFile')->name('download.customerfile')->middleware('auth');
Route::delete('clienti/sterge-fisier/{id}', 'CustomersUploadsFiles@destroy')->name('delete.customerfile')->middleware('auth');
Route::get('clienti/importa', 'CustomersUploadsFiles@create')->name('upload.customers')->middleware('auth');
Route::post('import/clienti', 'CustomersUploadsFiles@store')->name('import.customers')->middleware('auth');


//Order Routes
Route::get('/comenzi', 'OrdersController@index')->name('order.view')->middleware('auth');
Route::get('comenzi/adaga', 'OrdersController@create')->name('order.create')->middleware('auth');
Route::post('comenzi/import', 'OrdersController@store')->name('order.store')->middleware('auth');
Route::get('comenzi/declaratie-conformitate/{id}', 'OrdersController@generateDeclaration')->name('order.conformity')->middleware('auth');
Route::get('comenzi/generare-declaratii-bulk/', 'OrdersController@generateDeclarations')->name('order.declarations')->middleware('auth');
Route::get('comenzi/generare-aviz/{id}', 'OrdersController@generateNotice')->name('order.single.notice')->middleware('auth');
Route::get('comenzi/generare-avize-bulk/', 'OrdersController@generateNotices')->name('order.all.notices')->middleware('auth');
//Route::get('comenzi/descarca-aviz/{id}', 'OrdersController@noticeDownload')->name('order.single.notice.download')->middleware('auth');
Route::get('comenzi/generare-numar-serie', 'OrdersController@serialNumber')->name('order.serial.numbers')->middleware('auth');
Route::get('optiuni/editare-numar-de-serie/', 'OptionsController@editSerialNumber')->name('serial.number.edit')->middleware('auth');
Route::post('optiuni/{id}', 'OptionsController@updateSerialNumber')->name('serial.number.update')->middleware('auth');
Route::get('optiuni/same-day/api/informatii/', 'OptionsController@editApiToken')->name('api.token.edit')->middleware('auth');
Route::get('optiuni/same-day/api/actualizare', 'OptionsController@updateApiToken')->name('api.token.update')->middleware('auth');
Route::get('comenzi/generare-pdf-etichete', 'OrdersController@generateStickers')->name('order.create.stickers.pdf')->middleware('auth');

//Options Routes
Route::get('optiuni/fisiere-incarcate', 'OptionsController@getStoredFiles')->name('view.stored.files')->middleware('auth');
Route::get('optiuni/descarcare-fisier-comanda/{id}', 'OptionsController@downloadOrderFile')->name('download.order.file')->middleware('auth');
Route::delete('optiuni/sterge-fisier-comanda/{id}', 'OptionsController@destroyOrderFile')->name('delete.order.file')->middleware('auth');
Route::delete('optiuni/sterge-toate-fisierele-comenzi', 'OptionsController@destroyAllOrdersFiles')->name('delete.all.orders.files')->middleware('auth');
Route::delete('optiuni/sterge-toate-fisierele-clienti', 'OptionsController@destroyAllCustomersFiles')->name('delete.all.customers.files')->middleware('auth');
Route::get('optiuni/cautare-detalii-locatie', 'OptionsController@searchCustomerLocation')->name('search.customer.location.data')->middleware('auth');


//API Routes
Route::get('comenzi/generare-factura/{id}', 'OrdersController@createInvoice')->name('generate.smart.bill.invoice')->middleware('auth');
Route::get('comenzi/generare-awb/{id}', 'OrdersController@smdApiCreateAwb')->name('generate.smd.awb')->middleware('auth');
Route::get('/optiuni/dev/waveit/api-token', 'OrdersController@getToken')->middleware('auth');
Route::get('/optiuni/dev/waveit/smd-api-pickup-point/', 'OrdersController@smdApiGetPickupPoint')->middleware('auth');
Route::get('/optiuni/dev/waveit/smd-api-active-services/', 'OrdersController@smdApiGetActiveServices')->middleware('auth');
Route::get('/optiuni/dev/waveit/smd-api-get-county', 'OrdersController@smdApiGetCountyList')->middleware('auth');
Route::get('/optiuni/dev/waveit/smd-api-get-city', 'OrdersController@smdApiGetCityList')->middleware('auth');
Route::get('/optiuni/dev/waveit/smd-api-create-pickup-point', 'OrdersController@smdApiCreatePickupPoint')->middleware('auth');
