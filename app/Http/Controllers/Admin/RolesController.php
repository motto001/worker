<?php

namespace App\Http\Controllers\Admin;

use App\Handler\MoController2;
use Illuminate\Support\Facades\View;

class RolesController extends MoController2
{
    use \App\Handler\trt\crud\IndexSimple;
    use \App\Handler\trt\crud\CrudSimple;
//use  \App\Handler\trt\redirect\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;

    protected $PAR = [
        'view_varname' => 'param', // ezen a néven kapják meg a view-ek a $PAR-t
        'routes' => ['base' => 'root/roles'],
        'view' => 'admin.roles', //lehet tömb is pl view/base traitel
        'crudview' => 'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim' => '', //a templétben megjelenő cím
        'search' => true, // ha false kikapcsolja az index táblázat kereső mezőjét

    ];

    protected $TPAR = [];

    protected $BASE = [
        'viewfunc' => 'mo_view', //ha nincs megadva a laravel viewet használja, a A PAR[view] nem lehet tömb!
        'redirfunc' => 'mo_redirect', //ha nincs megadva a laravel redir használja, a A PAR[routes][base]-el
        'perpage' => 50, //táblázat ennyi elemet listáz
        'search_column' => '', //mezők amiben keres
        'obname' => '\App\Role', //lehet tömb is ha ha a setobArray trait-et  hívjuk be
        'ob' => null,
        'request', //construktor másolja ide az aktuális requestet
        'data' => [], // az aktuális viewnek átadott adatok
        'func' => [ // a constructor által lefuttatni kívánt funkciók
            //'set_baseparam',  //hogy ne kelljen  a set base felülírnii
            'set_ob', //$this, a fő objektumot állítja elő az 'ob'-ba az 'obname' alapján
        ],
    ];
    public $val = ['name' => 'required'];

}
