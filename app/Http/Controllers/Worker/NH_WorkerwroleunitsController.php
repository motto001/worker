<?php

namespace App\Http\Controllers\Worker;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
//use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Wrole;

use App\Worker;
use App\Wroleunit;
use Illuminate\Http\Request;
use Session;

class WorkerwroleunitsController extends \App\Handler\MoController
{
use  \App\Handler\trt\crud\CrudWithSetfunc;
use  \App\Handler\trt\SetController;

protected $par= [ 
    //'create_button'=>false,  
    'get_key'=>'wrunit', //láncnál ezzel az előtaggal azonosítja a rávonatkozó get tagokat
    'routes'=>['base'=>'worker/workerwroleunits','workerdays'=>'manager/workerdays/create'],//A _GET ben ['get_key']._ret ben érkező értéket fordítja le routra pl.: wrtime_ret=wru esetén a route  manager/wroleunit lesz
    //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
    'view'=>'worker.workerwroleunits', //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
    'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
    'cim'=>'Felhasználók munkarendjei',  
    'getT'=>[],     
];
protected $base= [
    'search'=>false,
   // 'with'=>'wroleunit',
    'get'=>['wrunit_redir'=>null], //pl:'w_id'=>null a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be 
    'obname'=>'\App\Workerwroleunit',   
];


protected $val= [
    'worker_id' => 'required|integer',
    'wroleunit_id' => 'integer',
    'wish_id' => 'integer',
    'datum' => 'required|date',
    'end' => 'date',
    'pub' => 'integer',
    'note' => 'string|max:150'
  // 'usernote' => 'string|max:150'
];


public function index_set()
{
    $user_id=\Auth::user()->id;
    $worker_id=Worker::select('id')->where('user_id','=',$user_id)->first()->id;
   
    $this->BASE['data']['worker_id']=$worker_id;
  $this->BASE['data']['wrunit']=Wroleunit::pluck('name','id')->toarray();;

    if($worker_id>0){
         $this->BASE['where'][]= ['worker_id', '=', $worker_id]; 
    }  
}


public function create_set()
{  
    $user_id=\Auth::user()->id;
    $worker_id=Worker::select('id')->where('user_id','=',$user_id)->first()->id;
   
    $this->BASE['data']['worker_id']=$worker_id;
    $this->BASE['data']['wrunit']=Wroleunit::pluck('name','id');
 
}
 public function edit_set()
 {
    $this->BASE['data']['wrunit']=Wroleunit::pluck('name','id');
     $this->BASE['data']['wrole']=Wrole::get()->pluck('name','id');
 }
/*
    public function addwrunit()
    {
        $this->BASE['ob']->insert(
        [
        'worker_id' => $this->PAR['getT']['worker_id'], 
        'wrunit_id' => $this->PAR['getT']['wrunit_id'],
        'datum' => $this->PAR['getT']['datum'],
        ]);
        return  redirect(\MoHandF::url($this->PAR['routes']['base'], $this->PAR['getT']));  
   }
    public function delunit()
    {
        $this->BASE['id']=$id;
        $this->BASE['ob_res']= $this->BASE['ob']->destroy($id);
        return  redirect(\MoHandF::url($this->PAR['routes']['base'], $this->PAR['getT']));  
        /*
        $url=\MoHandF::url('manager/wroles/'.$this->PAR['getT']['wrole_id'].'/edit', $this->PAR['getT']);
        header("Location:$url");
        die(); 
         
    }*/
}
