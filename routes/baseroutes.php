<?php
/*
Route::get('admin','Admin\AdminController@index',function(){

})->middleware('checklogin');
*/

Route::group(['prefix' => '/admin','middleware' => ['auth', 'roles'], 'roles' => 'worker'],function()
{
    Route::resource('/', 'Admin\AdminController'); 
});   
//root-----------------------------------------------------------
Route::group(['prefix' => '/root','middleware' => ['auth', 'roles'], 'roles' => 'admin'],function()
{
   
    Route::resource('/proba', 'Admin\ProbaController');
   
    Route::resource('/users', 'Admin\UsersController');
    
    Route::resource('/conf', 'Admin\ConfController');  
    Route::resource('/roles', 'Admin\RolesController');
    Route::resource('/permissions', 'Admin\PermissionsController'); 
    Route::get('/give-role-permissions', 'Admin\AdminController@getGiveRolePermissions');
    Route::get('/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);

});
//manageer---------------------------------------------------------------
Route::group(['prefix' => '/manager','middleware' => ['auth', 'roles'], 'roles' => 'manager'],function()
{
    Route::resource('/users', 'Manager\\UsersController');
    //Route::resource('/workers', 'Manager\\WorkersController');
    Route::resource('/workers', 'Manager\\WorkersController');
    Route::resource('/workerusers', 'Manager\\WorkerusersController');
    Route::resource('/workergroups', 'Manager\\WorkergroupsController');
    Route::resource('/workertypes', 'Manager\\WorkertypesController');
    Route::resource('/statuses', 'Manager\\StatusesController');

    Route::resource('/days', 'Manager\\DaysController');
    Route::resource('/userdays', 'Manager\\UserdaysController');
    Route::resource('/daytypes', 'Manager\\DaytypesController');
    Route::resource('/timeframes', 'Manager\\TimeframesController');
    Route::resource('/timetypes', 'Manager\\TimetypesController');
    
    Route::resource('/wroles', 'Manager\\WrolesController');

    Route::resource('/wroleunits', 'Manager\\WroleunitsController');
    Route::get('/wroleunit-show-to-modal/{wrole_id}', 'Manager\\WroleunitsController@showToModal');
    Route::get('/wroleunit-add-to-wrole-modal/{wrole_id}', 'Manager\\WroleunitsController@wroleunitToModal');
    
    Route::get('/wroleunit-select-to-save/{wroleunit_id}/{wrole_id}', 'Manager\\WrolesController@wroleunitSelectToSave');
    Route::get('/wroleunit-to-del/{wroleunit_id}/{wrole_id}', 'Manager\\WrolesController@wroleunitToDel');
    
    Route::resource('/wroletimes', 'Manager\\WroletimesController');
    Route::resource('/wroletimes-to-unit', 'Manager\\WroletimesToUnitController');
  //  Route::get('/wroletimes-to-unit/index2/{unit_id}', 'Manager\\WroletimesToUnitController@index2'); 
   // Route::get('/wroletimes-to-unit/create2/{unit_id}', 'Manager\\WroletimesToUnitController@create2'); 
});
//workadmin---------------------------------------------------------------
Route::group(['prefix' => '/workadmin','middleware' => ['auth', 'roles'], 'roles' => 'workadmin'],function()
{

    Route::resource('/workerdays', 'Workadmin\\WorkerdaysController');
    Route::resource('/workertimeswish', 'Workadmin\\WorkertimeswishController');
    Route::resource('/workertimes', 'Workadmin\\WorkertimesController');
    Route::resource('/workerwroles', 'Workadmin\\WorkerwrolesController');
    Route::resource('/workertimeframes', 'Workadmin\\WorkertimeframesController');
    Route::resource('/workertimes', 'Workadmin\\WorkertimesController');
    Route::resource('/workerwroleunit', 'Workadmin\\WorkerwroleunitsController');
});
Route::group(['prefix' => '/worker','middleware' => ['auth', 'roles'], 'roles' => 'worker'],function()
{ 
    Route::resource('/workerwroleunits', 'Worker\\WorkerwroleunitsController');
    Route::resource('/workertimeswish', 'Worker\\WorkertimeswishController');
    Route::resource('/workerdays', 'Worker\\WorkerdaysController');
    Route::resource('/personal', 'Worker\\WorkersController');
    
  //  Route::get('/worktimes/{year}/{month}/{day}/{user}', 'Worker\\WorktimesController@index2');
  //  Route::get('/worktimes/create/{year}/{month}/{day}/{user}', 'Worker\\WorktimesController@create');
});
//----------------------------------------------------------------
Route::group(['prefix' => '/user','middleware' => ['auth', 'roles'], 'roles' => 'admin'],function()
{
    Route::resource('/chpassword', 'User\\ChpasswordController');
    Route::resource('/chemail', 'User\\ChemailController');
    //Route::resource('/personal', 'User\\PersonalController');
});
