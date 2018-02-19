<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Handler\MoController;
use Illuminate\Http\Request;
use Session;
use App\Workers;
use App\User;
use App\Wrole;
use App\Timeframe;
use App\Workertimeframe;
use App\Status;
use App\Workertype;
use App\Workergroup;


class WorkersController extends MoController
{
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOCrud;
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;
    use \App\Handler\trt\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use \App\Handler\trt\property\MoControllerBase; //PAR és BASE propertyk hogy legyen mit kiegéaszíteni
    use \App\Handler\trt\set\Orm; // with, where, order_by
    use \App\Handler\trt\Image;

    protected $par= [
        // 'baseroute'=>'manager/wroletimes', // a routes-be kerüt (base)
        'get_key'=>'worker', //láncnál ezzel az előtaggal azonosítja a rávonatkozó get tagokat
        'routes'=>['base'=>'manager/workers'], //A _GET ben ['get_key']._ret ben érkező értéket fordítja le routra pl.: wrtime_ret=wru esetén a route  manager/wroleunit lesz
        'view'=>['base' => 'crudbase', 'include' =>'manager.workers'], //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
      //  'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim'=>'Dolgozók',
        'getT'=>['user_id'=>'0'],  
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
        // 'search'=>false,         
     ];
     protected $base= [    
        'get'=>['user_id'=>'0'], //Ha a wrolunitból hvjuk a wruvissza true lesz, a store az update és a delete visszaírányít az aktuális wroleunitra.mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
        'obname'=>'\App\Worker',
        'with'=>['user','workertimeframe'],
        'search_column' => [ 'wrole_id', 'status_id','workertype_id', 'workergroup_id',  'salary', 'salary_type','foto', 'fullname',
        'cim', 'LIKE','tel', 'LIKE', 'birth', 'ado',
        'LIKE',  'tb', 'start', 'end', 'note','pub'],
        'image'=>[
            'inputmezo'=>'foto'
        ]

     ];

    protected $val= [
    'fullname' => 'required|max:200',
    'cim' => 'required|max:200',
    'tel' => 'max:50|nullable',
    'birth' => 'required|date',
    'ado' => 'string|max:50|nullable',
    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    'tb' => 'string|max:50|nullable',
    'start' => 'required|date',
    'end' => 'date|nullable',
    'note' => 'string|nullable',
    'pub' => 'integer'
];

public function index_set()
    {
      //  print_r($this->BASE['data']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create_set()
    {     
       $this->BASE['data']['user']=User::get()->pluck('name','id');
       // $this->BASE['data']['wrole']=Wrole::get()->pluck('name','id');
       $this->BASE['data']['base_timeframe']=Timeframe::get(['id','name'])->toarray();
       $this->BASE['data']['checked_timeframe']=[1];
       $this->BASE['data']['status']=Status::get()->pluck('name','id');
       $this->BASE['data']['workertype']=Workertype::get()->pluck('name','id');
       $this->BASE['data']['workergroup']=Workergroup::get()->pluck('name','id');
    }
  public function store_set()
    {
        $worker_id=$this->BASE['ob']->id;
        foreach ($this->BASE['request']->timeframe_id as $tf) {
            Workertimeframe::create(['worker_id'=>$worker_id,'timeframe_id'=>$tf]);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit_set()
    {
        /*  $data['wrole']=Wrole::get()->pluck('name','id');*/      
        $data['base_timeframe']=Timeframe::get(['id','name'])->toarray();
        $checked =[];
        foreach($this->BASE['data']->workertimeframe as $item){    
            $checked[] =  $item->id;
        }
        $this->BASE['data']['checked_timeframe']=$checked;
        $this->BASE['data']['user']=User::get()->pluck('name','id');
        $this->BASE['data']['base_timeframe']=Timeframe::get(['id','name'])->toarray();
        $this->BASE['data']['checked_timeframe']=[1];
        $this->BASE['data']['status']=Status::get()->pluck('name','id');
        $this->BASE['data']['workertype']=Workertype::get()->pluck('name','id');
        $this->BASE['data']['workergroup']=Workergroup::get()->pluck('name','id');
      
    }


}
