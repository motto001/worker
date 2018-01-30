<?php

namespace App\Http\Controllers\Workadmin;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
//use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Wrole;

use App\Worker;
use App\Wroleunit;
use Illuminate\Http\Request;
use Session;

class WorkerwroleunitsController extends \App\Handler\MoController
{
use  \App\Handler\trt\crud\CrudWithSetfunc;
use  \App\Handler\trt\SetController;

protected $par= [ 
    //'create_button'=>false,  
    'get_key'=>'wrunit', //láncnál ezzel az előtaggal azonosítja a rávonatkozó get tagokat
    'routes'=>['base'=>'workadmin/workerwroleunit','workerdays'=>'manager/workerdays/create'],//A _GET ben ['get_key']._ret ben érkező értéket fordítja le routra pl.: wrtime_ret=wru esetén a route  manager/wroleunit lesz
    //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
    'view'=>'workadmin.workerwroleunits', //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
    'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
    'cim'=>'Felhasználók munkarendjei',  
    'getT'=>['worker_id'=>'0','wrunit_id'=>'0'],     
];
protected $base= [
    'search'=>false,
   // 'with'=>'wroleunit',
    'get'=>['wrunit_id'=>null,'wrunit_redir'=>null,'worker_id'=>null,'datum'=>null], //pl:'w_id'=>null a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be 
    'obname'=>'\App\Workerwroleunit',   
];


protected $val= [
    'worker_id' => 'required|integer',
    'wroleunit_id' => 'integer',
    'wish_id' => 'integer',
    'datum' => 'required|date',
    'end' => 'date',
    'pub' => 'integer',
    'note' => 'string|max:150'
  // 'usernote' => 'string|max:150'
];
public function pub()
{  
    $id=Input::get('id');
    $this->BASE['ob_res']=$this->BASE['ob']->findOrFail($id);
    $wish=$this->BASE['ob_res']->wish_id;
//echo '--------------------------------------'.wish_id;  
    $gg= $this->BASE['ob_res']->update(['pub'=>0,'wroleunit_id'=> $wish]);
  //  print_r($this->BASE['ob_res']);
    Session::flash('flash_message',  trans('mo.item_pub'));
    return $this->base_redirect();
}
public function unpub()
{ 
   $id=Input::get('id');

   $this->BASE['ob_res']=$this->BASE['ob']->findOrFail($id);

   $this->BASE['ob_res']->update(['pub'=>2]);

   Session::flash('flash_message',  trans('mo.item_pub'));
    return $this->base_redirect();
}

public function index_set()
{
    $worker_id=Input::get('worker_id') ?? 0;
    $this->BASE['data']['worker_id']=$worker_id;
  $this->BASE['data']['wrunit']=Wroleunit::pluck('name','id')->toarray();;
 // print_r($this->BASE['data']['wrunit']);
    $this->BASE['data']['workers']=Worker::with('user')->get()->toarray();
    $this->BASE['data']['workers'][]=['id'=>0,'user'=>['name'=>'Mind']];
    if($worker_id>0){
         $this->BASE['where'][]= ['worker_id', '=', $worker_id]; 
    }  
}

/*
public function index()
{
    $worker_id=Input::get('worker_id') ?? 0;
    $this->BASE['data']['worker_id']=$worker_id;
  //  $this->BASE['data']['wrunit']=Wroleunit::pluck('name','id');
    $this->BASE['data']['workers']=Worker::with('user')->get()->toarray();
    $this->BASE['data']['workers'][]=['id'=>0,'user'=>['name'=>'Mind']];
    if($worker_id>0){
         $this->BASE['where'][]= ['worker_id', '=', $worker_id]; 
    }  
    $this->BASE['data']['list'] =$this->BASE['ob']->with('wroleunit')->paginate(5)->appends(['ll'=>'ll'])  ;
 
   if(method_exists($this, 'index_view')) {return  $this->index_view();}  
    else{return $this->base_view('index');}
}

public function index_base(){
    $ob=$this->BASE['ob'];
    $perPage=$this->PAR['perpage'] ?? 50;
   

    if(is_callable([$this->BASE['request'], 'get'])) {$keyword = $this->BASE['request']->get('search') ?? '';} 
    else{$keyword = '';}
    $with=$this->BASE['with'] ?? '';
    if ($with=='') {  
        $ob_base =$ob ;   
    } else {
        $ob_base = $ob->with($with);
    } 
    $worker_id=$this->PAR['getT']['worker_id'] ?? '0';
    if ($worker_id!='0') {  
        $ob_base =$ob_base->where('worker_id','=',$worker_id);   
    }
    if (empty($keyword)) {  
        $this->BASE['data']['list'] =$ob_base->paginate($perPage)->appends($this->PAR['getT']) ;   
    } else {
        $this->BASE['data']['list'] = $ob_base->where($this->get_searchT($keyword,'first'))
                        ->orWhere($this->get_searchT($keyword,'firstno'))
                        //->orderBy('id', 'desc')
                        ->paginate($perPage)->appends($this->PAR['getT']) ;
    }
    
}
*/

public function create_set()
{  
    $worker_id=Input::get('worker_id') ?? 0;
    $this->BASE['data']['worker_id']=$worker_id;
    $this->BASE['data']['wrunit']=Wroleunit::pluck('name','id');
    $this->BASE['data']['workers']=Worker::with('user')->get()->toarray();
    $this->BASE['data']['workers'][]=['id'=>0,'user'=>['name'=>'Mind']];
}
 public function edit_set()
 {
    $this->BASE['data']['wrunit']=Wroleunit::pluck('name','id');
     $this->BASE['data']['wrole']=Wrole::get()->pluck('name','id');
 }
/*
    public function addwrunit()
    {
        $this->BASE['ob']->insert(
        [
        'worker_id' => $this->PAR['getT']['worker_id'], 
        'wrunit_id' => $this->PAR['getT']['wrunit_id'],
        'datum' => $this->PAR['getT']['datum'],
        ]);
        return  redirect(\MoHandF::url($this->PAR['routes']['base'], $this->PAR['getT']));  
   }
    public function delunit()
    {
        $this->BASE['id']=$id;
        $this->BASE['ob_res']= $this->BASE['ob']->destroy($id);
        return  redirect(\MoHandF::url($this->PAR['routes']['base'], $this->PAR['getT']));  
        /*
        $url=\MoHandF::url('manager/wroles/'.$this->PAR['getT']['wrole_id'].'/edit', $this->PAR['getT']);
        header("Location:$url");
        die(); 
         
    }*/
}
