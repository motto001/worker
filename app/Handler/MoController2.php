<?php

namespace App\Handler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;


class MoController2 extends Controller
{

    protected $PAR = [
        'view_varname' => 'param', // ezen a néven kapják meg a view-ek a $PAR-t
        'get_key' => '', //pl.:'wrtime' Láncnál ezzel az előtaggal azonosítja  a controller a rávonatkozó get tagokat
        'routes' => ['base'=>''],
        'view' => '',
        'crudview' => 'crudbase_4', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim' => '', //a templétben megjelenő cím
        'getT' => [],
        'search' => true, // ha false kikapcsolja az index táblázat kereső mezőjét

    ];
    protected $TPAR = [];
    protected $BASE = [
        'viewfunc'=>'mo_view', //ha nincs megadva a laravel viewet használja, a A PAR[view] nem lehet tömb!
        'redirfunc'=>'mo_redirect', //ha nincs megadva a laravel redir használja, a A PAR[routes][base]-el
      
        'perpage' => 50, //táblázat ennyi elemet listáz
        'search_column' => '',
        'get' => [],
        'get_post' => [], //ugyanaz mint a 'get' csak  ha van ilyen kulcs a postban azzal felülírja
        'obname' => '', //lehet tömb is ha ha a setobArray trait-et  hívjuk be
        'ob' => null,
        'request', //construktor másolja ide az aktuális requestet
        'data' => [], // az aktuális viewnek átadott adatok
        'func' => [ // a constructor által lefuttatni kívánt funkciók
            'set_baseparam', //hogy ne kelljen  a set base felülírnii
            'set_task', //\App\Handler\trt\SetController
            'set_getT', //\App\Handler\trt\SetController
            'set_redir',
            'set_routes',
            'set_ob', //$this, a fő objektumot állítja elő az 'ob'-ba az 'obname' alapján
        ],
    ];

    protected $TBASE = [];

    protected $val = []; //pl.:['wroleunit_id' => 'required|integer','end' => 'date_format:H:i','note' => 'string|max:200|nullable']
   
    protected $val_update = [];

    public function call_func($funcT)
    {
        foreach ($funcT as $func) {
            if (is_callable([$this, $func])) {$this->$func();} else {
                Log::error('Hiányzó controller funkció', ['func' => $func]);
                //error_log('Some message:Hiányzó controller funkció.');
                //$output = new \Symfony\Component\Console\Output\ConsoleOutput(2);
                //$output->writeln('hello');
            }
        }
    }

//beállító függvények traitekkel felülírhatók-----------------
    public function set_getT()
    {
        $this->PAR['getT'] = $_GET;
    }
    public function set_ob()
    {
        $obname = $this->BASE['obname'];
        $this->BASE['ob'] = new $obname();
    }
    public function set_base()
    { 
    }

    public function set_baseparam() //hogy a childek-ben ne kelljen a  a set base-t felülírni ha csak finomhangolásra van szükség
    { }

    public function __construct(Request $request)
    {

        $this->BASE['request'] = $request;

        $this->set_base(); //taskok értékeivel felül írja a PAR és A BASE  tömböket.
        // a BASE['func']-ot is. Ezért  kell még a call_func előtt meghívni
        $func=$this->BASE['func'] ?? [];
        $this->call_func( $func);
        $share_param_name = $this->PAR['varname'] ?? 'param';
        View::share($share_param_name, $this->PAR);
        $task=Input::get('task') ?? \Route::getCurrentRoute()->getActionMethod();
        if ($task != \Route::getCurrentRoute()->getActionMethod()) {return $this->$task();}
    }

}
