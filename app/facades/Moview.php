<?php
namespace App\facades; 
use Illuminate\Support\Facades\Facade; 
class MoView extends Facade 
{ 
    protected static function getFacadeAccessor() 
    { 
        return \App\Hnandler\MoView::class;
    } 
}