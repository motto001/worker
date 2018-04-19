<?php

namespace App\Http\Controllers\Workadmin;
use App\Handler\MoController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;

use App\Savecal;
use App\SavecalDay;
use App\SavecalDayTime;
use App\Worker;
use App\Timetype;
use App\Daytype;
use App\Day;
use App\Group;
//use Carbon\Carbon;

class SavecalsController extends MoController
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
       'addbutton_label'=>'Naptár mentés',
        'cancel_button'=>false,
        //'create_button'=>false,
         'calendar'=>['view'=>['days' => 'workadmin.workerdaytimes.days']],
         'search'=>false,
         'routes'=>['base'=>'workadmin/savecal'],
         //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
         'view' => ['base' => 'crudbase', 'include' => 'workadmin.savecal'], //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        // 'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
         'cim'=>'Naptár',
         'getT'=>[],  
         'calendar'=>[
            'checkbutton_select_class'=> [],//['gombfelirat'=>'check_class']
            'checkbox_name'=>'worker_id',
        ],   
     ];

    // protected $TBASE= [ 'create'=>[ 'obname'=>'\App\Worker', ],  'orm'=>[ 'with'=>['group']],];

//protected $tbase= [ 'edit'=>[ 'obname'=>'\App\Workerday', ], 'orm'=>[ 'with'=>['workerday','workertime']], ];
     protected $base= [
        // 'search_column'=>'daytype_id,datum,managernote,usernote',
         'get'=>['ev'=>null,'ho'=>null], //a  set_getT automatikusan fltölti a getbőll a $this->PAR['getT']-be
         'post_to_getT'=>['ev'=>null,'ho'=>null],//a set_getT automatikusan fltölti a postból a $this->PAR['getT']-be
         'obname'=>'\App\Savecal',
         'ob'=>null,
       //  'with'=>['worker','daytype'],
     ];

     protected $val =[
     //   'worker_id' => 'required|integer',
      //  'note' => 'max:200|nullable',
       // 'pub' => 'max:4'
    ];


public function construct_set()
{
  $this->set_date();
}
    public function index_set()
    {
        
    }   
    public function create_set()
    {  
        $this->BASE['data']['worker']=Worker::get();
    }
    public function get_savecal_data($worker_id)
    {  
        $group_id=Worker::findOrFail($worker_id)->group_id;

        //$this->BASE['data']['calendar'] beállítáaa
        $this->getMonthDays(); 
        //$this->BASE['data']['calendar'] módosítása worker és group day adatokkal
        if( $group_id>0){$this->getGroupday($group_id);}  
        $this->getWorkerday();
        //$this->BASE['data']['calendar'] módosítása worker és group time adatokkal
        if( $group_id>0){$this->getGrouptime($group_id);}  
        $this->getWorkertime();
     
    }
    public function store_savecal()
    {  
        $this->BASE['ob']= $this->BASE['ob']->create($this->BASE['data']);
        $id = $this->BASE['ob']->id;
        foreach ($this->BASE['data']['calendar']  as $datum =>$calendar) {
            $calendar['savecal_id'] =$id; 
            $savecalday=SavecalDay::create($calendar); 
            
            if(isset($calendar['times']) && is_array($calendar['times'])){
                foreach ($calendar['times'] as  $time) {
                    $time['savecal_day_id'] = $savecalday->id; 
                    SavecalDayTime::create($time);
                }
            }  
        }
    }
    public function update_store_savecal()
    {  
        $this->BASE['ob']= $this->BASE['ob']->firstOrNew(['worker_id'=>$this->BASE['data']['worker_id'],'ev'=>$this->BASE['data']['ev'],'ho'=>$this->BASE['data']['ho']]);
        $id = $this->BASE['ob']->id;
        $this->BASE['ob']->save($this->BASE['data']);
        foreach ($this->BASE['data']['calendar']  as $datum =>$calendar) {
            $calendar['savecal_id'] =$id; 
            $savecalday=SavecalDay::firstOrNew(['savecal_id'=>$id,'datum'=>$datum]); 
            $savecalday->save($calendar); 
            
            if(isset($calendar['times']) && is_array($calendar['times'])){
                SavecalDayTime::whereIn('savecal_day_id', [$savecalday->id])->delete();
                foreach ($calendar['times'] as  $time) {
                    $time['savecal_day_id'] = $savecalday->id; 
                    SavecalDayTime::create($time);
                }
            }  
        }
    }
    public function store(Request $request)
    {      
            $this->BASE['data'] = $request->all();

            foreach ($request->worker_id as $worker_id) {
                $this->BASE['data']['worker_id']=$worker_id;
                     $this->get_savecal_data($worker_id);
                     if($request->store){
                       $this->store_savecal();   
                     }
                     if($request->update_store){
                        $this->update_store_savecal();   
                      }   
            }
        
           return redirect($this->PAR['routes']['base'] ); 
    }



    public function edit_set()
    {  
       // $this->set_date();  
    }

    public function calendar($id)
    {   // echo 'index';
        $worker=Worker::with('user')->find($id);
        $group_id=$worker->group_id ?? 0;
        $this->BASE['data']['cim']='<img width="50px" height="50px" src="/'.$worker->foto.'"> '. $worker->user->name. ' Naptárja';
        $this->BASE['data']['worker_id']=$id;
        $this->BASE['data']['wrole']=Wrole::get()->pluck('name','id');
        $this->BASE['data']['wrole']['0']='nincs változtatás';
        $this->BASE['data']['daytype']=Daytype::get()->pluck('name','id');
        $this->BASE['data']['timetype']=Timetype::get()->pluck('name','id');
        $this->BASE['data']['daytype']['0']='nincs változtatás';
        //calendar--------------------------------------     
          //calendar--------------------------------------     
    $this->getMonthDays(); 
    if( $group_id>0){$this->getGroupday($group_id);}  
    $this->getWorkerday();
    
    if( $group_id>0){$this->getGrouptime($group_id);}  
    $this->getWorkertime();
    
        $data=$this->BASE['data'] ?? [];
        $viewfunc=$this->BASE['viewfunc']  ?? 'mo_view';
        if (method_exists($this,$viewfunc)) {return $this->$viewfunc();} 
       else{return view($this->PAR['view'].'.create',compact('data'));} 
    }
 
    
}
