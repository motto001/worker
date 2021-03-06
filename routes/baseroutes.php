<?php
/*
Route::get('admin','Admin\AdminController@index',function(){

})->middleware('checklogin');
*/

Route::group(['prefix' => '/admin','middleware' => ['auth', 'roles'], 'roles' => 'workadmin'],function()
{
    Route::resource('/', 'Admin\AdminController'); 
});  
Route::group(['prefix' => '/','middleware' => ['auth', 'roles'], 'roles' => 'worker'],function()
{
    Route::resource('/', 'Admin\AdminController'); 
});  
//root-----------------------------------------------------------
Route::group(['prefix' => '/root','middleware' => ['auth', 'roles'], 'roles' => 'admin'],function()
{
  Route::get('/info/{dir}/{file}',  'admin\\InfoController@index');  
  //  Route::resource('/proba', 'Admin\ProbaController');
 //   Route::resource('/users', 'Admin\UsersController');  
    Route::resource('/conf', 'Admin\\ConfController');  
    Route::resource('/roles', 'Admin\\RolesController');
//    Route::resource('/permissions', 'Admin\PermissionsController'); 
//    Route::get('/give-role-permissions', 'Admin\AdminController@getGiveRolePermissions');
//    Route::get('/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);

});
//manageer---------------------------------------------------------------
Route::group(['prefix' => '/manager','middleware' => ['auth', 'roles'], 'roles' => 'manager'],function()
{
  Route::get('/info/{dir}/{file}',  'manager\\InfoController@index');  
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
  Route::get('/info/{dir}/{file}',  'workadmin\\InfoController@index');  
    Route::resource('/savecal', 'Workadmin\\SavecalsController');
    Route::get('/savecal/calendar/{id}', 'Workadmin\\SavecalsController@calendar');
    Route::get('/savecal/solver/{id}', 'Workadmin\\SavecalsController@solver');

    Route::resource('/groups', 'Workadmin\\GroupsController');
    Route::any('/groups/show2/{id}', 'Workadmin\\GroupsController@show2');
    Route::any('/groups/calendar/{id}', 'Workadmin\\GroupsController@calendar');
    Route::any('/groups/calendarsave/{id}', 'Workadmin\\GroupsController@calendarsave'); 

    Route::resource('/workerdaytimes', 'Workadmin\\WorkerdaytimesController');
    Route::any('/workerdaytimes/calendar/{id}', 'Workadmin\\WorkerdaytimesController@calendar');
    Route::any('/workerdaytimes/calendarsave/{id}', 'Workadmin\\WorkerdaytimesController@calendarsave'); 

  //  Route::resource('/grouptimes', 'Workadmin\\GrouptimesController');
  Route::post('/workertimes', 'Workadmin\\WorkertimesController@index');
  Route::post('/workertimes/create', 'Workadmin\\WorkertimesController@create');
  Route::resource('/workertimes', 'Workadmin\\WorkertimesController', ['except' => ['store']]);

    Route::resource('/workerdays', 'Workadmin\\WorkerdaysController');
    Route::resource('/workerwroles', 'Workadmin\\WorkerwrolesController');
    Route::resource('/workertimeframes', 'Workadmin\\WorkertimeframesController');

    Route::get('/wroles/info/{view}', 'Workadmin\\WrolesController@info');
    Route::resource('/wroles', 'Workadmin\\WrolesController');

   Route::any('/wroles/addtime/{wroleid}', 'Workadmin\\WrolesController@addtime');
   Route::any('/wroles/deltime/{timeid}/{wroleid}', 'Workadmin\\WrolesController@deltime'); 
});
Route::group(['prefix' => '/worker','middleware' => ['auth', 'roles'], 'roles' => 'worker'],function()
{ 
  Route::get('/info/{dir}/{file}',  'worker\\InfoController@index');  
    Route::resource('/workerwroleunits', 'Worker\\WorkerwroleunitsController');
  //  Route::resource('/workerdayswish', 'Worker\\WorkertimeswishController');
    Route::resource('/workertimes', 'Worker\\WorkertimesController');
    Route::resource('/workerdays', 'Worker\\WorkerdaysController');
    Route::resource('/naptar', 'Worker\\NaptarController');
  Route::get('/naptarpdf', 'Worker\\NaptarController@pdf');

    Route::resource('/personal', 'Worker\\WorkersController');
    Route::get('/chpasswd', 'Worker\\WorkersController@chPasswd');
    Route::any('/updatepasswd', 'Worker\\WorkersController@updatePasswd');
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
