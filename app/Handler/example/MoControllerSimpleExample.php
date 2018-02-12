<?php

namespace App\Http\Controllers\Admin;
//use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Handler\MoController2;

class RolesController extends MoController2
{
    use \App\Handler\trt\crud\IndexSimple;
    use \App\Handler\trt\crud\CrudSimple;
//use  \App\Handler\trt\redirect\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;


protected $PAR= [ 
    'view_varname'=>'param', // ezen a néven kapják meg a view-ek a $PAR-t
      'routes'=>['base'=>'manager/wroletimes'],
    'view'=>'', //lehet tömb is pl view/base traitel.
    // Ekkor a base-nek csak a gyökerét  kell megadni (pl. admin.role)
    // a tasknak a fájlt is (pl.. admin.role.edit)
    'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
    'cim'=>'',  //a templétben megjelenő cím
      'search'=>true,  // ha false kikapcsolja az index táblázat kereső mezőjét
    
];

protected $TPAR= [];


protected $BASE= [
    'viewfunc'=>'mo_view', //ha nincs megadva a laravel viewet használja, a A PAR[view] nem lehet tömb!
    'redirfunc'=>'mo_redirect', //ha nincs megadva a laravel redir használja, a A PAR[routes][base]-el
    'perpage'=>50, //táblázat ennyi elemet listáz
    'search_column'=>'',//mezők amiben keres 
    'obname'=>'\App\Wroletime', //lehet tömb is ha ha a setobArray trait-et  hívjuk be
    'ob'=>null,
    'request',  //construktor másolja ide az aktuális requestet
    'data'=>[], // az aktuális viewnek átadott adatok
    'func'=>[ // a constructor által lefuttatni kívánt funkciók  
    'set_baseparam',  //hogy ne kelljen  a set base felülírnii
    'set_ob',   //$this, a fő objektumot állítja elő az 'ob'-ba az 'obname' alapján 
],
];
/**
 * taskok base értékei, a Handler\trt\SetController->set_task() az aktuális task kulcsa alatt szereplő értékekkel felül írja a $BASE értékeit
 */
protected $TBASE= [
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