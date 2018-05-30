<?php
//
namespace App\Http\Controllers\Manager;

use App\Handler\MoController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Appname; //!átírni-kibővíteni!!!!!!!!!!!

class NH_DaytypesController extends MoController
{
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOcrud;
    use \App\Handler\trt\redirect\Base;
    use \App\Handler\trt\view\Base;
    

    protected $PAR= [
        'routes' => ['base' => 'admin/users'],
        'view' => ['base' => 'crudbase', 'include' => 'admin.users'],
    ];
    protected $BASE = [
        'obname' => 'app/User', //lehet tömb is ha ha a setobArray trait-et  hívjuk be
    ];

   // protected $val = [ ];
    //protected $val_update = [ ];
}
