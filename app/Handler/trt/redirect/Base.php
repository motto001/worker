<?php

namespace App\Handler\trt\redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

Trait Base
{

 public function   base_redirect(){
    redirect(\MoHandF::url($this->PAR['route'], $this->PAR['getT']));  
 }

}
