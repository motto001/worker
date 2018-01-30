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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

include 'web.php';

*/
Route::group(['prefix' => '/admin'],function()
{
    Route::get('', 'Admin\AdminController@index');
    Route::resource('/roles', 'Admin\RolesController');
    Route::resource('/users', 'Admin\UsersController');
    Route::resource('/permissions', 'Admin\PermissionsController'); 
    Route::get('/give-role-permissions', 'Admin\AdminController@getGiveRolePermissions');
    Route::get('/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
    Route::post('/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);   
});
Auth::routes();