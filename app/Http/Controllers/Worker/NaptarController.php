<?php

namespace App\Http\Controllers\Worker;
use Illuminate\Support\Facades\View;
//use pp\facades\MoHand;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Handler\MoController;

use App\Workerday;
use App\Timetype;
use App\Workerwrole;
use App\Workerwroleunit;
use App\Wroletime;
use App\Workertimewish;
use App\Workertime;
use App\Worker;
use App\Wrole;
use App\Wroleunit;
use App\Daytype;
use App\Day;
use Illuminate\Http\Request;
use Session;
//use Carbon\Carbon;
class NaptarController extends MoController
{
    use \App\Handler\trt\crud\CrudWithSetfunc;
    use  \App\Handler\trt\SetController;
    protected $par= [
        'create_button'=>false,
        'search'=>false,
        'routes'=>['base'=>'worker/naptar','worker'=>'manager/worker'],
        //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
        'view'=>'worker.naptar', //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim'=>'Naptár',
        'getT'=>[],       
    ];
  
    protected $base= [
        'search_column'=>'daytype_id,datum,managernote,usernote',
        'get'=>['ev'=>null,'ho'=>null], //a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
       // 'get_post'=>['ev'=>null,'ho'=>null],//a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be ha van ilyen kulcs a postban azzal felülírja
        'obname'=>'\App\Workerday',
        'ob'=>null,
        'func'=>[  'set_task', 'set_getT','set_date', 'set_redir','set_routes','set_ob'],
        'with'=>['worker','daytype'],
    ];

    public function set_date(){

        $t = \Carbon::now();
       // $this->BASE['get_post']['ev']= $t->year; 
       // $this->BASE['get_post']['ho']=$t->month; 
       $this->BASE['data']['ev']=$this->PAR['getT']['ev'] ?? $t->year;
       $this->BASE['data']['ho']=$this->PAR['getT']['ho'] ?? $t->month;
        if(strlen($this->BASE['data']['ho'])<2){
            $this->BASE['data']['ho']='0'.$this->BASE['data']['ho'];
        }
}
    public function index_set()
    {
        //worker-id-------------------
        $user_id=\Auth::user()->id;
        //if($user_id>0){}
        $worker=Worker::select('id')->where('user_id','=',$user_id)->first();
        $worker_id=$worker->id;
        $data['form']=Input::get('form') ?? 'create' ;
        $formid=Input::get('id') ?? 0 ;
        $data['formdata']=Workertimewish::find($formid);
       
        $this->BASE['where'][]= ['id', '=', $worker_id]; 
       // $ob=$this->BASE['ob'];
        //$perPage=$this->PAR['perpage'] ?? 50;
       // $getT=$this->PAR['getT'] ?? ['a'=>'a'];
//echo $worker_id;
        $data['timetype']=Timetype::get()->pluck('name','id');
        $data['daytype']=Daytype::get()->pluck('name','id');
        $data['years']=['2017','2018','2019'];
        $dt = \Carbon::now();
        $data['datum']= $id=Input::get('datum') ?? $dt->year.'-'.$dt->month.'-'.$dt->day ;
        //clendar tömb--------------------------------------
        $workerdayT=$this->getWorkerday($worker_id,$this->BASE['data']['ev'],$this->BASE['data']['ho']);
        $calendar=new \App\Handler\Calendar;
        $calT=$calendar->getMonthDays($this->BASE['data']['ev'],$this->BASE['data']['ho']);
        $data['calendar']=\MoHandF::mergeAssoc($calT,$workerdayT);

        //cache-ek---------------------------------
        $wrole_wrunit=[]; 
        $wrunit_wrtime=Wroletime::get()->toarray() ?? []; 
        $wrunit_wrtime=\MoHandF::setIndexFromKey($wrunit_wrtime,'wroleunit_id');
       // $wrtime=
        foreach( $data['calendar'] as $datum=>$dataT)
        {
            $wrtimes=[];
            //wrole_id-------------------------------
            $wrole_id =$data['calendar'][$datum]['wrole_id']=$this->setWrole($datum,$worker_id) ?? 2 ;
            //$wrunit_id----------------------------------
            if(isset($wrole_wrunit[$wrole_id]))
            {$wrunit_id=$wrole_wrunit[$wrole_id];}
            else
            {
                $wrunit_id=$this->setWroleunit($datum);
                $wrole_wrunit[$wrole_id]=$wrunit_id;
            }
          /*  $Workerwroleunit=Workerwroleunit::where('worker_id','=',$worker_id)
            ->where('datum','=',$datum)
            ->where('pub','=',0)->first();
            $wrunit_id= $Workerwroleunit->id ?? $wrunit_id; */
            $data['calendar'][$datum]['wrunit_id']= $wrunit_id;
            //wrtimes-------------------------
            $wrtimes= [];
            $wrtimes= Workertime::where('worker_id','=',$worker_id)
            ->where('datum','=',$datum)
            ->where('pub','=',0)->get()->toarray() ?? $wrtimes ; 
           // print_r($wrtimes);
             $data['calendar'][$datum]['wrtimes']=$wrtimes;
            $wish=[];
            $wish= Workertimewish::where('worker_id','=',$worker_id)
            ->where('datum','=',$datum)
            ->where('pub','>',0)->get()->toarray() ?? $wish ; 
           //print_r($wish);
            $data['calendar'][$datum]['wishes']=$wish;


        }
 
        $this->BASE['data']= array_merge($this->BASE['data'],$data);    
     
    }
    public function getWorkerday($worker_id,$ev,$ho)
    {
        $res=[];
        //-----------------------
        $dayT= Day::where('datum',  'LIKE', $ev."-".$ho."%")
            ->orwhere('datum',  'LIKE', "0000-".$ho."%")
            ->get();

        foreach($dayT as $day) 
        {$res[$day->datum]=['datatype'=>'day','datum'=>$day->datum,'id'=>$day->id,'daytype_id'=>$day->daytype_id,'wish_id'=>1];}  
        //------------------------
        $workerdayT= Workerday::where([
            ['worker_id', '=', $worker_id],
            ['datum',  'LIKE', $ev."-".$ho."%"],
            ])->get(); 
            foreach($workerdayT as $day) 
            {$res[$day->datum]=['datatype'=>'workerday','datum'=>$day->datum,'id'=>$day->id,'daytype_id'=>$day->daytype_id,'wish_id'=>$day->wish_id];
            
            }  
   //   print_r($worker_id);   
     return $res;    

    }

    public function setWrole($datum,$worker_id){
    
        $this->BASE['wrole'] = Workerwrole::with('wrole','wrole.wroleunit')
       ->where('worker_id','=',$worker_id)
       ->where('start','<',$datum)
       ->where('end','>',$datum)
       ->orWhere('end','=',null)
       ->orderBy('id','desc')
       ->first()->toarray(); 
       $this->BASE['wrole_id'] = $this->BASE['wrole']['wrole_id'] ?? 0;
       return  $this->BASE['wrole_id'];
     }
     public function setWroleunit($datum){
        $wroleunit_id=0;  
        $longT=['hét'=>7,'nap'=>1];
        $long=0;
        $wrole=$this->BASE['wrole'] ;
        $start=$wrole['wrole']['start'];
       //$actualstart=\Carbon::createFromFormat('Y-m-d',$start)->toDateString();
       $actualstart=\Carbon::createFromFormat('Y-m-d',$start);
    $wroleunitT=$wrole['wrole']['wroleunit'] ?? [];
      while($actualstart<$datum)
       {
         if(!empty($wroleunitT)){//$wrole->wroleunit-al (objekt) nem  működik!
            foreach($wroleunitT as $wroleunit){
            if($actualstart<$datum){
            $longvalue=$longT[$wroleunit['unit']];
            // echo $longvalue.'----'.$wroleunit->unit;          
            $long=$longvalue*$wroleunit['long'];
            // $oszlong+=$long;
            $actualstart->addDays($long);
            $actualstart=$datum;
                }
            else{
                $wroleunit_id=$wroleunit['id'];
                $actualstart=$datum;
                }
            }
          
        }else{$actualstart=$datum;}
        }
     return $wroleunit_id;
    } 

}
