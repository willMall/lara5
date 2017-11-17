<?php

Auth::routes();

Route::any('/notify', 'WechatController@notify');
Route::post('/notify/payment', 'WechatController@payment');

Route::middleware(['wechat.oauth:snsapi_userinfo', 'wechat.user'])->group(function () {
    Route::get('/app', 'AppController@index');
    Route::get('/category/api/{id}', 'CategoryController@api');
    Route::get('/category', 'CategoryController@index');
    Route::get('/item/{id}', 'ItemController@index');
    Route::resource('cart', 'CartController', ['only' => ['index', 'store']]);
    Route::get('cart/api', 'CartController@api');
});

Route::prefix('member')->namespace('Member')->middleware(['wechat.oauth:snsapi_userinfo', 'wechat.user'])->group(function () {
    Route::get('/', 'IndexController@index');
    Route::get('/address/api', 'AddressController@api');
    Route::resource('/address', 'AddressController');
    Route::get('/payment/', 'PaymentController@index');
    Route::get('/order/api', 'OrderController@api');
    Route::resource('order', 'OrderController', ['only' => ['index', 'store']]);
});

Route::prefix('dashboard')->namespace('Dashboard')->middleware(['role:admin','auth'])->group(function () {
    Route::get('/', 'IndexController@index');
    Route::get('/password', 'IndexController@password');
    Route::post('/password', 'IndexController@update');
    //用户
    Route::get('user', 'UserController@index');
    Route::post('user/userroleadd', 'UserController@userroleadd');
    Route::post('user/roleadd', 'UserController@roleadd');
    //分类
    Route::get('category', 'CategoryController@index');
    Route::get('category/create', 'CategoryController@create');
    Route::post('category/create', 'CategoryController@store');
    Route::get('category/edit/{id}.html', 'CategoryController@edit');
    Route::post('category/edit', 'CategoryController@update');
    Route::post('category/destroy', 'CategoryController@destroy');
    Route::post('category/moved', 'CategoryController@moved');
    //商品
    Route::get('item', 'ItemController@index');
    Route::get('item/create', 'ItemController@create');
    Route::post('item/create', 'ItemController@store');
    Route::get('item/edit/{id}.html', 'ItemController@edit');
    Route::post('item/edit', 'ItemController@update');
    Route::get('item/show/{id}.html', 'ItemController@show');
    Route::post('item/destroy', 'ItemController@destroy');
    Route::get('item/upload/{id}.html', 'ItemController@upload');
    Route::post('item/upload', 'ItemController@uploader');
    Route::post('item/getpic', 'ItemController@getpic');

    // Upload
    Route::post('file/upload', 'FileController@upload');
    Route::post('file/delete', 'FileController@delete');

    //商品推荐
    Route::get('recommend', 'RecommendController@index');
    Route::get('recommend/show', 'RecommendController@show');
    Route::post('recommend/create', 'RecommendController@store');
    Route::post('recommend/destroy', 'RecommendController@destroy');
    Route::post('recommend/sort', 'RecommendController@sort');

    //订单管理
    Route::get('order', 'OrderController@index');
    Route::get('order/show/{id}.html', 'OrderController@show');
    Route::post('order/send', 'OrderController@send');

    //广告管理
    Route::resource('/ads', 'AdsController',['except'=>'show']);
    Route::post('ads/delete', 'AdsController@delete');
    //公告管理
    Route::resource('/notice', 'NoticeController');
});
