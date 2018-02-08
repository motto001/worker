<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;

use App\Worker;
use App\User;
use App\Wrole;
use App\Timeframe;
use App\Status;
use App\Workertype;
use App\Workergroup;


class WorkersController extends Controller
{
    use  \App\Handler\trt\Show;


    protected $par= [
        // 'baseroute'=>'manager/wroletimes', // a routes-be kerüt (base)
        'get_key'=>'wworker', //láncnál ezzel az előtaggal azonosítja a rávonatkozó get tagokat
        'routes'=>['base'=>'worker/workers'], //A _GET ben ['get_key']._ret ben érkező értéket fordítja le routra pl.: wrtime_ret=wru esetén a route  manager/wroleunit lesz
         'view'=>'crudbase_3.show', //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
         'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
         'cim'=>'Személyes adatok',
         'show'=>[
             ['colname'=>'id','label'=>'Id'],
             ['colname'=>'name','label'=>'név'],
             ['colname'=>'foto','label'=>'Foto','func'=>'image'],
         ],
        // 'search'=>false,   
     ];



public function index()
    {
        $userid=\Auth::id();
        $data=Worker::where('id','=',$userid)->first();
        $param=$this->par;
        return view($this->par['view'], compact('data','param')); 
    }



}
