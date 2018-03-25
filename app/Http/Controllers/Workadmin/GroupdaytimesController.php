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
        'obname'=>'\App\Workergroup',
        'ob'=>null,
       'orm'=>[ 'with'=>['worker']],
    ];



public function workermodal()
{
    $perPage = $this->PAR['perpage'] ?? 50;
    $this->BASE['data'] = Worker::paginate($perPage);
  
}

public function addworker($group_id)
{
    $worker_id=$this->PAR['getT']['worker_id'];
  //  $group_id=$this->PAR['getT']['group_id'];
    $worker=Worker::find($worker_id);
    //print_r($worker);
    $worker->update(['workergroup_id'=>$group_id]);
    //$this->edit($group_id);
    //exit();
}
public function edit_set()
{
    $edittask=$this->PAR['getT']['edittask'] ?? '';
    $group_id=$this->BASE['data']['id'];
    
if($edittask=='addworker'){$this->addworker($group_id);}
}

public function construct_set()
{
    $this->set_date();
}
    public function index_set()
    {

        $user_id=\Auth::user()->id ?? 0;
        $worker=Worker::select('id')->where('user_id','=',$user_id)->first();
        $this->BASE['data']['worker_id']=$worker->id ?? 0;

        $this->BASE['data']['daytype']=Daytype::get()->pluck('name','id');
      
        $calendar=new \App\Handler\Calendar;
        $this->BASE['data']['calendar']=$calendar->getMonthDays($this->BASE['data']['ev'],$this->BASE['data']['ho']);
       
    //$this->setWorkertime();
    //$this->setWorkerday();
$this->BASE['data']['calendar']=$this->getWorkerday();
$this->BASE['data']['calendar']= $this->getWorkertime($this->BASE['data']['calendar']);   

  
    }


 



}
