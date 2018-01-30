<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
//use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Session;
use App\Workers;
use App\User;
use App\Wrole;
use App\Timeframe;
use App\Status;
use App\Workertype;
use App\Workergroup;
use App\Handler\MoController;

class WorkersController extends MoController
{
    use \App\Handler\trt\crud\CrudWithSetfunc;
    use  \App\Handler\trt\SetController;


    protected $par= [
        // 'baseroute'=>'manager/wroletimes', // a routes-be kerüt (base)
        'get_key'=>'worker', //láncnál ezzel az előtaggal azonosítja a rávonatkozó get tagokat
        'routes'=>['base'=>'manager/workers'], //A _GET ben ['get_key']._ret ben érkező értéket fordítja le routra pl.: wrtime_ret=wru esetén a route  manager/wroleunit lesz
         'view'=>'manager.workers', //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
         'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
         'cim'=>'Dolgozók',
        'getT'=>['user_id'=>'0'],   
        // 'search'=>false,   
     ];
     protected $base= [
         //'search_column'=>'daytype_id,datum,managernote,usernote',
         'get'=>['user_id'=>'0'], //Ha a wrolunitból hvjuk a wruvissza true lesz, a store az update és a delete visszaírányít az aktuális wroleunitra.mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
        // 'get_post'=>[],//a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be ha van ilyen kulcs a postban azzal felülírja
         'obname'=>'\App\Worker',
         'with'=>['user'],
         'request'=>null,
         
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
public function search(){
  return  $this->BASE['ob']->where('user_id', 'LIKE', "%$keyword%")
    ->orWhere('wrole_id', 'LIKE', "%$keyword%")
    ->orWhere('status_id', 'LIKE', "%$keyword%")
    ->orWhere('workertype_id', 'LIKE', "%$keyword%")
    ->orWhere('workergroup_id', 'LIKE', "%$keyword%")
    ->orWhere('salary', 'LIKE', "%$keyword%")
    ->orWhere('salary_type', 'LIKE', "%$keyword%")
    ->orWhere('position', 'LIKE', "%$keyword%")
    ->orWhere('foto', 'LIKE', "%$keyword%")
    ->orWhere('fullname', 'LIKE', "%$keyword%")
    ->orWhere('cim', 'LIKE', "%$keyword%")
    ->orWhere('tel', 'LIKE', "%$keyword%")
    ->orWhere('birth', 'LIKE', "%$keyword%")
    ->orWhere('ado', 'LIKE', "%$keyword%")
    ->orWhere('tb', 'LIKE', "%$keyword%")
    ->orWhere('start', 'LIKE', "%$keyword%")
    ->orWhere('end', 'LIKE', "%$keyword%")
    ->orWhere('note', 'LIKE', "%$keyword%")
    ->orWhere('pub', 'LIKE', "%$keyword%")
    ->paginate($perPage);
}
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
       // $data['base_timeframe']=Timeframe::get(['id','name'])->toarray();
       // $data['checked_timeframe']=[1];
       $this->BASE['data']['status']=Status::get()->pluck('name','id');
       $this->BASE['data']['workertype']=Workertype::get()->pluck('name','id');
       $this->BASE['data']['workergroup']=Workergroup::get()->pluck('name','id');
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
        /*  $data['wrole']=Wrole::get()->pluck('name','id');      
        $data['base_timeframe']=Timeframe::get(['id','name'])->toarray();
        foreach($data->timeframe as $item){    
            $checked[] =  $item->id;
        }
        $data['checked_timeframe']=$checked;*/
        $this->BASE['data']['user']=User::get()->pluck('name','id');
        $this->BASE['data']['status']=Status::get()->pluck('name','id');
        $this->BASE['data']['workertype']=Workertype::get()->pluck('name','id');
        $this->BASE['data']['workergroup']=Workergroup::get()->pluck('name','id');
      
    }


}
