<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index')->name('home.index');

Route::prefix('book')->group(function () {
    Route::get('/{id}', 'BookController@detail')->name('book.detail');
});

Route::prefix('cart')->group(function () {
    Route::get('/', 'CartController@show')->name('cart.show');
    Route::post('/add-cart', 'CartController@addBookToCart')->name('cart.add_to_cart');
    Route::post('/delete-cart', 'CartController@deleteBookInCart')->name('cart.delete_to_cart');

    Route::middleware(['custom_auth'])->group(function () {
        Route::post('/borrow_book', 'CartController@borrowBook')->name('cart.borrow_book');
    });
});

Route::middleware(['custom_auth'])->prefix('orders')->group(function () {
    Route::get('/', 'OrderController@index')->name('orders.index');
});

Route::prefix('user')->group(function () {
    Route::get('login', 'UserController@loginView')->name('user.login.show');
    Route::get('signup', 'UserController@signupView')->name('user.signup.show');
    Route::post('login', 'UserController@login')->name('user.login');
    Route::post('signup', 'UserController@signup')->name('user.signup');
    Route::middleware(['custom_auth'])->group(function () {
        Route::get('/logout', 'UserController@logout')->name('user.logout');
    });
});
