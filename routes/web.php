<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers\Fontend'], function () {
    Route::get('/', 'HomeController@index')->name('client.home.index');
    Route::get('tim-kiem', 'ProductController@search')->name('client.products.search');
    Route::post('tim-kiem', 'ProductController@searchPost');
    Route::prefix('san-pham')->group(function() {
        Route::get('/{categorySlug?}', 'ProductController@index')->name('client.products.index');
        Route::get('chi-tiet/{productSlug}', 'ProductController@detail')->name('client.products.detail');
    });
    Route::get('gio-hang', 'CartController@index');
    Route::get('thong-tin-don-hang', 'CheckoutController@information');
    Route::post('thong-tin-don-hang', 'CheckoutController@informationSave');
    Route::get('phuong-thuc-thanh-toan', 'CheckoutController@payment');
    //ajax
    Route::post('add-to-cart', 'CartController@store');
    Route::post('updateQuantity', 'CartController@updateQuantity');
    Route::post('delete-item-cart', 'CartController@delete');
    Route::post('search-districts', 'CheckoutController@getDistricts');
    Route::post('phuong-thuc-thanh-toan', 'CheckoutController@confirm');

    Route::post('search-wards', 'CheckoutController@getWards');
    Route::post('coupon/verify', 'CouponController@verify');
    Route::post('coupon/remove', 'CouponController@remove');
    Route::post('show-suggestions', 'ProductController@showSuggestions');

});
Route::group(['namespace' => 'App\Http\Controllers\Backend'], function () {
    Route::prefix('admin')->group(function() {
        //Dashboard
        Route::get('/', 'DashboardController@index')->name('admin.dashboard.index');
        //Categories
        Route::prefix('categories')->group(function() {
            Route::get('/', 'CategoryController@index')->name('admin.categories.index');
            Route::post('create', 'CategoryController@store');
            Route::get('edit/{categoryId}', 'CategoryController@edit');
            Route::post('edit/{categoryId}', 'CategoryController@update');
            Route::delete('delete/{categoryId}', 'CategoryController@delete');

        });
        //Products
        Route::prefix('products')->group(function() {
            Route::get('/', 'ProductController@index')->name('admin.products.index');
            Route::get('create', 'ProductController@create')->name('admin.products.create');
            Route::post('create', 'ProductController@store');
            Route::get('edit/{productId}', 'ProductController@edit')->name('admin.products.edit');
            Route::post('edit/{productId}', 'ProductController@update');
            Route::delete('delete/{productId}', 'ProductController@delete');
            Route::post('search', 'ProductController@search');
            Route::post('productSizes', 'ProductController@getProductSizes');
            Route::post('check-code', 'ProductController@checkCode');
        });
        //User
        Route::prefix('users')->group(function() {
            Route::get('/', 'UserController@index')->name('admin.users.index');
            Route::get('create', 'UserController@create')->name('admin.users.create');
            Route::post('create', 'UserController@store');

            Route::get('edit/{userId}', 'UserController@edit')->name('admin.users.edit');
            Route::post('edit/{userId}', 'UserController@update');
            Route::delete('delete/{userId}', 'UserController@delete');
            Route::post('search', 'UserController@search');
        });
    });
});
Route::group(['prefix' => 'filemanager', 'middleware' => ['web']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});