<?php

namespace App\Handler\trt\crud;
/***
 * lehetővé teszi a crud get taskokkal való vezérlését
 * föleg crud láncoknál hasznos
 */
Trait ChainTask
{

 public function   Tedit(){
  $id=$this->PAR['getT'][$this->PAR['get_key'].'_id'];
  $this->edit($id); 
 }
 public function   Tcrate(){
  $this->create(); 
}
public function   Tdestroy(){
  $id=$this->PAR['getT'][$this->PAR['get_key'].'_id'];
  $this->destroy($id); 
}
}
