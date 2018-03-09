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
//use App\Workerwrole;
//use App\Workerwroleunit;
//use App\Wroletime;
//use App\Workertimewish;
//use App\Wrole;
//use App\Wroleunit;
//use Carbon\Carbon;
class GroupdaytimesController extends MoController
{
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOCrud;
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;
    use \App\Handler\trt\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use \App\Handler\trt\property\MoControllerBase; //PAR és BASE propertyk hogy legyen mit kiegéaszíteni
    use \App\Handler\trt\set\Orm; // with, where, order_by
    use \App\Handler\trt\set\GetT;

    protected $par= [
        'create_button'=>false,
        'search'=>false,
        'routes'=>['base'=>'wrkadmin/groupdaytimes'],
        //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
        'view' => ['base' => 'crudbase', 'include' => 'workadmin.groupdaytimes'], //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
       // 'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim'=>'Naptár',
        'getT'=>[],       
    ];
  
    protected $base= [
       // 'search_column'=>'daytype_id,datum,managernote,usernote',
        'get'=>['ev'=>null,'ho'=>null,'group_id'=>null,'modal'=>null], //a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
       // 'get_post'=>['ev'=>null,'ho'=>null],//a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be ha van ilyen kulcs a postban azzal felülírja
        'obname'=>'\App\Workergroup',
        'ob'=>null,
        'with'=>['worker','daytype'],
    ];

    public function set_date(){

        $t = \Carbon::now();
        $this->BASE['data']['carbon']=$t;
       // $this->BASE['get_post']['ev']= $t->year; 
       // $this->BASE['get_post']['ho']=$t->month; 
       $this->BASE['data']['ev']=$this->PAR['getT']['ev'] ?? $t->year;
       $this->BASE['data']['ho']=$this->PAR['getT']['ho'] ?? $t->month;
        if(strlen($this->BASE['data']['ho'])<2){
            $this->BASE['data']['ho']='0'.$this->BASE['data']['ho'];
        }
}
public function construct_set()
{
       // $user_id=\Auth::user()->id ?? 0;
       // $group=Workergroup::select('id')->where('user_id','=',$user_id)->first();
      // $this->BASE['data']['worker_id']=$worker->id ?? 0;

}
    public function index_set()
    {

        $user_id=\Auth::user()->id ?? 0;
        $worker=Worker::select('id')->where('user_id','=',$user_id)->first();
        $this->BASE['data']['worker_id']=$worker->id ?? 0;

        $this->BASE['data']['daytype']=Daytype::get()->pluck('name','id');
//print_r($this->BASE['data']['daytype']);
       // $dt = \Carbon::now();
        //$this->BASE['data']['datum']=Input::get('datum') ?? $dt->year.'-'.$dt->month.'-'.$dt->day ;
        //calendar tömb-------------------------------------- 
        $this->set_date();
        $calendar=new \App\Handler\Calendar;
        $this->BASE['data']['calendar']=$calendar->getMonthDays($this->BASE['data']['ev'],$this->BASE['data']['ho']);
       
    $this->setWorkerday();
    $this->setWorkertime();    
    }
    public function setWorkerday()
    {
        $res=[];
        $worker_id=$this->BASE['data']['worker_id'];
        $ev=$this->BASE['data']['ev'];
        $ho=$this->BASE['data']['ho'];
        //-----------------------
        $dayT= Day::where('datum',  'LIKE', $ev."-".$ho."%")
            ->orwhere('datum',  'LIKE', "0000-".$ho."%")
            ->get();
            foreach($dayT as $day) 
            {
               // $dayev = substr($day->datum, 4); 
               $day->datum = str_replace("0000", $ev, $day->datum);
               $ujdayT=  ['datatype'=>'day','datum'=>$day->datum,'id'=>$day->id,'ch'=>'days',
               'type'=>$this->BASE['data']['daytype'][$day->daytype_id]];
                $this->BASE['data']['calendar'][$day->datum]=array_merge($this->BASE['data']['calendar'][$day->datum],$ujdayT);
            }  

        //------------------------
        $workerdayT= Workerday::where([
            ['pub', '=', 0],
            ['worker_id', '=', $worker_id],
            ['datum',  'LIKE', $ev."-".$ho."%"],
            ])->get(); 
      // print_r($workerdayT);
            foreach($workerdayT as $day) 
            { 
                $ujdayT= ['datatype'=>'day','datum'=>$day->datum,'id'=>$day->id,'ch'=>'workerdays',
                'type'=>$this->BASE['data']['daytype'][$day->daytype_id]];
               $this->BASE['data']['calendar'][$day->datum]=array_merge($this->BASE['data']['calendar'][$day->datum],$ujdayT);
            }   
           
   //$this->BASE['data']['calendar']=array_merge($this->BASE['data']['calendar'],$res);

    }
    public function setWorkertime()
    {
        $res=[];
        $worker_id=$this->BASE['data']['worker_id'];
        $ev=$this->BASE['data']['ev'];
        $ho=$this->BASE['data']['ho'];
      //  $dt = \Carbon::create($ev,$ho, 1, 0)->endOfMonth();

        //-----------------------
        $datum1=$ev.'-'.$ho.'-01';
        $datum2=\Carbon::create($ev,$ho, 1, 0)->endOfMonth();
       // echo  $datum2.'--------';
            //wrtimes-------------------------
            $wrtimes= [];
            $wrtimes= Workertime::where('worker_id','=',$worker_id)
           // ->where('datum','>=',$datum1)
            //->where('datum','<=',$datum2)
            ->where('pub','=',0)
            ->whereBetween('datum', [$datum1,$datum2])
            ->get()->toarray() ?? $wrtimes ; 
         //   print_r($wrtimes);
        foreach($wrtimes as $time) 
        {
            $this->BASE['data']['calendar'][$time['datum']]['times'][]=$time;    
        }  
        //------------------------
  // $this->BASE['data']['calendar']=array_merge($this->BASE['data']['calendar'],$res);

    }

 



}
