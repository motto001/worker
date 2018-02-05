<?php

namespace App\Handler\trt\crud;
use Illuminate\Http\Request;
use Session;
//use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Image;
Trait CrudSimple
{
/*
    protected $PAR= [ 
        'routes'=>['base'=>''],
        'view'=>'', 
        'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim'=>'',  //a templétben megjelenő cím
        'getT'=>[], 
        'search'=>true,  // ha false kikapcsolja az index táblázat kereső mezőjét     
        ];
    
        protected $BASE= [
            'perpage'=>50, //táblázat ennyi elemet listáz
            'search_column'=>[],
            'obname'=>'\App\Wroletime',
            'data'=>[], // az aktuális viewnek átadott adatok
        ];
        protected $Val= [];
       // protected $val_update= [];

*/
    public function create()
    {   $param= $this->PAR;
        return view($this->PAR['view'].'.create',compact('param'));
    }


    public function store(Request $request)
    {
        
        $this->validate($request,$this->val );
        $this->BASE['data'] = $request->all();
        $ob= new $this->BASE['obname']();
        $this->BASE['ob_res']= $ob->create($this->BASE['data']);
        Session::flash('flash_message', trans('mo.itemadded'));
        $redir=$this->PAR['routes']['redir'] ?? $this->PAR['routes']['base'];
        return  redirect($this->PAR['routes']['base']);
    }

    public function edit($id)
    {  
        $ob= new $this->BASE['obname']();
        $data =$ob->findOrFail($id);
        $param= $this->PAR;
        return view($this->PAR['view'].'.edit', compact('data','param'));
    }

    public function update($id, Request $request)
    {
        $ob= new $this->BASE['obname']();
        
        $valT=$this->val_update ?? $this->val;

        $this->validate($request,$valT );
        $requestData = $request->all();
        $this->BASE['data'] = $request->all();

        $this->BASE['ob_res']=$ob->findOrFail($id);
        $this->BASE['ob_res']->update($this->BASE['data']);

        Session::flash('flash_message',  trans('mo.item_updated'));
        return  redirect($this->PAR['routes']['base']);

    }

    public function destroy($id)
    { 
        $ob= new $this->BASE['obname']();
        $this->BASE['ob_res']=  $ob->destroy($id);
        Session::flash('flash_message', trans('mo.deleted'));
        if(method_exists($this, 'destroy_redirect')) {return $this->destroy_redirect();}  
        else{return $this->base_redirect();}
        return  redirect($this->PAR['routes']['base']);
    }


    public function show($id)
    {   
        $ob= new $this->BASE['obname']();
        $this->BASE['data'] =$ob->findOrFail($id);
        $data=$this->BASE['data'];
        $param= $this->PAR;
        return view($this->PAR['view']-'.show', compact('data','param'));
        //return view($this->PAR['view'].'.show', compact('data'));
    } 
}