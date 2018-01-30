<?php
use Illuminate\Support\Facades\Auth;
Route::get('/', function () {
    if(Auth::guest()){ return redirect('login');}
    else{ return redirect('admin');}
});
Route::get('', function () {
    if(Auth::guest()){ return redirect('login');}
    else{ return redirect('admin');}
});
include 'baseroutes.php';

Auth::routes();
/*
Route::get('/home', 'HomeController@index')->name('home');
Route::get('cors/login', 'AuthController@authenticate');
Route::get('cors/logout', 'AuthController@logout');

*/







