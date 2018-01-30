<?php
Route::get('/', function () {
    if(Auth::guest()){ return redirect('login');}
    else{ return redirect('admin');}
});

include 'baseroutes.php';

Auth::routes();