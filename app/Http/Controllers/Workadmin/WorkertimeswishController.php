<?php

namespace App\Http\Controllers\Workadmin;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Handler\MoController;

use App\Workertime;
use App\Workertimewish;
use App\Worker;
use App\User;
use App\Daytype;
use App\Timetype;
use Illuminate\Http\Request;
use Session;

class WorkertimeswishController extends MoController
{
    use \App\Handler\trt\crud\CrudWithSetfunc;
    use  \App\Handler\trt\SetController;

    protected $par= [
         'get_key'=>'worktime',
        'routes'=>['base'=>'workadmin/workertimeswish','worker'=>'manager/worker'],
        //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
        'view'=>'workadmin.workertimeswish', //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim'=>'Munkaidőkérelmek',
        'getT'=>[],  
        'create_button'=>false,
    ];
  
    protected $base= [
       // 'search_column'=>'daytype_id,datum,managernote,usernote',
        'get'=>['ev'=>null,'ho'=>null], //a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
       // 'get_post'=>['ev'=>null,'ho'=>null],//a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be ha van ilyen kulcs a postban azzal felülírja
        'obname'=>'\App\Workertimewish',
        'ob'=>null,
       // 'func'=>[  'set_task', 'set_getT','set_date', 'set_redir','set_routes','set_ob'],
        'with'=>['worker','timetype'],

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
     public function set_baseparam()
     {
         
     }
     public function index_set()
     {
        $user_id = \Auth::id();
        $this->BASE['data']['worker_id']=Worker::select('id')->where('user_id','=',$user_id)->first()->id;
        //$this->BASE['data']['user']=User::get()->pluck('name','id');
       // print_r($this->BASE['data']['user']);
        $this->BASE['where'][]= ['worker_id', '=', $this->BASE['data']['worker_id']]; 

     }
   
 
    public function create(){}
    public function store(){}    
    public function edit($id){}
    public function update($id,Request $request){}   
    public function show($id){} 
    public function destroy($id){}            
 
     public function pub()
     { 
         //workertimewish publikálás----------
        $id=Input::get('id');
        $this->BASE['ob_res']=$this->BASE['ob']->findOrFail($id);
        $this->BASE['ob_res']->update(['pub'=>0]);
        
        $data=$this->BASE['ob']->findOrFail($id)->toarray();//workertimewish adatok
       $workertimeob= Workertime::where('wish_id','=',$id);
       $workertime= Workertime::where('wish_id','=',$id)->first();
    $workertimeid=$workertime->id ?? 0;
        if($workertimeid>0)
        {
           
            $workertimeob->update(['pub'=>0]);
           
        
        }
        else
        {  
            $data['wish_id']=$id;
            $data['pub']=0;
            if(isset($data['managernote'])){unset($data['managernote']);}
            if(isset($data['workernote'])){unset($data['workernote']);} 
            $workertimeob->create($data);
        }
         Session::flash('flash_message',  trans('mo.item_pub'));
          return $this->base_redirect();
     }
     public function unpub()
     { 
        $id=Input::get('id');

        $this->BASE['ob_res']=$this->BASE['ob']->findOrFail($id);
        $this->BASE['ob_res']->update(['pub'=>2]);
        
        $workertime= Workertime::where('wish_id','=',$id)->first();
     $workertimeid=$workertime->id ?? 0;
         if($workertimeid>0)
         {
             $workertimeob= Workertime::where('wish_id','=',$id);
            $workertimeob->update(['pub'=>1]);
         }
      
        Session::flash('flash_message',  trans('mo.item_pub'));
         return $this->base_redirect();
     }

 
}