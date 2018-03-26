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
    use \App\Handler\trt\crud\Task; // GET-el vezérelt taskok futtatása
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;
    use \App\Handler\trt\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg vagy vannak tas függő patraméterek
    use \App\Handler\trt\property\MoControllerBase; //PAR és BASE propertyk hogy legyen mit kiegéaszíteni
    use \App\Handler\trt\set\Orm; // with, where, order_by
    use \App\Handler\trt\set\GetT;
   
    //calendár------------------------------------
    use \App\Handler\trt\set\Date; //construktor hívja meg 
    use \App\Handler\trt\get\Day; 
    use \App\Handler\trt\get\Time; 

    protected $par= [
       // 'create_button'=>false,
       'cancel_button'=>false,
       'formopen_in_crudview'=>false,
        'calendar'=>['view'=>['days' => 'worker.naptar.days']],
        'search'=>false,
        'routes'=>['base'=>'worker/naptar','worker'=>'manager/worker'],
        //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
        'view' => ['base' => 'crudbase', 'include' => 'worker.naptar'], //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
       // 'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim'=>'Naptár',
        'getT'=>[],       
    ];
    protected $tpar= [
        'index'=>['calendar'=>[
            'view' => ['days' => 'worker.naptar.days'],
            //'ev_ho'=>false, //kikapcsolja az év hó válastó mezőt
        ]],
        'create'=>['calendar'=>[
            'view' => ['days' => 'worker.naptar.editdays'],
           // 'ev_ho'=>false, //kikapcsolja az év hó válastó mezőt
            'checkbutton'=>true, //kikapcsolja az év hó válastó mezőt
            'pdf_print'=>false, 
        ]], 
    ];
    protected $base= [
       // 'search_column'=>'daytype_id,datum,managernote,usernote',
        'get'=>['ev'=>null,'ho'=>null], //a  set_getT automatikusan fltölti a getbőll a $this->PAR['getT']-be
        'post_to_getT'=>['ev'=>null,'ho'=>null],//a set_getT automatikusan fltölti a postból a $this->PAR['getT']-be
        'obname'=>'\App\Workerday',
        'ob'=>null,
        'with'=>['worker','daytype'],
    ];

// a beállító függvények utám fut le ,előtte a base használatos de ha azt felülírjuk gondoskodni kell az eredeti futtatásáról is
public function construct_set()
{
        $user_id=\Auth::user()->id ?? 0;
        $worker=Worker::select('id')->where('user_id','=',$user_id)->first();
        $this->BASE['data']['worker_id']=$worker->id ?? 0;
       // echo  $this->BASE['data']['worker_id'].'-------------mmmmmmm'; exit(); 
        $this->set_date(); //calendarhoz kell \App\Handler\trt\set\Date; 
     //   echo  $this->PAR['basetask'];
   //  print_r( $this->PAR['view'] );
;
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
    public function create_set()
    {

        $this->BASE['data']['daytype']=Daytype::get()->pluck('name','id');
        $this->BASE['data']['timetype']=Timetype::get()->pluck('name','id');
    //calendar-------------------------------------- 
        $calendar=new \App\Handler\Calendar;
        $this->BASE['data']['calendar']=$calendar->getMonthDays($this->BASE['data']['ev'],$this->BASE['data']['ho']);      
    //\App\Handler\trt\get\Day;    
        $this->BASE['data']['calendar']=array_merge($this->BASE['data']['calendar'],$this->getWorkerday());
    //\App\Handler\trt\get\Time; 
        $this->BASE['data']['calendar']= $this->getWorkertime($this->BASE['data']['calendar']);   
  
    }
    public function store(Request $request)
    {  
      
        if(isset($this->val)){
           $this->validate($request,$this->val );  
        }

 
        if($request->has('daytypechange')){ 
            $daytypedata=[
                'daytype_id'=>$request->daytype_id,
                'workernote'=>$request->workernote,
            ];
            $daytypedata['worker_id']=$this->BASE['data']['worker_id'];
    //print_r($request->all());  echo '-------------mmmmmmm'; exit(); 
            foreach ($request->datum as $datum) {
                $daytypedata['datum']=$datum;
               // $daytypebase = Workerday::where(['worker_id' =>$this->BASE['data']['worker_id'],'datum' =>$datum,'pub' =>0]);

            //  $dt_id=$daytypebase->daytype_id ?? 'nincs';

            //   if($dt_id != $daytypedata['daytype_id'])
            //   { 
                    $daytype = Workerday::firstOrCreate(['worker_id' =>$this->BASE['data']['worker_id'],'datum' =>$datum,'pub' =>1]);        
                     $daytype->update($daytypedata); 
           //    }   
              
            }
        
        }
        if($request->has('daytypedel')){ 

            foreach ($request->datum as $datum) {
                
                $daytype = Workerday::where(['worker_id' =>$this->BASE['data']['worker_id'],'datum' =>$datum,'pub' =>1]);     
                $daytype->delete(); 
            }
        
        }
        if($request->has('timeadd')){ 
            $timeT=$request->only(['start', 'end', 'timetype_id']);
            $timeT['worker_id']=$this->BASE['data']['worker_id'];
             $timeT['workernote']=$request->workernote2;
    //print_r($request->all());  echo '-------------mmmmmmm'; exit(); 
            foreach ($request->datum as $datum) {
 
                $timeT['datum']=$datum;
               $time = Workertime::create($timeT);     
               // $daytype->update($timeT); 
            }

    }  
    if($request->has('timedel')){ 

        foreach ($request->datum as $datum) {
           
            $time = Workerday::where(['worker_id' =>$this->BASE['data']['worker_id'],'datum' =>$datum,'pub' =>1]);     
            $time->delete(); 
        }
    
    }
    session(['datum' => $request->datum]);
return redirect(\MoHandF::url($this->PAR['routes']['base'].'/create',$this->PAR['getT'])); 
    }

}
