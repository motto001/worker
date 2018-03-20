<?php

namespace App\Http\Controllers\Workadmin;
use App\Handler\MoController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Workergroup;
use App\Worker;
class WorkergroupsController extends MoController
{ 
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOCrud;
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;
    use \App\Handler\trt\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use \App\Handler\trt\property\MoControllerBase; //PAR és BASE propertyk hogy legyen mit kiegéaszíteni
    use \App\Handler\trt\set\Orm; // with, where, order_by
    use \App\Handler\trt\set\GetT;
    protected $par = [
        'routes' => ['base' => 'workadmin/groups'],
        'view' => ['base' => 'crudbase', 'include' => 'workadmin.groups','show2' => 'crudbase.show',
         'showcontent' => 'workadmin.groups.show2', 'workermodal' => 'workadmin.groups.workermodal'], //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        'cim' => 'Múszakok',
      //  'show' => ['auto'], // a show file generálja a megjelenítést
        //  'show'=>[['colname'=>'id','label'=>'Id']]
    ];

    protected $base = [
        'obname' => '\App\Workergroup',
        'get'=>['group_id'=>null],
        'orm'=>[ 'with'=>['worker']],
    ];   


protected $val =[
    'name' => 'required|max:200',
    'note' => 'max:200|nullable',
    'pub' => 'max:4'
];
public function workermodal()
{
    $perPage = $this->PAR['perpage'] ?? 50;
    $this->BASE['data'] = Worker::paginate($perPage);
  
}

public function show2_set()
{
    $group_id=$this->BASE['data']['id'];
    $request=$this->BASE['request'];
    if($request->worker_id){
        $workerO=Worker::findOrFail($request->worker_id); 
        if($request->edittask=='addworker'){$workergroup_id=$group_id;}
        if($request->edittask==='delworker'){$workergroup_id=null; }
        foreach($workerO as $worker) {
            $worker->update(['workergroup_id'=>$workergroup_id]);
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
