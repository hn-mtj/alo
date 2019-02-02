<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//$this->middleware(['auth:api','authorize'])->group(function() {
    $this->namespace('Admin')->group(function () {

        $this->namespace('Product')->group(function () {
            $this->get('product', 'ProductController@index');
            $this->get('product/show', 'ProductController@show');
            $this->post('product', 'ProductController@store');
            $this->patch('product/{id}', 'ProductController@update');
            $this->get('product/delete', 'ProductController@destroy');
        });

        $this->namespace('Product')->group(function () {
            $this->get('category', 'CategoryController@index');
            $this->get('category/show', 'CategoryController@show');
            $this->post('category', 'CategoryController@store');
            $this->patch('category/{id}', 'CategoryController@update');
            $this->get('category/delete', 'CategoryController@destroy');

        });
    });


    $this->namespace('Seller')->group(function () {

        $this->namespace('Product')->group(function () {
            $this->get('seller/product', 'ProductController@index');
            $this->get('seller/product/show', 'ProductController@show');
            $this->post('seller/product', 'ProductController@store');
            $this->patch('seller/product/{id}', 'ProductController@update');
        });

    });
//});


$this->namespace('User')->group(function () {

    $this->namespace('Address')->group(function () {
        $this->get('user/address', 'UserAddressController@index');
        $this->get('user/address/show', 'UserAddressController@show');
        $this->post('user/address', 'UserAddressController@store');
        $this->patch('user/address/{id}', 'UserAddressController@update');
    });

    $this->namespace('Main')->group(function () {
        $this->get('/', 'ProductController@index');
        $this->get('category/list', 'ProductController@getCategory');

    });

    $this->namespace('Order')->group(function () {
        $this->post('buy', 'OrderController@buyUser');

    });

});
