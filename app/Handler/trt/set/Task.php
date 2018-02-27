<?php

namespace App\Handler\trt\set;
use Illuminate\Support\Facades\Input;
Trait Task
{
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