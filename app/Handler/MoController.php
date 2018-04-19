<?php

namespace App\Handler;

use App\Http\Controllers\Controller;
//use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class MoController extends Controller
{

    public function call_func($funcT)
    {
        foreach ($funcT as $func) {
            if (method_exists($this, $func)) {$this->$func();} else {
               \ Log::error('Hiányzó controller funkció', ['func' => $func]);
                //error_log('Some message:Hiányzó controller funkció.');
                //$output = new \Symfony\Component\Console\Output\ConsoleOutput(2);
                //$output->writeln('hello');
            }
        }
    }

//beállító függvények traitekkel felülírhatók-----------------

public function set_getT() {}
 //-----------------------------------   

   /**
    * ha engedni akarjuk a GET-el vezérelt taskok futtatását
    * base use: App\Handler\trt\crud\Task;
    */
    public function run_task(){ }
//---------------------------------------

  /** 
   * base use:  \App\Handler\trt\set\Base;
   *  A PAR és A BASE TPAR. TBASE tömbök aktualizálása a par, base, tpar , tbase tömbökkel.
   * felül írja a a BASE['func']-ot is. Ezért  hivja meg a construktor még a call_func előtt
  */
    public function set_base(){}    
      
    public function set_ob()
    {
        $obname = $this->BASE['obname'];
        $this->BASE['ob'] = new $obname();
    }
   

    public function construct_set(){} //hogy a childek-ben ne kelljen a  a set base-t felülírni ha csak finomhangolásra van szükség
    
    public function __construct(Request $request)
    {

        $this->BASE['request'] = $request;
        $this->PAR['basetask'] = \Route::getCurrentRoute()->getActionMethod();     
        $this->set_base(); //ezt kell felülírni ha minden előtt lfuttatandó metódusunk van.   
        $func = $this->BASE['func'] ?? [
        'set_ob',
        'set_getT',//App\Handler\trt\set\GetT;
       // 'getT_honosit',//App\Handler\trt\set\GetT; begelyettesíti 
        'construct_set'
    ];
        $this->call_func($func);
        $view_varname = $this->PAR['view_varname'] ?? 'param';
        View::share($view_varname, $this->PAR);
        $this->run_task();
      //  echo $this->PAR['task']. \Route::getCurrentRoute()->getActionMethod();
    }

}
