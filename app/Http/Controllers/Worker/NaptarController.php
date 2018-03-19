<?php

namespace App\Http\Controllers\Worker;
use App\Handler\MoController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;

use App\Workertime;
use App\Worker;
use App\Workerday;
use App\Timetype;
use App\Daytype;
use App\Day;
//use App\Workerwrole;
//use App\Workerwroleunit;
//use App\Wroletime;
//use App\Workertimewish;
//use App\Wrole;
//use App\Wroleunit;
//use Carbon\Carbon;
class NaptarController extends MoController
{
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOCrud;
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;
    use \App\Handler\trt\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use \App\Handler\trt\property\MoControllerBase; //PAR és BASE propertyk hogy legyen mit kiegéaszíteni
    use \App\Handler\trt\set\Orm; // with, where, order_by
    use \App\Handler\trt\set\GetT;
    //calendár------------------------------------
    use \App\Handler\trt\set\Date; //construktor hívja meg 
    use \App\Handler\trt\get\Day; 
    use \App\Handler\trt\get\Time; 

    protected $par= [
        'create_button'=>false,
        'calendar'=>['view'=>['days' => 'worker.naptar']],
        'search'=>false,
        'routes'=>['base'=>'worker/naptar','worker'=>'manager/worker'],
        //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
        'view' => ['base' => 'crudbase', 'include' => 'worker.naptar'], //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
       // 'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim'=>'Naptár',
        'getT'=>[],       
    ];
  
    protected $base= [
       // 'search_column'=>'daytype_id,datum,managernote,usernote',
        'get'=>['ev'=>null,'ho'=>null], //a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
       // 'get_post'=>['ev'=>null,'ho'=>null],//a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be ha van ilyen kulcs a postban azzal felülírja
        'obname'=>'\App\Workerday',
        'ob'=>null,
        'with'=>['worker','daytype'],
    ];


public function construct_set()
{
        $user_id=\Auth::user()->id ?? 0;
        $worker=Worker::select('id')->where('user_id','=',$user_id)->first();
        $this->BASE['data']['worker_id']=$worker->id ?? 0;
        $this->set_date(); //calendarhoz kell \App\Handler\trt\set\Date; 

}
    public function index_set()
    {

        $user_id=\Auth::user()->id ?? 0;
        $worker=Worker::select('id')->where('user_id','=',$user_id)->first();
        $this->BASE['data']['worker_id']=$worker->id ?? 0;
        $this->BASE['data']['daytype']=Daytype::get()->pluck('name','id');
    //calendar-------------------------------------- 
        $calendar=new \App\Handler\Calendar;
        $this->BASE['data']['calendar']=$calendar->getMonthDays($this->BASE['data']['ev'],$this->BASE['data']['ho']);      
    //\App\Handler\trt\get\Day;    
        $this->BASE['data']['calendar']=array_merge($this->BASE['data']['calendar'],$this->getWorkerday());
    //\App\Handler\trt\get\Time; 
        $this->BASE['data']['calendar']= $this->getWorkertime($this->BASE['data']['calendar']);   
  
    }

}
