<?php

namespace App\Handler\trt\view;
//use Illuminate\Support\Facades\Input;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
Trait Base
{

    public function   mo_view($data=[]){
        //$data=$this->BASE['data'] ?? $data;
     //     $task=Input::get('task') ?? \Route::getCurrentRoute()->getActionMethod();
     $task=$this->PAR['task'];
    
     if (is_array($this->PAR['view'])) {
        $getview=$this->PAR['getT']['view'] ?? 'nincs';
        $view=$this->PAR['view'][$getview]?? $this->PAR['view'][$task]  ?? $this->PAR['view']['base'].'.'.$task ;
     //  echo $task.$view;
        // echo '.......'.$this->PAR['getT']['view'] ;
   //      print_r($this->PAR['getT']);
        // ?? $this->PAR['view'][$task];         
        // $view=$this->PAR['view'][$task] ?? $view;
        }else{$view=$this->PAR['view'].'.'.$task;}
        $data=$this->BASE['data'] ?? [];
        return view($view, compact('data')); 
       //return \MoViewF::view( $this->PAR['view'].'.index',$data);
    
     }

}
