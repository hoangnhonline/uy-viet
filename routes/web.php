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
Route::group(['namespace' => 'Backend', 'prefix' => 'backend', 'middleware' => 'isAdmin'], function()
{    
    Route::get('dashboard', ['as' => 'dashboard.index', 'uses' => "ShopVonController@dashboard"]);
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
    });
});


Route::get('/', 'HomeController@initPage');
Route::get('/location', 'HomeController@findItem');
Route::post('/getInfoShop', 'HomeController@getInfoShop');
Route::get('/getdistrict', 'HomeController@getDistrictList');
Route::get('/getward', 'HomeController@getWardList');
Route::post('/login', 'HomeController@doLogin');
Route::get('/logout', 'HomeController@doLogout');
Route::post('/doEdit', 'HomeController@doEditMarker');
Route::post('/updatemarker', 'HomeController@updateMarker');
Route::get('/editMarker/{shopid}', 'HomeController@editMarkerUI')->where(['shopid' => '[0-9]+']);
Route::get('/{shopid}', 'HomeController@initPageWithMarker')->where(['shopid' => '[0-9]+']);
Route::get('/getRelate', 'HomeController@getRelateLocation');
