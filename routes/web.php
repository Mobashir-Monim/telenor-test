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

Route::get('/test', function () {
    dd(Carbon\Carbon::parse('2019-12-24 11:23:00')->diffInSeconds(Carbon\Carbon::now(), false), Carbon\Carbon::now()->toDateTimeString());
})->name('test');
