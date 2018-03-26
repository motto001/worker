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

class WorkerdaytimesController extends MoController
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
        'create_button'=>false,
       //'cancel_button'=>true,
        'search'=>false,
        'routes'=>['base'=>'workadmin/workerdaytimes'],
        //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
        'view' => ['base' => 'crudbase', 'include' => 'workadmin.workerdaytimes',
        'workermodal' => 'workadmin.workerdaytimes.workermodal'], //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
       // 'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim'=>'Naptár',
        'getT'=>[], 
        'show'=>[
            ['colname'=>'id','label'=>'Id'],
            ['colname'=>'fullname','label'=>'név'],
            ['colname'=>'foto','label'=>'Foto','func'=>'image'],
            ['colname'=>'cim','label'=>'Cím'],
            ['colname'=>'birth','label'=>'Születési dátum'],
            ['colname'=>'tel','label'=>'Telefon'],
            ['colname'=>'ado','label'=>'Adószám'],
            ['colname'=>'tb','label'=>'TBszám'],
            ['colname'=>'start','label'=>'Kezdés'],
           ]    
    ];
  
    protected $base= [
       // 'search_column'=>'daytype_id,datum,managernote,usernote',
        'get'=>['ev'=>null,'ho'=>null,'worker_id'=>null,'edittask'=>null], //a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
        'post_to_getT'=>['ev'=>null,'ho'=>null],
        'obname'=>'\App\Worker',
        'ob'=>null,
       'orm'=>[ 'with'=>['workerday','workertime']],
    ];

    protected $tpar= [
     
        'edit'=>['calendar'=>[
            'view' => ['days' => 'workadmin.workerdaytimes.editdays'],
           // 'ev_ho'=>false, //kikapcsolja az év hó válastó mezőt
            'checkbutton'=>true, //kikapcsolja az év hó válastó mezőt
            'pdf_print'=>false, 
        ]], 
    ];



public function construct_set()
{
   
}
    public function index_set()
    {

    }

    public function edit_set()
    {
        $this->set_date(); //nem jó a construktorban  mert a crud edit() felülírja a BASE['data']-t
       // $this->BASE['data']['worker_id']=$this->PAR['getT']['worker_id']?? 0;
       
        $this->BASE['data']['worker_id']=$this->BASE['data']['id']  ?? 0;
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
    public function update($id, Request $request)
    {  
      
        if(isset($this->val)){
           $this->validate($request,$this->val );  
        }

 
        if($request->has('daytypechange')){ 
            $daytypedata=[
                'daytype_id'=>$request->daytype_id,
                'managernote'=>$request->workernote,
                'worker_id'=>$id,
            ];
           // $daytypedata['worker_id']=$this->BASE['data']['worker_id'];
    //print_r($request->all());  echo '-------------mmmmmmm'; exit(); 
            foreach ($request->datum as $datum) {
                $daytypedata['datum']=$datum;
               // $daytypebase = Workerday::where(['worker_id' =>$this->BASE['data']['worker_id'],'datum' =>$datum,'pub' =>0]);

            //  $dt_id=$daytypebase->daytype_id ?? 'nincs';

            //   if($dt_id != $daytypedata['daytype_id'])
            //   { 
                    $daytype = Workerday::firstOrCreate(['worker_id' =>$id,'datum' =>$datum,'pub' =>0]);        
                     $daytype->update($daytypedata); 
           //    }   
              
            }
        
        }
        if($request->has('daytypedel')){ 

            foreach ($request->datum as $datum) {
                
                $daytype = Workerday::where(['worker_id' =>$id,'datum' =>$datum]);     
                $daytype->delete(); 
            }
        
        }
        if($request->has('timeadd')){ 
            $timeT=$request->only(['start', 'end', 'timetype_id']);
            $timeT['worker_id']=$id;
            $timeT['pub']=0;
            $timeT['managerernote']=$request->managernote2;
    //print_r($request->all());  echo '-------------mmmmmmm'; exit(); 
            foreach ($request->datum as $datum) {
 
                $timeT['datum']=$datum;
               $time = Workertime::create($timeT);     
               // $daytype->update($timeT); 
            }

    }  
    if($request->has('timedel')){ 

        foreach ($request->datum as $datum) {
           
            $time = Workerday::where(['worker_id' =>'worker_id','datum' =>$datum]);     
            $time->delete(); 
        }
    
    }
    session(['datum' => $request->datum]);
return redirect(\MoHandF::url($this->PAR['routes']['base'].'/'.$id.'/edit',$this->PAR['getT'])); 
    }
 



}
