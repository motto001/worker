<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
//use pp\facades\MoHand;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Timetype;
use App\Wroletime;
use App\Wroleunit;
use App\Handler\MoController;

use Session;

//TODO megoldani hogy ha a wroleunitot törlik 
//a hozzátartozó wroleimes-okat is törölje (cascade?)
//különben ha nem valós wrolunit_id-ek vannak 
//a wroleimes listázásnál 'try to get non object' hibát dob 

class WroletimesController extends MoController
{
    use \App\Handler\trt\crud\CrudWithSetfunc;
    use  \App\Handler\trt\SetController;
    protected $par= [
       // 'baseroute'=>'manager/wroletimes', // a routes-be kerüt (base)
       'get_key'=>'wrtime', //láncnál ezzel az előtaggal azonosítja a rávonatkozó get tagokat
       'routes'=>['base'=>'manager/wroletimes','wru'=>'manager/wroleunits/{wru_id}/edit'], //A _GET ben ['get_key']._ret ben érkező értéket fordítja le routra pl.: wrtime_ret=wru esetén a route  manager/wroleunit lesz
        'view'=>'manager.wrunit_times', //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim'=>'Műszak idők',
       // 'getT'=>['wru_id'=>'0'],   
        'search'=>false,   
    ];
    protected $base= [
        //'search_column'=>'daytype_id,datum,managernote,usernote',
        'get'=>['worker_redir'=>null,'wrole_redir'=>null,'wru_redir'=>null,'wrtime_redir'=>null,'worker_id'=>null,'wrole_id'=>null,'wru_id'=>'0'], //Ha a wrolunitból hvjuk a wruvissza true lesz, a store az update és a delete visszaírányít az aktuális wroleunitra.mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
        'get_post'=>[],//a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be ha van ilyen kulcs a postban azzal felülírja
        'obname'=>'\App\Wroletime',
        'ob'=>null,
        'request'=>null,
        
    ];

    protected $val= [
        'wroleunit_id' => 'required|integer',
        'timetype_id' => 'required|integer',
        'start' => 'required|date_format:H:i',
        'end' => 'date_format:H:i',
        'hour' => 'required|integer|max:24',
        'managernote' => 'string|max:200|nullable',
        'workernote' => 'string|max:200|nullable',
        'pub' => 'integer'
    ];
  
    public function index_set()
    {

        if($this->PAR['getT']['wru_id']>0){$where[]= ['wroleunit_id', '=', $this->PAR['getT']['wru_id']];}
        else{$where[]= ['id', '<>','0']; }//hogx mindenképpen legyen where
    
            $list =$this->BASE['ob']->with('wroleunit','timetype')
                    ->where($where )
                    ->orderBy('id', 'desc')
                    ->paginate($this->BASE['perpage'])->appends($this->PAR['getT']) ;   
         
      // print_r($this->PAR['getT']);
        $data['list']=$list;
        $data['wroleunit']=Wroleunit::get()->toarray();
        $this->BASE['data'] =$data;
    }
  

    public function create_set()
    {
       
        $this->BASE['data']['wroleunit']= Wroleunit::get();
        $this->BASE['data']['timetype']= Timetype::pluck('name','id');
//print_r($this->PAR['getT']);
    }

    public function edit_set()
    {  
        $this->BASE['data']['timetype']= Timetype::pluck('name','id');
    }

    public function del()
    { 
        $id=Input::get('wrtime_id');
       // echo '---------------'.$id;
        $this->destroy($id);
       // Session::flash('flash_message', trans('mo.deleted'));
        //return redirect('/manager/wroleunits/'.$this->PAR['getT']['wru_id'].'/edit');
       //return $this->base_redirect();
    }
/*
   public function destroy($id)
    { 
        $this->destroy_set($id);
        Session::flash('flash_message', trans('mo.deleted'));
        if($this->PAR['getT']['wruvissza']){
            return redirect('/manager/wroleunits/'.$this->PAR['getT']['wru'].'/edit');
        }else{  
        return redirect(\MoHandF::url($this->PAR['baseroute'], $this->PAR['getT']));
        }
    }*/
}
