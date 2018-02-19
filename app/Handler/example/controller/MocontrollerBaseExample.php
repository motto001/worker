<?php
namespace App\Http\Controllers\Manager; //átírni!!!!!!!!!!!!!!!!!!!!!!!!!!!!
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Handler\MoController;
use Illuminate\Http\Request;
use Session;
//use App\Role; //átírni!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//use App\User;
class UsersController extends MoController
{
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOCrud;
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;
    use \App\Handler\trt\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use \App\Handler\trt\property\MoControllerBase; //PAR és BASE propertyk hogy legyen mit kiegéaszíteni
    use \App\Handler\trt\set\Orm; // with, where, order_by
   
   
    protected $par= [
        'routes'=>['base'=>'manager/users'],
        'view'=> ['base' => 'crudbase', 'include' => 'Manager.users','editform' => 'Manager.users.edit_form'], //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        'cim'=>'',  
    ];
  
    protected $base= [
    'obname'=>'\App\User',
    'orm'=>[
        'with'=>['roles','Worker'],
        'where'=>[['id','=','1'],['name','=','admin']],
        'orwhere'=>[['id','=','2'],['id','<>','3']],
        'order_by'=>['id'=>'desc','name'=>'asc']
],
    ];

   // protected $val = []; //pl.:['wroleunit_id' => 'required|integer','end' => 'date_format:H:i','note' => 'string|max:200|nullable']
   
   // protected $val_update = [];
}

