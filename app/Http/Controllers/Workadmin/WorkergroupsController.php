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
        'view' => ['base' => 'crudbase', 'include' => 'workadmin.groups',
         'showcontent' => 'workadmin.groups.show', 'workermodal' => 'workadmin.groups.workermodal'], //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        'cim' => 'Múszakok',
      //  'show' => ['auto'], // a show file generálja a megjelenítést
        //  'show'=>[['colname'=>'id','label'=>'Id']]
    ];

    protected $base = [
        'obname' => '\App\Workergroup',
        'get'=>['group_id'=>null,'worker_id'=>null,'edittask'=>null],
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
public function show_set()
{
    $edittask=$this->PAR['getT']['edittask'] ?? '';
    $group_id=$this->BASE['data']['id'];
    
if($edittask=='addworker'){$this->addworker($group_id);}
}

}
