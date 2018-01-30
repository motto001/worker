<?php

namespace App\Handler\trt;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
/**
 * function: set_getT($request)---------------
 * bejövő adat:$BASE['get'],$BASE['get_post'] /lehet üres,nemlétező
 * ir:PAR['getT']
 * function: setTask()------------------------
 * bejövő adat:$TBASE,$TPAR /lehet üres,nemlétező
 * ir:PAR,BASE
 * létrehoz:PAR['task']
 */
Trait SetController
{

/**
 * PAR['getT'] tölti fel az url get paramétereiből, ha a BASE['get'] aqlapján (ha ninc más $parkey megadva)
 * BASE['get'] értékei az alapértelmezett értékek. Ha null és nincs más érték,nem kerül be a PAR['getT']-be
 */
function set_getT($parkey='get'){
    //$request=$this->BASE['request'];
    //print_r($this->BASE[$parkey] );
        foreach($this->BASE[$parkey] as $key=>$val){
            $val=Input::get($key) ?? $val;
      //      echo $val.'---';
            if($val!=null){
                $this->PAR['getT'][$key]= $val; 
            }  
        }
  
    }
/**
 * az url osszes get paraméterét bemásolja a PAR['getT']
 */
function set_getT_all(){
    //$this->BASE['get'] =Input::get();
    $this->PAR['getT'] =$_GET;
    }

function set_getT_frompost($parkey='post'){
    $request=$this->BASE['request'];
        foreach($this->BASE[$parkey] as $key=>$val){
            
            $val= $request->input($key, $val) ;
          //  $val=Input::get($key) ?? $val;
           
            if($val!=null){
               $this->PAR['getT'][$key]= $val; 
            }   
        }
    } 
/**
 * PAR['getT'] kulcsai elol távolítja el a controller sajtá get kulcsát,(PAR['get_key'])
 */        
function getT_honosit(){
    foreach($this->PAR['getT'] as $key=>$val){

        if(stristr($key, '_', true)==$this->PAR['get_key'])
        {
            $this->PAR['getT'][stristr($key, '_')]=$val;
        }
    }
}
/**
 * A PAR['task']-oz állítja be. A PAR-t a TPAR['task']-al a BASE-t TBASE['task']-al mergeli
 */
    function set_task(){

        $task=Input::get('task') ?? \Route::getCurrentRoute()->getActionMethod();
        $this->PAR['task'] =$task;

        if(isset($this->TPAR) && isset($this->TPAR[$task]))
        {$this->PAR = array_merge($this->PAR, $this->TPAR[$task]);}  
        if(isset($this->TBASE) && isset($this->TBASE[$task]))
        {$this->BASE = array_merge($this->BASE, $this->TBASE[$task]);} 
    }  


}

