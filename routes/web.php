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

Route::get('/', function () {
    return view('welcome');
});


 Route::get('discount/product-list/', 'Admin\DisountController@getProductId')->name('discount.productlist');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test-sync', 'User\SearchHistoryController@index')->name('test.sync'); 

Route::group(['middleware' => ['auth']], function () {
    
    //Admin
    Route::resource('manualsync', 'Admin\DatasyncController');
    Route::get('static-residential', 'Admin\DatasyncController@syncResidentialData')->name('static-residential');
    Route::get('static-sync', 'Admin\DatasyncController@syncStaticData')->name('static-sync');
    Route::get('static-professional', 'Admin\DatasyncController@syncProfessionalData')->name('static-professional');
    Route::get('packs', 'Admin\DatasyncController@syncPacks')->name('sync-packs');
    Route::get('postalcodes', 'Admin\DatasyncController@syncPostalcode')->name('sync-postalcodes');
    Route::get('dynamic-sync', 'Admin\DatasyncController@syncDynamicData')->name('sync-dynamicData');
    Route::get('netcost-electricity', 'Admin\DatasyncController@syncNetcostE')->name('sync-netcostE');
    Route::get('dynamic-resident', 'Admin\DatasyncController@syncDynamicResident')->name('sync-dynResident');
    Route::get('dynamic-profession', 'Admin\DatasyncController@syncDynamicProfession')->name('sync-dynProfession');
    Route::get('sync-tax', 'Admin\DatasyncController@syncTax')->name('sync-tax');
    Route::get('netcost-gas', 'Admin\DatasyncController@syncNetcostG')->name('sync-netcostG');
    Route::get('discounts', 'Admin\DatasyncController@syncDiscounts')->name('sync-discounts');
    Route::get('supplier', 'Admin\DatasyncController@syncSupplier')->name('sync-supplier');
    Route::get('gdo', 'Admin\DatasyncController@syncDgo')->name('sync-dgo');
    Route::get('sync-all', 'Admin\DatasyncController@syncAll')->name('sync-all');
    Route::get('sync-exceptpostal', 'Admin\DatasyncController@syncExceptPostal')->name('sync-exceptpostal');
    Route::get('estimate-consumption', 'Admin\DatasyncController@estimate_consumption')->name('estimate-consumption');


    Route::resource('data-restore', 'Admin\DataRestoreController');
    Route::get('get-backupdate', 'Admin\DataRestoreController@get_backup_date')->name('get-backupdate');
    Route::get('sync-backup', 'Admin\DataRestoreController@sync_backup')->name('sync_backup');
    
    Route::get('backup', 'Admin\BackupController@backup')->name('backup.index');
    Route::get('full-backup', 'Admin\BackupController@fullBackup')->name('backup.full');
    Route::post('restore', 'Admin\BackupController@restoreAll')->name('restore-all');
    Route::get('restore-progress', 'Admin\BackupController@getProgress')->name('restore.progress');

    Route::resource('usersearch', 'User\SearchHistoryController'); 
    Route::get('usersearch/show/{id}', 'User\SearchHistoryController@show')->name('usersearch.show');
    Route::get('usersearch/delete/{id}', 'User\SearchHistoryController@delete')->name('usersearch.delete');
    Route::get('usersearch/data', 'User\SearchHistoryController@data')->name('usersearch.data');
    Route::get('filter-user', 'User\SearchHistoryController@filterUser')->name('usersearch.filter');

    Route::resource('discount', 'Admin\DisountController');
    
    
    
});  


/**
 * Api
 * Calculations-start
 */

 Route::get('calculation','Api\Calculations\CalculationController@index')->name('calculation');


/**
 * end of calculation
 */

//Route::get('/test', 'Admin\DisountController@generateBarcodeNumber')->name('test'); 

Route::get('/test', function() {
    Artisan::call('supplier:update');
  
    return "test completed";
});
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    return "Cache is cleared";
});
