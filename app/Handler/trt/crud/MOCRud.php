<?php

namespace App\Handler\trt\crud;
use Illuminate\Http\Request;
use Session;
//use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Image;
Trait MOCrud
{

    public function create()
    {   if (is_callable([$this,'create_set'])) {$this->create_set();} 
        $data=$this->BASE['data'] ?? [];
        $viewfunc=$this->BASE['viewfunc']  ?? 'mo_view';
        if (is_callable([$this,$viewfunc ])) {return $this->$viewfunc();} 
       else{return view($this->PAR['view'].'.create',compact('data'));} 
    }


    public function store(Request $request)
    {
        
        $this->validate($request,$this->val );
        $this->BASE['data'] = $request->all();

        if (is_callable([$this,'set_store_data'])) {$this->set_store_data();} 
    
        $this->BASE['ob_res']= $this->BASE['ob']->create($this->BASE['data']);

        $funcT=$this->TBASE['store']['task_func'] ?? ['store_set','image_upload'];
        $this->call_func($funcT);

        Session::flash('flash_message', trans('mo.itemadded'));
        $redirfunc=$this->BASE['redirfunc']  ?? 'mo_redirect';
        if (is_callable([$this,$redirfunc ])) {return $this->$redirfunc();} //behívja  a task specifikus routot is
       else{return redirect($this->PAR['routes']['base'] ); } 
    }

    public function edit($id)
    {  
        if(isset($this->BASE['orm']['with']))
        $this->BASE['ob']->with($this->BASE['orm']['with']);
        $this->BASE['data']  =$this->BASE['ob']->findOrFail($id);
        $this->BASE['data']['id']=$id;
       if (is_callable([$this,'edit_set'])) {$this->edit_set();} 
       $data=$this->BASE['data'] ?? [];
        $viewfunc=$this->BASE['viewfunc']  ?? 'mo_view';
        if (is_callable([$this,$viewfunc ])) {return $this->$viewfunc();} 
       else{return view($this->PAR['view'].'.edit',compact('data'));} }

    public function update($id, Request $request)
    { 
        $valT=$this->val_update ?? $this->val;

        $this->validate($request,$valT );
        $requestData = $request->all();

        $this->BASE['data'] = $request->all();
        if (is_callable([$this,'set_update_data'])) {$this->set_update_data();} 
    
        if(isset($this->BASE['orm']['with']))
        $this->BASE['ob']->with($this->BASE['orm']['with']);
        $this->BASE['ob_res']= $this->BASE['ob']->findOrFail($id);
        $this->BASE['ob_res']->update($this->BASE['data']);
        $funcT=$this->TBASE['store']['task_func'] ?? ['update_set','image_upload'];
        $this->call_func($funcT);

        Session::flash('flash_message',  trans('mo.item_updated'));
        $redirfunc=$this->BASE['redirfunc']  ?? 'mo_redirect';
        if (is_callable([$this,$redirfunc ])) {return $this->$redirfunc();} //behívja  a task specifikus routot is
       else{return redirect($this->PAR['routes']['base'] ); } 

    }

    public function destroy($id)
    { 
        $this->BASE['ob_res']= $this->BASE['ob']>destroy($id);
        if (is_callable([$this,'destroy_set'])) {$this->destroy_set();} 

        Session::flash('flash_message', trans('mo.deleted'));

        $redirfunc=$this->BASE['redirfunc']  ?? 'mo_redirect';
        if (is_callable([$this,$redirfunc ])) {return $this->$redirfunc();} //behívja  a task specifikus routot is
       else{return redirect($this->PAR['routes']['base'] ); } 
    }


    public function show($id)
    {   
        if(isset($this->BASE['orm']['with']))
        $this->BASE['ob']->with($this->BASE['orm']['with']);
        $this->BASE['data'] =$this->BASE['ob']->findOrFail($id);
        if (is_callable([$this,'show_set'])) {$this->show_set();} 
        $data=$this->BASE['data'];
     
        $viewfunc=$this->BASE['viewfunc']  ?? 'mo_view';
        if (is_callable([$this,$viewfunc ])) {return $this->$viewfunc();} //behívja  a task specifikus viewet is
       else{return view($this->PAR['view'].'.show',compact('data'));}    //return view($this->PAR['view'].'.show', compact('data'));
    } 
}