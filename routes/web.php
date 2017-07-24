<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
// Authentication routes...
Route::get('backend/login', ['as' => 'backend.login-form', 'uses' => 'Backend\UserController@loginForm']);
Route::post('backend/login', ['as' => 'backend.check-login', 'uses' => 'Backend\UserController@checkLogin']);
Route::get('backend/logout', ['as' => 'backend.logout', 'uses' => 'Backend\UserController@logout']);
Route::any('backend/upload/delete-image', ['as' => 'delete-image', 'uses' => 'Backend\UploadController@deleteImage']);  
Route::group(['namespace' => 'Backend', 'prefix' => 'backend', 'middleware' => 'isAdmin'], function()
{    
    Route::get('dashboard', ['as' => 'dashboard.index', 'uses' => "ShopVonController@dashboard"]);
    Route::post('delete', ['as' => 'delete', 'uses' => "GeneralController@delete"]);
    Route::group(['prefix' => 'shop'], function () {
        Route::get('/', ['as' => 'shop.index', 'uses' => 'ShopController@index']);
        Route::get('/create', ['as' => 'shop.create', 'uses' => 'ShopController@create']);
        Route::post('/store', ['as' => 'shop.store', 'uses' => 'ShopController@store']);
        Route::get('{id}/edit',   ['as' => 'shop.edit', 'uses' => 'ShopController@edit']);
        Route::post('/update', ['as' => 'shop.update', 'uses' => 'ShopController@update']);
        Route::get('{id}/destroy', ['as' => 'shop.destroy', 'uses' => 'ShopController@destroy']);
    });
    Route::group(['prefix' => 'dieu-kien'], function () {
        Route::get('/', ['as' => 'dieu-kien.index', 'uses' => 'DieuKienController@index']);
        Route::get('/create', ['as' => 'dieu-kien.create', 'uses' => 'DieuKienController@create']);
        Route::post('/store', ['as' => 'dieu-kien.store', 'uses' => 'DieuKienController@store']);
        Route::get('{id}/edit',   ['as' => 'dieu-kien.edit', 'uses' => 'DieuKienController@edit']);
        Route::post('/update', ['as' => 'dieu-kien.update', 'uses' => 'DieuKienController@update']);
        Route::get('{id}/destroy', ['as' => 'dieu-kien.destroy', 'uses' => 'DieuKienController@destroy']);
    });
    Route::group(['prefix' => 'condition'], function () {
        Route::get('/', ['as' => 'condition.index', 'uses' => 'ConditionController@index']);
        Route::get('/create', ['as' => 'condition.create', 'uses' => 'ConditionController@create']);
        Route::post('/store', ['as' => 'condition.store', 'uses' => 'ConditionController@store']);
        Route::get('{id}/edit',   ['as' => 'condition.edit', 'uses' => 'ConditionController@edit']);
        Route::post('/update', ['as' => 'condition.update', 'uses' => 'ConditionController@update']);
        Route::get('{id}/destroy', ['as' => 'condition.destroy', 'uses' => 'ConditionController@destroy']);
    });
    Route::group(['prefix' => 'shop-tiem-nang'], function () {
        Route::get('/', ['as' => 'shop-tiem-nang.index', 'uses' => 'ShopTiemNangController@index']);
        Route::get('/create', ['as' => 'shop-tiem-nang.create', 'uses' => 'ShopTiemNangController@create']);
        Route::post('/store', ['as' => 'shop-tiem-nang.store', 'uses' => 'ShopTiemNangController@store']);
        Route::get('{id}/edit',   ['as' => 'shop-tiem-nang.edit', 'uses' => 'ShopTiemNangController@edit']);
        Route::post('/update', ['as' => 'shop-tiem-nang.update', 'uses' => 'ShopTiemNangController@update']);
        Route::get('{id}/destroy', ['as' => 'shop-tiem-nang.destroy', 'uses' => 'ShopTiemNangController@destroy']);
    });
    Route::group(['prefix' => 'shop-von'], function () {
        Route::get('/', ['as' => 'shop-von.index', 'uses' => 'ShopVonController@index']);
        Route::get('/create', ['as' => 'shop-von.create', 'uses' => 'ShopVonController@create']);
        Route::post('/store', ['as' => 'shop-von.store', 'uses' => 'ShopVonController@store']);
        Route::get('{id}/edit',   ['as' => 'shop-von.edit', 'uses' => 'ShopVonController@edit']);
        Route::post('/update', ['as' => 'shop-von.update', 'uses' => 'ShopVonController@update']);
        Route::get('{id}/destroy', ['as' => 'shop-von.destroy', 'uses' => 'ShopVonController@destroy']);
    });   
    Route::group(['prefix' => 'shop-type'], function () {
        Route::get('/', ['as' => 'shop-type.index', 'uses' => 'ShopTypeController@index']);
        Route::get('/create', ['as' => 'shop-type.create', 'uses' => 'ShopTypeController@create']);
        Route::post('/store', ['as' => 'shop-type.store', 'uses' => 'ShopTypeController@store']);
        Route::get('{id}/edit',   ['as' => 'shop-type.edit', 'uses' => 'ShopTypeController@edit']);
        Route::post('/update', ['as' => 'shop-type.update', 'uses' => 'ShopTypeController@update']);
        Route::get('{id}/destroy', ['as' => 'shop-type.destroy', 'uses' => 'ShopTypeController@destroy']);
    });
    Route::group(['prefix' => 'shop-quy-mo'], function () {
        Route::get('/', ['as' => 'shop-quy-mo.index', 'uses' => 'ShopQuyMoController@index']);
        Route::get('/create', ['as' => 'shop-quy-mo.create', 'uses' => 'ShopQuyMoController@create']);
        Route::post('/store', ['as' => 'shop-quy-mo.store', 'uses' => 'ShopQuyMoController@store']);
        Route::get('{id}/edit',   ['as' => 'shop-quy-mo.edit', 'uses' => 'ShopQuyMoController@edit']);
        Route::post('/update', ['as' => 'shop-quy-mo.update', 'uses' => 'ShopQuyMoController@update']);
        Route::get('{id}/destroy', ['as' => 'shop-quy-mo.destroy', 'uses' => 'ShopQuyMoController@destroy']);
    });  
    Route::group(['prefix' => 'shop-cap-do'], function () {
        Route::get('/', ['as' => 'shop-cap-do.index', 'uses' => 'ShopCapDoController@index']);
        Route::get('/create', ['as' => 'shop-cap-do.create', 'uses' => 'ShopCapDoController@create']);
        Route::post('/store', ['as' => 'shop-cap-do.store', 'uses' => 'ShopCapDoController@store']);
        Route::get('{id}/edit',   ['as' => 'shop-cap-do.edit', 'uses' => 'ShopCapDoController@edit']);
        Route::post('/update', ['as' => 'shop-cap-do.update', 'uses' => 'ShopCapDoController@update']);
        Route::get('{id}/destroy', ['as' => 'shop-cap-do.destroy', 'uses' => 'ShopCapDoController@destroy']);
    });   
    Route::group(['prefix' => 'shop-size'], function () {
        Route::get('/', ['as' => 'shop-size.index', 'uses' => 'ShopSizeController@index']);
        Route::get('/create', ['as' => 'shop-size.create', 'uses' => 'ShopSizeController@create']);
        Route::post('/store', ['as' => 'shop-size.store', 'uses' => 'ShopSizeController@store']);
        Route::get('{id}/edit',   ['as' => 'shop-size.edit', 'uses' => 'ShopSizeController@edit']);
        Route::post('/update', ['as' => 'shop-size.update', 'uses' => 'ShopSizeController@update']);
        Route::get('{id}/destroy', ['as' => 'shop-size.destroy', 'uses' => 'ShopSizeController@destroy']);
    });

    Route::post('/tmp-upload', ['as' => 'image.tmp-upload', 'uses' => 'UploadController@tmpUpload']);
    Route::post('/tmp-upload-multiple', ['as' => 'image.tmp-upload-multiple', 'uses' => 'UploadController@tmpUploadMultiple']);
        
    Route::post('/update-order', ['as' => 'update-order', 'uses' => 'GeneralController@updateOrder']);
    Route::post('/ck-upload', ['as' => 'ck-upload', 'uses' => 'UploadController@ckUpload']);
    Route::post('/get-slug', ['as' => 'get-slug', 'uses' => 'GeneralController@getSlug']);
    Route::group(['prefix' => 'account'], function () {
        Route::get('/', ['as' => 'account.index', 'uses' => 'AccountController@index']);
        Route::get('/change-password', ['as' => 'account.change-pass', 'uses' => 'AccountController@changePass']);
        Route::post('/store-password', ['as' => 'account.store-pass', 'uses' => 'AccountController@storeNewPass']);
        Route::get('/update-status/{status}/{id}', ['as' => 'account.update-status', 'uses' => 'AccountController@updateStatus']);
        Route::get('/create', ['as' => 'account.create', 'uses' => 'AccountController@create']);
        Route::post('/store', ['as' => 'account.store', 'uses' => 'AccountController@store']);
        Route::get('{id}/edit',   ['as' => 'account.edit', 'uses' => 'AccountController@edit']);
        Route::post('/update', ['as' => 'account.update', 'uses' => 'AccountController@update']);
        Route::get('{id}/destroy', ['as' => 'account.destroy', 'uses' => 'AccountController@destroy']);
        Route::post('/get-user-list-by-type', ['as' => 'account.get-user-list-by-type', 'uses' => 'AccountController@ajaxGetAccount']);
        Route::post('/get-user-list-by-owner', ['as' => 'account.get-user-list-by-owner', 'uses' => 'AccountController@ajaxGetAccountOwner']);
        
    });
    Route::post('/save-col-order', ['as' => 'save-col-order', 'uses' => 'GeneralController@saveColOrder']); 
});

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@initPage']);
Route::get('/location', 'HomeController@findItem');
Route::get('/get-image-thumbnail', ['as' => 'get-image-thumbnail' , 'uses' => 'HomeController@getImageThumbnail']);
Route::get('/gallery', ['as' => 'gallery' , 'uses' => 'HomeController@gallery']);
Route::get('/edit-shop-fe', ['as' => 'edit-shop-fe' , 'uses' => 'HomeController@editShop']);
Route::get('ward-{district_id}.html', ['as' => 'ward-marker', 'uses' => 'HomeController@wardMarker']);
Route::get('{slug}.html', ['as' => 'district-marker', 'uses' => 'HomeController@districtMarker']);


Route::post('/getInfoShop', 'HomeController@getInfoShop');
Route::get('/getdistrict',['as' => 'get-district' , 'uses' => 'HomeController@getDistrictList']);
Route::get('/getward',['as' => 'get-ward' , 'uses' => 'HomeController@getWardList']);
Route::post('/login',['as' => 'do-login' , 'uses' => 'HomeController@doLogin']);
Route::get('/login',['as' => 'login-form' , 'uses' => 'HomeController@loginForm']);
Route::get('/logout',['as' => 'logout', 'uses' => 'HomeController@doLogout']);
Route::post('/doEdit', 'HomeController@doEditMarker');
Route::post('/updatemarker', 'HomeController@updateMarker');
Route::get('/editMarker/{shopid}', 'HomeController@editMarkerUI')->where(['shopid' => '[0-9]+']);
Route::get('/{shopid}', 'HomeController@initPageWithMarker')->where(['shopid' => '[0-9]+']);
Route::get('/getRelate', 'HomeController@getRelateLocation');
