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
use App\Http\Controllers\UpdateLocalDatabaseController;

Route::get('/','UserController@index')->name('root');


Route::get('/dashboard','DashboardController@index')->name('dashboard')->middleware('auth');
Route::get('/tester','UserController@showAll')->name('tester');
Route::get('/logout','UserController@logoutUser')->name('logout');
Route::post('/authenticate','UserController@authenticateUser')->name('authenticate-user');

Route::get('/items','ItemCatalogController@index')->name('items')->middleware('auth');
Route::get('/items/options','ItemCatalogController@getOptionsStringRequest')->name('items-options');
Route::get('/items/{edititemno}','ItemCatalogController@editItem')->name('edititems');
Route::post('/items/update/{edititemno}','ItemCatalogController@updateItem')->name('updateitems');
Route::post('/items/create','ItemCatalogController@createItem')->name('createitems');
Route::post('/items/deleteitemfrombin','ItemCatalogController@deleteItemsFromBin')->name('deleteitemfrombin');


Route::get('/vendors','VendorController@index')->name('vendors')->middleware('auth');
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

Route::get('/encode','TransactionsController@index')->name('encode')->middleware('auth');
Route::get('/encode/{encodeitemno}','TransactionsController@encodeItem')->name('encodeitemno');


Route::get('/cart','CartController@index')->name('cart')->middleware('auth');
Route::get('/cart/clear','CartController@clearCart')->name('clearcart');
Route::get('/cart/remove/{cartid}','CartController@removeCartItem')->name('removecartitem');

Route::post('/cart/add','CartController@addToCart')->name('addtocart');

Route::get('/transaction/view','TransactionsController@viewTransactions')->name('viewtransactions')->middleware('auth');
Route::get('/transaction/adminview','TransactionsController@adminViewTransactions')->name('adminviewtransactions')->middleware('auth');
Route::get('/transaction/adminview/{itemno}','TransactionsController@adminViewTransactions')->name('adminviewitemtransactions');
Route::get('/transaction/view/{itemno}','TransactionsController@viewTransactions')->name('viewitemtransactions')->middleware('auth');
Route::get('/transaction/processcart','TransactionsController@processCart')->name('processcart');


Route::get('/stocks','StockController@index')->name('stocks')->middleware('auth');
Route::get('/stocks/admin','StockController@adminIndex')->name('adminstocks')->middleware('auth');

Route::get('/backup','BackupDatabaseController@index')->name('backup')->middleware('auth');
Route::get('/backup/start','BackupDatabaseController@backupDatabase')->name('dobackup')->middleware('auth');
Route::get('/backup/details','BackupDatabaseController@backupDetails')->name('backupdetails')->middleware('auth');

Route::get('/notebook','NoteBookController@index')->name('notebook')->middleware('auth');
Route::post('/notebook/new','NoteBookController@newTransaction')->name('new-notebook');
Route::get('/notebook/view','NoteBookController@viewNotebook')->name('view-notebook')->middleware('auth');

Route::get('/notebook/edit/{receipt_id}','NoteBookController@editIndex')->name('edit-notebook');
Route::get('/notebook/view/receipt','NoteBookController@getNotebookReceipt')->name('receipt-notebook');

Route::get('/receipt-item','ReceiptItemsController@getReceiptItem')->name('receipt-items');
Route::post('/receipt-item/update','ReceiptItemsController@updateReceiptItem')->name('update-receipt-item');

Route::get('/receipt/{receipt_id}','ReceiptController@getReceiptJson')->name('get-receipt');
Route::post('/receipt/update','ReceiptController@updateReceipt')->name('update-receipt');
Route::get('/receipt-info/ranges','ReceiptController@fetchDateRange')->name('receipt-ranges');

// Route::get('/testing/{deviceCode}',
//     function($deviceCode)
//     {
//         return UpdateLocalDatabaseController::updateDeviceStocks($deviceCode);        
//     }
// )->name('updatelocal');


Route::get('/updatelocal/{deviceCode}',
    function($deviceCode)
    {
        return UpdateLocalDatabaseController::updateLocal($deviceCode);        
    }
)->name('updatelocal')->middleware('auth');



Route::get('/units',function(){
    return UnitController::generateOptionString();
})->name('units');



Route::post('/fetchitems','ItemListController@getAll')->name('fetchitems');
Route::post('/fetchvendors','VendorController@getAll')->name('fetchvendors');
Route::post('/fetchvendorbin','VendorBinController@getAll')->name('fetchvendorbin');
Route::post('/fetchitembin','ItemBinController@getAll')->name('fetchitembin');
Route::post('/fetchitemoverview','ItemOverviewController@getAll')->name('fetchitemoverview');
Route::post('/fetchcartitems','CartOverviewController@getAll')->name('fetchcartitems');
Route::post('/fetchstocks','StocksOverviewController@getAll')->name('fetchstocks');
Route::post('/fetchadminstocks','AllStocksController@admingetAll')->name('fetchadminstocks');


Route::post('/fetchreceipts','ReceiptController@getAll')->name('fetchreceipts');

Route::post('/fetchreceiptitemsoverview','ReceiptItemsOverviewController@getAll')->name('fetchreceiptitemsoverview');

Route::post('/fetchtransactions','TransactionsOverviewController@getAll')->name('fetchtransactions');
Route::post('/fetchadmintransactions','TransactionsOverviewController@getAdminTransactions')->name('fetchadmintransactions');
Route::post('/fetchadmintransactions/{itemno}','TransactionsOverviewController@getAdminTransactions')->name('fetchadminitemtransactions');
Route::post('/fetchtransactions/{itemno}','TransactionsOverviewController@getAll')->name('fetchitemtransactions');





