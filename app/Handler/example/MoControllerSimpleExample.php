<?php
namespace App\Http\Controllers\Manager;

use App\Handler\MoController2;
use App\Http\Requests;
//use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\View;

class DaytypesController extends MoController2
{
    use \App\Handler\trt\crud\IndexSimple;
    use \App\Handler\trt\crud\CrudSimple;
//use  \App\Handler\trt\redirect\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;
    use \App\Handler\trt\set\Base;
    protected $par = [
        'routes' => ['base' => 'manager/daytypes'],
        'view' => ['base' => 'crud_with_include', 'include' => 'manager.daytypes'], //lehet tömb is pl view/base traitel.
        // Ekkor a base-nek csak a gyökerét  kell megadni (pl. admin.role)
        // a tasknak a fájlt is (pl.. admin.role.edit)
        'crudview' => 'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim' => '', //a templétben megjelenő cím

    ];
    protected $base = [
        'obname' => '\App\Daytype', //lehet tömb is ha ha a setobArray trait-et  hívjuk be],
        'func' => [ // a constructor által lefuttatni kívánt funkciók
            'set_baseparam', //hogy ne kelljen  a set base felülírnii
            'set_ob', //$this, a fő objektumot állítja elő az 'ob'-ba az 'obname' alapján
        ],
    ];
    protected $val = [
        'name' => 'required|string|min:5|max:50',
        'szorzo' => 'between:0,3|nullable',
        'fixplusz' => 'integer|nullable',
        'color' => 'string|nullable|max:50',
        'note' => 'string|nullable|max:150',
    ];
/**
 * taskok base értékei, a Handler\trt\SetController->set_task() az aktuális task kulcsa alatt szereplő értékekkel felül írja a $BASE értékeit
 */
    protected $tbase = [
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

    protected $val_update = [];

}
