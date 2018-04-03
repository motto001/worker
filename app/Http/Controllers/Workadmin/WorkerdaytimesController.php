<?php

namespace App\Http\Controllers\Workadmin;
use App\Handler\MoController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;

use App\Workertime;
use App\Wrole;
use App\Wroletime;
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
     //calendár------------------------------------
    use \App\Handler\trt\set\Date;
    use \App\Handler\trt\get\Day;
    use \App\Handler\trt\get\Time;
    use \App\Handler\trt\get\Calendar;

    protected $par= [
        // 'create_button'=>false,
       'addbutton_label'=>'Naptár sterkesztése',
        'cancel_button'=>false,
        'create_button'=>false,
         'calendar'=>['view'=>['days' => 'workadmin.workerdaytimes.days']],
         'search'=>false,
         'routes'=>['base'=>'workadmin/workerdaytimes'],
         //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
         'view' => ['base' => 'crudbase', 'include' => 'workadmin.workerdaytimes'], //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        // 'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
         'cim'=>'Naptár',
         'getT'=>[],       
     ];
     protected $tpar= [

         'edit'=>[
             'formopen_in_crudview'=>false,
             //'cancel_button'=>True,
             'calendar'=>[
                 'view' => ['days' => 'workadmin.workerdaytimes.editdays'],
             // 'ev_ho'=>false, //kikapcsolja az év hó válastó mezőt
                 'checkbutton'=>true, //kikapcsolja az év hó válastó mezőt
                 'pdf_print'=>false, 
         ]], 

         'calendar'=>[
            'formopen_in_crudview'=>false,
            'view' => ['base' => 'crudbase', 'include' => 'workadmin.workerdaytimes','show2' => 'crudbase.show','calendar' => 'crudbase.index',
            'showcontent' => 'workadmin.workerdaytimes.show2', 'workermodal' => 'workadmin.workerdaytimes.workermodal','table'=>'workadmin.workerdaytimes.calendar'],
         // 'view'=>['table'=>'workadmin.groups.calendar'],
            'calendar'=>[
            'ev_ho_formopen'=>false,
            'view' => ['days' => 'worker.naptar.editdays'],
             'ev_ho'=>true, //ki-bekapcsolja az év hó válastó mezőt
                'checkbutton'=>true, //ki-be kapcsolja az év hó válastó mezőt
                'pdf_print'=>false, 
        ]], 
     ];
     protected $TBASE= [ 'edit'=>[ 'obname'=>'\App\Worker', ],  'orm'=>[ 'with'=>['group']],];

//protected $tbase= [ 'edit'=>[ 'obname'=>'\App\Workerday', ], 'orm'=>[ 'with'=>['workerday','workertime']], ];
     protected $base= [
        // 'search_column'=>'daytype_id,datum,managernote,usernote',
         'get'=>['ev'=>null,'ho'=>null], //a  set_getT automatikusan fltölti a getbőll a $this->PAR['getT']-be
         'post_to_getT'=>['ev'=>null,'ho'=>null],//a set_getT automatikusan fltölti a postból a $this->PAR['getT']-be
         'obname'=>'\App\Worker',
         'ob'=>null,
       //  'with'=>['worker','daytype'],
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
       // $this->set_date();  
    }
    public function workermodal()
    {
        $perPage = $this->PAR['perpage'] ?? 50;
        $this->BASE['data'] = Worker::paginate($perPage);
      
    }
    public function calendar($id)
    {   // echo 'index';
        $worker=Worker::with('user')->find($id);
        $this->BASE['data']['cim']='<img width="50px" height="50px" src="/'.$worker->foto.'"> '. $worker->user->name. ' Naptárja';
        $this->BASE['data']['worker_id']=$id;
        $this->BASE['data']['wrole']=Wrole::get()->pluck('name','id');
        $this->BASE['data']['wrole']['0']='nincs változtatás';
        $this->BASE['data']['daytype']=Daytype::get()->pluck('name','id');
        $this->BASE['data']['timetype']=Timetype::get()->pluck('name','id');
        $this->BASE['data']['daytype']['0']='nincs változtatás';
        //calendar--------------------------------------     
        $this->getMonthDays();   
        $this->getGroupday($id);
        $this->getGrouptime($id);  
        $this->getMonthDays();   
        $this->getWorkerday();
        $this->getWorkertime();
    
        $data=$this->BASE['data'] ?? [];
        $viewfunc=$this->BASE['viewfunc']  ?? 'mo_view';
        if (method_exists($this,$viewfunc)) {return $this->$viewfunc();} 
       else{return view($this->PAR['view'].'.create',compact('data'));} 
    }
    public function calendarsave($id) 
    {  
        $request= $this->BASE['request'];
        $this->BASE['data']['worker_id']=$id;
        if(isset($this->val)){
         //  $this->validate($request,$this->val );  
        } 
    
        if($request->has('change'))
        {
         //  echo 'hhhhhhj.....jjjj';  exit();
         if($request->has('wroletask') && $request->wrole_id!=0 ){ $this->wrolechange($request);}
            if($request->has('daytask') && $request->daytype_id!=0 ){ $this->daytypechange($request);}
            if($request->has('timetask') && !empty($request->start) && !empty($request->end))
            { $this->timeadd($request); }
        } 
        if($request->has('del'))
        { 
            if($request->has('daytask')){$this->daytypedel($request);}
            if($request->has('timetask')){ $this->timedel($request);  }
         }
    
        session(['datum' => $request->datum]);
        return redirect(\MoHandF::url($this->PAR['routes']['base'].'/calendar/'.$id,$this->PAR['getT'])); 
    }
    public function wrolechange(Request $request)
    {  
        $wroletimeT=Wroletime::where('wrole_id',$request->wrole_id)->get()->toarray() ;

        $worker_id=$this->BASE['data']['worker_id'];


        foreach ($request->datum as $datum) {
            Workertime::where('worker_id',$worker_id)->where('datum',$datum)->delete();
            foreach ($wroletimeT as $wroletime) {

                $wroletime['datum']=$datum;
                $wroletime['worker_id']=$worker_id;
                $wroletime['pub']='0';
                $daytype =  Workertime::create($wroletime);        
                    
            }
        }
   //  return redirect(\MoHandF::url($this->PAR['routes']['base'].'/calendar/'.$id,$this->PAR['getT'])); 
    }
    
    public function daytypechange(Request $request)
    {  
        $daytypedata['worker_id']=$this->BASE['data']['worker_id'];
        $daytypedata['daytype_id']=$request->daytype_id;

        foreach ($request->datum as $datum) {
          Workerday::where('worker_id',$this->BASE['data']['worker_id'])->where('datum',$datum)->update(['pub'=>'2']);
            $daytypedata['datum']=$datum;
           
                $daytype = Workerday::firstOrCreate($daytypedata);        
            //  echo 'mmm'.$daytype->id; exit();
                $daytype->update(['pub'=>'0']);     
        }
    }
    
    public function daytypedel(Request $request)
    {  
        foreach ($request->datum as $datum) 
        {        
            $daytype = Workerday::where(['worker_id' =>$this->BASE['data']['worker_id'],'datum' =>$datum]);     
            $daytype->delete(); 
        }
    }
    
    public function timeadd(Request $request)
    {  
        $timeT=$request->only(['start', 'end', 'timetype_id']);
        $timeT['worker_id']=$this->BASE['data']['worker_id'];
        $timeT['note']=$request->note2;
    
        foreach ($request->datum as $datum)
         {
            $timeT['datum']=$datum;
            $time = Workertime::create($timeT);     
        }
    }
    
    
    public function timedel(Request $request)
    {  ///echo 'töröl';exit();
        foreach ($request->datum as $datum) {          
            $time =  Workertime::where(['worker_id' =>$this->BASE['data']['worker_id'],'datum' =>$datum]);     
            $time->delete(); 
        }
    }   
    
    public function show2_set()
    {
        $group_id=$this->BASE['data']['id'];
        $request=$this->BASE['request'];
        if($request->worker_id){
            $workerO=Worker::findOrFail($request->worker_id); 
            if($request->edittask=='addworker'){$workergroup_id=$group_id;}
            if($request->edittask=='delworker'){$workergroup_id=null;
           // echo 'jhkjhkjhjk';
            
            }
            foreach($workerO as $worker) {
    
                $worker->update(['worker_id'=>$workergroup_id]);
            } 
            
        }
       
        
    
    
    }
    //előbb hívja meg show_set()-et mnt az eredeti hogy ne kelljen frissíteni woeker törléss és hozzáadás esetén
    public function show2($id)
    {  
        
        $this->BASE['data']['id']=$id;
        $this->show2_set();
        $data=$this->BASE['data'];
    
        if(isset($this->BASE['orm']['with'])){$this->BASE['ob']= $this->BASE['ob']->with($this->BASE['orm']['with']);} 
        $this->BASE['data'] =$this->BASE['ob']->findOrFail($id);
    
    $viewfunc=$this->BASE['viewfunc']  ?? 'mo_view';
    return $this->$viewfunc();
    } 
    
}
