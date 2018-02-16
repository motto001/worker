<?php

namespace App\Http\Controllers\proba\ProbaController;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Handler\MoController2;

class ProbaController extends MoController2
{
    use \App\Handler\trt\crud\Indexfull;
    use \App\Handler\trt\crud\CrudWithSetfunc;
//use  \App\Handler\trt\redirect\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;

protected $par= [ 
    'search_input_name'=>'search',
    'view_varname' => 'param', // ezen a néven kapják meg a view-ek a $PAR-t
    'get_key' => '', //pl.:'wrtime' Láncnál ezzel az előtaggal azonosítja  a controller a rávonatkozó get tagokat
    'routes' => ['base'=>''],
    'view' => '',
    'crudview' => 'crudbase_4', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
    'cim' => '', //a templétben megjelenő cím
    'getT' => [],
    'search' => true, // ha false kikapcsolja az index táblázat kereső mezőjét 
    //usereknél false ra kell áálítani mert nins megoldva az userre szűkítés
];

protected $tpar= [];

/**
 * a controller által használt alap adatok, paraméterek 
 */
protected $base= [
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
/**
 * taskok base értékei, a Handler\trt\SetController->set_task() az aktuális task kulcsa alatt szereplő értékekkel felül írja a $BASE értékeit
 */
protected $tbase= [
/* 'index'=> [  
    'task_func'=>['index_base','index_set']//az aktuális task (index) által lefuttatni kívánt funkciók 
    'base_func' =>['with',' where_or_search','order_by'],//index_base hívja meg
    ], 
 
    'create'=> ['task_func'=>['create_set']],
    'store'=> ['task_func'=>['store_set']],
    'edit'=> ['task_func'=>['edit_set']],
    'update'=> ['task_func'=>['update_set']],
    'destroy'=> ['task_func'=>['destroy_set']],
    'show'=> ['task_func'=>['show_set']],*/
];
/**
 * a create task validációs tömbje
 */
protected $val= [];//pl.:['wroleunit_id' => 'required|integer','end' => 'date_format:H:i','note' => 'string|max:200|nullable']   
/**
 *  az update task validációs tömbje ha üres az update is a $val-t használja 
 */
protected $val_update= [];


}