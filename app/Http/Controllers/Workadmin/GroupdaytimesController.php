<?php

namespace App\Http\Controllers\Workadmin;
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
use App\Group;
//use Carbon\Carbon;

class GroupdaytimesController extends MoController
{
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOCrud;//crud functiok indey nélkül
    use \App\Handler\trt\crud\Task; // GET-el vezérelt taskok futtatása
    use \App\Handler\trt\view\Base; //mo_view()
    use \App\Handler\trt\redirect\Base;//mo_redirect()
    use \App\Handler\trt\property\MoControllerBase; //PAR és BASE propertyk hogy legyen mit kiegéaszíteni
    use \App\Handler\trt\set\Orm; // with, where, order_by stb
    use \App\Handler\trt\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg 
    use \App\Handler\trt\set\GetT;
    use \App\Handler\trt\set\Date;
    use \App\Handler\trt\get\Day;
    use \App\Handler\trt\get\Time;


    protected $par= [
       // 'create_button'=>false,
        'search'=>false,
        'routes'=>['base'=>'workadmin/groupdaytimes'],
        //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
        'view' => ['base' => 'crudbase', 'include' => 'workadmin.groupdaytimes',
        'workermodal' => 'workadmin.groupdaytimes.workermodal','addworker' => 'crudbase.edit'], //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
       // 'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim'=>'Naptár',
        'getT'=>[],       
    ];
  
    protected $base= [
       // 'search_column'=>'daytype_id,datum,managernote,usernote',
        'get'=>['ev'=>null,'ho'=>null,'group_id'=>null,'worker_id'=>null,'edittask'=>null], //a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
       // 'get_post'=>['ev'=>null,'ho'=>null],//a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be ha van ilyen kulcs a postban azzal felülírja
        'obname'=>'\App\Group',
        'ob'=>null,
       'orm'=>[ 'with'=>['worker']],
    ];





public function construct_set()
{
    $this->set_date();
}
    public function index_set()
    {

    }

    public function edit_set()
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
