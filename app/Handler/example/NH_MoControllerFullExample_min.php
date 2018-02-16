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
    use  \App\Handler\trt\redirect\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use  \App\Handler\trt\redirect\set\Task; //felülírja a tbase task értéeivel a base-t
    use  \App\Handler\trt\redirect\set\GetT; //feltölti a getT-t a GET-ből
     use  \App\Handler\trt\redirect\set\ObFromArr;// létrehozza az aktuális objektumot vagy objektumokat képes tömböt is kezelni.
    use  \App\Handler\trt\redirect\set\Redir; //láncnál beállítja a redir routot (hogy hova kell visszatérnie)
    use  \App\Handler\trt\redirect\set\Routes;//a routok változóit kicsréli az aktuális értékre
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;

protected $par= [ 
  //  'get_key' => '', //pl.:'wrtime' Láncnál ezzel az előtaggal azonosítja  a controller a rávonatkozó get tagokat
    'routes' => ['base'=>''],
    'view' => '',
    'crudview' => 'crudbase_4', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
 //   'cim' => '', //a templétben megjelenő cím
];

protected $tpar= [];

/**
 * a controller által használt alap adatok, paraméterek 
 */
protected $base= [
'obname' => '', //lehet tömb is ha ha a setobArray trait-et  hívjuk be
'ob' => null,
];
/**
 * taskok base értékei, a Handler\trt\SetController->set_task() az aktuális task kulcsa alatt szereplő értékekkel felül írja a $BASE értékeit
 */
protected $tbase= [
/* 'index'=> [  
    'task_func'=>['index_base','index_set']//az aktuális task (index) által lefuttatni kívánt funkciók 
    'base_func' =>['with',' where_or_search','order_by'],//index_base hívja meg
    ]*/
];
/**
 * a create task validációs tömbje
 */
protected $val= [];//pl.:['wroleunit_id' => 'required|integer','end' => 'date_format:H:i','note' => 'string|max:200|nullable']   
/**
 *  az update task validációs tömbje ha üres az update is a $val-t használja 
 */
protected $val_update= [];

protected function set_baseparam(){}// a set base-t egészíti ki hoggy ne keljen felüírni

}