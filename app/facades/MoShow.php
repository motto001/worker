<?php
namespace App\facades; 
use Illuminate\Support\Facades\Facade; 
class MoShow extends Facade 
{ 
    protected static function getFacadeAccessor() 
    { 
        return \App\Handler\MoShow::class;
    } 
}