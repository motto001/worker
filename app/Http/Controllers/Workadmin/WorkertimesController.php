<?php

namespace App\Http\Controllers\Workadmin;
use App\Handler\MoController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Workertimewish;
use App\Workertime;
use App\Worker;
use App\Daytype;
use App\Timetype;


class WorkertimesController extends MoController
{
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOCrud;
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;
    use \App\Handler\trt\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use \App\Handler\trt\property\MoControllerBase; //PAR és BASE propertyk hogy legyen mit kiegéaszíteni
    use \App\Handler\trt\set\Orm; // with, where, order_by
    use \App\Handler\trt\crud\Task;
    use \App\Handler\trt\set\Date;
    protected $par= [
         'get_key'=>'worktime',
        'routes'=>['base'=>'workadmin/workertimes','worker'=>'manager/worker'],
        //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
        'view' => ['base' => 'crudbase', 'include' => 'workadmin.workertimes',
        'editform' => 'workadmin.workertimes.edit'
        ,'pub' => 'crudbase.index','unpub' => 'crudbase.index'
    ], //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
      //  'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim'=>'Munkaidők',
        'getT'=>[],  
        

    ];
  
    protected $base= [
       // 'search_column'=>'daytype_id,datum,managernote,usernote',
        'get'=>['ev'=>null,'ho'=>null], //a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
       // 'get_post'=>['ev'=>null,'ho'=>null],//a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be ha van ilyen kulcs a postban azzal felülírja
        'obname'=>'\App\Workertime',
        'ob'=>null,
     // 'orm'=> ['where'=>[['pub','1'],['datum','2018-03-05']]],

    ];



public function search(){
    $this->BASE['ob_base']=  $this->BASE['ob_base']->where('day_id', 'LIKE', "%$keyword%")
    ->orWhere('timetype_id', 'LIKE', "%$keyword%")
    ->orWhere('start', 'LIKE', "%$keyword%")
    ->orWhere('end', 'LIKE', "%$keyword%")
    ->orWhere('hour', 'LIKE', "%$keyword%")
    ->orWhere('managernote', 'LIKE', "%$keyword%")
    ->orWhere('workernote', 'LIKE', "%$keyword%");

    }


     protected $val= [
         'worker_id' => 'required|integer',
         'timetype_id' => 'required|integer',
         'datum' => 'required|date',
         'start' => 'required|date_format:H:i',
         'end' => 'date_format:H:i',
         'hour' => 'required|integer|max:24',
         'managernote' => 'string|max:200|nullable',
         'workernote' => 'string|max:200|nullable',
         'pub' => 'integer' 
     ];
     public function construct_set()
     {  
        $request= $this->BASE['request'];
           if($request->ev){  
            $this->BASE['orm']['where'][]=['datum','like',$request->ev.'%']; 
           }
           if($request->ho!=0){  
            if(strlen($request->ho)<2){
                $ho='0'.$request->ho;
            }else{$ho=$request->ho;}
            $this->BASE['orm']['where'][]=['datum','like','%-'.$ho.'-%']; 
           } 
            if($request->worker_id!=0){  
           //  $worker=Worker::select('id')->where('user_id','=',$request->user_id)->first();
           //  if($worker){}
         $this->BASE['orm']['where'][]=['worker_id',$request->worker_id]; 
           }

     }/*
     public function table()
     {
        $user_id = \Auth::id();
        $this->BASE['data']['worker_id']=Worker::select('id')->where('user_id','=',$user_id)->first()->id;
        $this->BASE['where'][]= ['worker_id', '=', $this->BASE['data']['worker_id']]; 
        $this->BASE['data']['workers']=\App\User::pluck('name','id');
        $this->BASE['data']['workers'][0]='Minden dolgozó';
        $this->set_date(); //ev_ho.blade használja
        if (method_exists($this, 'set_orm')) {
            $this->BASE['ob']= $this->set_orm($this->BASE['ob']);
        }
        $this->BASE['data']['list'] = $this->BASE['ob']->paginate(50);
       // if (!empty($getT)) {$this->BASE['data']['list']->appends($getT);}

        $data=$this->BASE['data'];
     return view($this->PAR['view']['base'] . '.index', compact('data'));
  
     }*/
   
     public function index_set()
     {
      //  exit();
        $user_id = \Auth::id();
        $this->BASE['data']['worker_id']=Worker::select('id')->where('user_id','=',$user_id)->first()->id;
        $this->BASE['where'][]= ['worker_id', '=', $this->BASE['data']['worker_id']]; 
        $workers=\App\Worker::with('user')->get();
       $this->BASE['data']['workers'][0]='Minden dolgozó'; 
        foreach($workers as $worker){
            $this->BASE['data']['workers'][$worker->id]=$worker->user->name;
        }
        
        $this->set_date(); //ev_ho.blade használja
     //   exit();
  
     }
     public function create_set()
     {
        $user_id = \Auth::id();
        $this->BASE['data']['worker_id']=Worker::select('id')->where('user_id','=',$user_id)->first()->id;
         $this->BASE['data']['timetype']= Timetype::pluck('name','id');
 //print_r($this->PAR['getT']);
     }
 
     public function edit_set()
     {  
         $this->BASE['data']['timetype']= Timetype::pluck('name','id');
     }
 

}