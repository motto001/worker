<?php

namespace App\Http\Controllers\Worker;
use App\Handler\MoController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;

use App\Workerday;
use App\Workerdaywish;
use App\Worker;
use App\Daytype;
use App\Day;

//use Carbon\Carbon;
class WorkerdaysWishController extends MoController
{
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOCrud;
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;
    use \App\Handler\trt\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use \App\Handler\trt\property\MoControllerBase; //PAR és BASE propertyk hogy legyen mit kiegéaszíteni
    use \App\Handler\trt\set\Orm; // with, where, order_by
    use \App\Handler\trt\set\GetT;
    protected $par= [
        'create_button'=>false,
        'routes'=>['base'=>'worker/workerdayswish','worker'=>'manager/worker'],
        //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
        'view' => ['base' => 'crudbase', 'include'=>'worker.workerdayswish'], //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim'=>'Dolgozói napok',
        'getT'=>[],       
    ];
  
    protected $base= [
       'get'=>['ev'=>null,'ho'=>null], //a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
       // 'get_post'=>['ev'=>null,'ho'=>null],//a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be ha van ilyen kulcs a postban azzal felülírja
        'obname'=>'\App\Workerdaywish',
        'ob'=>null,
   // 'with'=>['worker','daytype'],
    ];

    protected $val= [
      //  'worker_id' => 'required|integer',
        'daytype_id' => 'integer',
        //'wish_id' => 'integer',
        //'day' => 'integer|max:31',
        'datum' => 'date',
        'managernote' => 'string|max:150'
      //  'usernote' => 'string|max:150'
    ];




}
