<?php

namespace App\Handler\trt\redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

Trait Base
{

/**
 * ha a $this->PAR['routes']['redir'] érték létezik
 * akkor a routes tömb annak megfelelő kulcsú routjára irányít 
 * ha nincs akkor a $this->BASE['redir']['base'] kulcs alatt lévő routra
 */
public function   mo_redirect(){
    $redir=$this->PAR['routes']['redir'] ?? $this->PAR['routes']['base'];
    $task=Input::get('task') ?? \Route::getCurrentRoute()->getActionMethod();
    $redir=$this->PAR['routes'][$task] ?? $redir;
  $getT=$this->PAR['getT'] ?? [];
    return  redirect(\MoHandF::url($redir, $getT));  
  }

}
