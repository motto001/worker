<?php

namespace App\Http\Controllers\Workadmin;
use App\Handler\MoController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Facade; 
use App\Savecal;
use App\SavecalDay;
use App\SavecaTime;
use App\Worker;
use App\Timetype;
use App\Daytype;
use App\Day;
use App\Group;

//use Carbon\Carbon;

class SavecalsController extends MoController
{
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOCrud;//crud functiok index nélkül
    //use \App\Handler\trt\crud\Task; // GET-el vezérelt taskok futtatása
    use \App\Handler\trt\view\Base; //mo_view()
    use \App\Handler\trt\redirect\Base;//mo_redirect()
    use \App\Handler\trt\property\MoControllerBase; //PAR és BASE propertyk hogy legyen mit kiegéaszíteni
   // use \App\Handler\trt\set\Orm; // with, where, order_by stb
    use \App\Handler\trt\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg 
    use \App\Handler\trt\set\GetT;
     //calendár------------------------------------
    use \App\Handler\trt\set\Date;
   // use \App\Handler\trt\get\Day;
  //  use \App\Handler\trt\get\Time;
    use \App\Handler\trt\get\Daytime;
    use \App\Handler\trt\get\Calendar;
    use \App\Handler\trt\calendar\Savecal;
    protected $par= [
        // 'create_button'=>false,
        'info_button_link' => '/workadmin/info/savecal/baseinfo',
       'addbutton_label'=>'Naptár mentés',
        'cancel_button'=>false,
        //'create_button'=>false,
         'calendar'=>['view'=>['days' => 'workadmin.workerdaytimes.days']],
         'search'=>false,
         'routes'=>['base'=>'workadmin/savecal','create'=>'/workadmin/workerdaytimes'],
         //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
         'view' => ['base' => 'crudbase', 'include' => 'workadmin.savecal'], //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        // 'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
         'cim'=>'Havi mentés',
         'getT'=>[],  
         'calendar'=>[
            'checkbutton_select_class'=> [],//adott osztályú checkboxok kiválasztása:['gombfelirat'=>'check_class']
            'checkbox_name'=>'worker_id',
        ],   
     ];

     protected $base= [
        // 'search_column'=>'daytype_id,datum,managernote,usernote',
         'get'=>['ev'=>null,'ho'=>null], //a  set_getT automatikusan fltölti a getbőll a $this->PAR['getT']-be
         'post_to_getT'=>['ev'=>null,'ho'=>null],//a set_getT automatikusan fltölti a postból a $this->PAR['getT']-be
         'obname'=>'\App\Savecal',
         'ob'=>null,
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
   
    public function store(Request $request)
    {      
            $this->BASE['data'] = $request->all();
//echo '1111111111'; print_r($request->all());
$workerT=$request->worker_id ?? [];
            foreach ($workerT as $worker_id) {
                
                $this->BASE['data']['worker_id']=$worker_id;
                 $this->get_savecal_data($worker_id);
                     if($request->store=='new'){
                    // echo '222222222222--------';
                       $this->store_savecal(); 
                       
                     }
                     if($request->store=='update'){
                      //  echo '33333333333';  
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
       // $savecalB=Savecal::with(['savecalday','savecalday.times'])->find($id);
        
       // print_r($savecalB);
      /*  $worker=Worker::with('user')->find($savecal->worker_id);
        $group_id=$worker->group_id ?? 0;
        $this->BASE['data']['cim']='<img width="50px" height="50px" src="/'.$worker->foto.'"> '. $worker->user->name. ' Naptárja';
        $this->BASE['data']['worker_id']=$id;*/
         
        //calendar-------------------------------------- 
        $this->set_savecal($id);
        $data=$this->BASE['data'] ?? [];
         return view($this->PAR['view']['include'].'.calendar',compact('data'));
    }
    public function solver($id)
    {  
        //calendar-------------------------------------- 
        $this->set_savecal($id);
        $sum=['workday'=>0,'napsum'=>0,'ledolg'=>0,'timesum'=>0];
        $daytypes=Daytype::get()->toarray();
        $daytypes= \MoHandF::setIndexFromKey($daytypes,'id');
      $timetypes=Timetype::get()->toarray();
      $timetypes= \MoHandF::setIndexFromKey( $timetypes,'id');
     //  print_r($this->BASE['data']['calendar']);
        foreach ($this->BASE['data']['calendar']  as $key => $calendar) {
        // print_r($calendar);
//echo'------------------------------------------------------------------------------';
            $day=$calendar['baseday'];
            $dayT[$day['daytype_id']]=$dayT[$day['daytype_id']] ?? 0;
            $dayT[$day['daytype_id']]++;

            if($day['workday']){$sum['workday']++;}
            $sum['napsum']++;
            
           // $dayT[$day['fixplusz']][$day['type']]=$day['fixplusz'] ?? 0;
           
           if(isset($calendar['times'])){
                foreach ($calendar['times']  as  $times) {
                $timeT[$times['timetype_id']]=$timeT[$times['timetype_id']] ?? 0;
                $timeT[$times['timetype_id']]++;
                $sum['timesum']++;
            }
            $sum['ledolg']++;
           }
           
        }
     //   $data=$this->BASE['data'] ?? [];
     $workerid=Savecal::where('id', '=', $id)->select('worker_id')->first()->worker_id ?? 0;
     $data['oraber'] = Worker::where('id', '=', $workerid)->select('salary')->first()->salary ?? 0;
    $data['daytypes']=$daytypes;
  $data['timetypes']=$timetypes;
     $data['sum']=$sum;
        $data['dayT']=$dayT;
        $data['timeT']=$timeT;
        // return view($this->PAR['view']['include'].'.solver',compact('data'));
       // print_r($data);
       return view($this->PAR['view']['include'].'.solver',compact('data'));
    }
    
}
