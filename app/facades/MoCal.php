<?php
namespace App\Facades; 
use Illuminate\Support\Facades\Facade; 
class MoCal  extends Facade 
{ 
    protected static function getFacadeAccessor() 
    { 
        return \App\Handler\Mocal ::class;
    } 
}