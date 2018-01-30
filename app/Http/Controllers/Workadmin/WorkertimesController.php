<?php

namespace App\Http\Controllers\Workadmin;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Handler\MoController;
use App\Workertimewish;
use App\Workertime;
use App\Worker;
use App\Daytype;
use App\Timetype;
use Illuminate\Http\Request;
use Session;

class WorkertimesController extends MoController
{
    use \App\Handler\trt\crud\CrudWithSetfunc;
    use  \App\Handler\trt\SetController;

    protected $par= [
         'get_key'=>'worktime',
        'routes'=>['base'=>'workadmin/workertimes','worker'=>'manager/worker'],
        //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
        'view'=>'workadmin.workertimes', //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim'=>'Munkaidők',
        'getT'=>[],  
        

    ];
  
    protected $base= [
       // 'search_column'=>'daytype_id,datum,managernote,usernote',
        'get'=>['ev'=>null,'ho'=>null], //a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
       // 'get_post'=>['ev'=>null,'ho'=>null],//a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be ha van ilyen kulcs a postban azzal felülírja
        'obname'=>'\App\Workertime',
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
        $this->BASE['where'][]= ['worker_id', '=', $this->BASE['data']['worker_id']]; 

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
 
     public function pub()
     { 
         $id=Input::get('id');

         $this->BASE['ob_res']=$this->BASE['ob']->findOrFail($id);
 
        $this->BASE['ob_res']->update(['pub'=>0]);
        $wish_id=$this->BASE['ob_res']->wish_id;
        if($wish_id>0)
        {
            $wishtime=Workertimewish::findOrFail($wish_id); 
            $wishtime->update(['pub'=>0]);
        }
 
         Session::flash('flash_message',  trans('mo.item_pub'));
          return $this->base_redirect();
     }
     public function unpub()
     { 
        $id=Input::get('id');

        $this->BASE['ob_res']=$this->BASE['ob']->findOrFail($id);

        $this->BASE['ob_res']->update(['pub'=>1]);

        $wish_id=$this->BASE['ob_res']->wish_id;
        if($wish_id>0)
        {
            $wishtime=Workertimewish::findOrFail($wish_id); 
            $wishtime->update(['pub'=>2]);
        }
        Session::flash('flash_message',  trans('mo.item_pub'));
         return $this->base_redirect();
     }

     public function destroy($id)
     { 
         $this->BASE['id']=$id;
         $wish_id=$this->BASE['ob']->wish_id;
         $this->BASE['ob_res']= $this->BASE['ob']->destroy($id);
         
         if($wish_id>0)
         {
             $wishtime=Workertimewish::findOrFail($wish_id); 
             $wishtime->update(['pub'=>2]);
         }
         Session::flash('flash_message', trans('mo.deleted'));
        return $this->base_redirect();
     }
}