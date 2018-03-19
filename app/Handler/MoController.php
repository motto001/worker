<?php

namespace App\Handler;

use App\Http\Controllers\Controller;
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
    public function set_getT()
    {
       // $this->PAR['getT'] = $_GET;
    }
    public function set_ob()
    {
        $obname = $this->BASE['obname'];
        $this->BASE['ob'] = new $obname();
    }
    public function set_base(){}

    public function construct_set(){} //hogy a childek-ben ne kelljen a  a set base-t felülírni ha csak finomhangolásra van szükség
    
    public function __construct(Request $request)
    {

        $this->BASE['request'] = $request;

        $this->set_base(); //taskok értékeivel felül írja a PAR és A BASE  tömböket.
        // a BASE['func']-ot is. Ezért  kell még a call_func előtt meghívni
        $func = $this->BASE['func'] ?? ['set_ob','set_getT','construct_set'];
        $this->call_func($func);
        $view_varname = $this->PAR['view_varname'] ?? 'param';
        View::share($view_varname, $this->PAR);
        $task = Input::get('task') ?? \Route::getCurrentRoute()->getActionMethod();
        $this->PAR['task']= $task; 

        if ($task != \Route::getCurrentRoute()->getActionMethod()) {

            if (is_callable([$this, $task])) {   return $this->$task();  } 

        }
      //  echo $this->PAR['task']. \Route::getCurrentRoute()->getActionMethod();
    }

}
