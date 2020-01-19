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

use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\UnitController;

Route::get('/','UserController@index')->name('root');


Route::get('/dashboard','DashboardController@index')->name('dashboard');
Route::get('/tester','UserController@showAll')->name('tester');
Route::get('/logout','UserController@logoutUser')->name('logout');
Route::post('/authenticate','UserController@authenticateUser')->name('authenticate');

Route::get('/items','ItemCatalogController@index')->name('items');
Route::get('/items/{edititemno}','ItemCatalogController@editItem')->name('edititems');
Route::post('/items/update/{edititemno}','ItemCatalogController@updateItem')->name('updateitems');
Route::post('/items/create','ItemCatalogController@createItem')->name('createitems');
Route::post('/items/deleteitemfrombin','ItemCatalogController@deleteItemsFromBin')->name('deleteitemfrombin');


Route::get('/vendors','VendorController@index')->name('vendors');
Route::get('/vendors/{editvendorid}','VendorController@editVendor')->name('editvendors');
Route::post('/vendors/update/{editvendorid}','VendorController@updateVendor')->name('updatevendors');
Route::post('/vendors/create','VendorController@createVendor')->name('createvendors');
Route::post('/vendor/deletefrombin','VendorController@deleteVendorsFromBin')->name('deletefrombin');


Route::post('/vendorbin/clearbin','VendorBinController@clearVendor')->name('clearbin');
Route::post('/vendorbin/mark/{markvendorid}','VendorBinController@markVendor')->name('markvendor');
Route::post('/vendorbin/unmark/{unmarkvendorid}','VendorBinController@unmarkVendor')->name('unmarkvendor');

Route::post('/itembin/clearitembin','ItemBinController@clearItem')->name('clearitembin');
Route::post('/itembin/mark/{markitemno}','ItemBinController@markItem')->name('markitem');
Route::post('/itembin/unmark/{unmarkitemno}','ItemBinController@unmarkItem')->name('unmarkitem');

Route::get('/encode','TransactionsController@index')->name('encode');
Route::get('/encode/{encodeitemno}','TransactionsController@encodeItem')->name('encodeitemno');


Route::get('/cart','CartController@index')->name('cart');
Route::get('/cart/clear','CartController@clearCart')->name('clearcart');
Route::get('/cart/remove/{cartid}','CartController@removeCartItem')->name('removecartitem');

Route::post('/cart/add','CartController@addToCart')->name('addtocart');

Route::get('/transaction/view','TransactionsController@viewTransactions')->name('viewtransactions');
Route::get('/transaction/view/{itemno}','TransactionsController@viewTransactions')->name('viewitemtransactions');
Route::get('/transaction/processcart','TransactionsController@processCart')->name('processcart');


Route::get('/units',function(){
    return UnitController::generateOptionString();
})->name('units');



Route::post('/fetchitems','ItemListController@getAll')->name('fetchitems');
Route::post('/fetchvendors','VendorController@getAll')->name('fetchvendors');
Route::post('/fetchvendorbin','VendorBinController@getAll')->name('fetchvendorbin');
Route::post('/fetchitembin','ItemBinController@getAll')->name('fetchitembin');
Route::post('/fetchitemoverview','ItemOverviewController@getAll')->name('fetchitemoverview');
Route::post('/fetchcartitems','CartOverviewController@getAll')->name('fetchcartitems');

Route::post('/fetchtransactions','TransactionsOverviewController@getAll')->name('fetchtransactions');
Route::post('/fetchtransactions/{itemno}','TransactionsOverviewController@getAll')->name('fetchitemtransactions');





