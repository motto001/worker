<?php

namespace App\Http\Controllers\proba\ProbaController;

use App\Handler\MoController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
//use App\Role; //átírni!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//use App\User;
class ProbaController extends MoController
{
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOCrud;
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;

    use \App\Handler\trt\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use \App\Handler\trt\set\GetT; 
    use \App\Handler\trt\set\Redir; 
    use \App\Handler\trt\set\Routes; 
    use \App\Handler\trt\set\Task; 
    use \App\Handler\trt\set\Orm; 

    use \App\Handler\trt\property\MoControllerBase; //PAR és BASE propertyk hogy legyen mit kiegéaszíteni
    


protected $par= [ 
    'search_input_name'=>'search',
    'view_varname' => 'param', // ezen a néven kapják meg a view-ek a $PAR-t
    'get_key' => '', //pl.:'wrtime' Láncnál ezzel az előtaggal azonosítja  a controller a rávonatkozó get tagokat
    'routes'=>['base'=>'workadmin/workerdays','worker'=>'manager/worker'],
    'view' => ['base' => 'crudbase', 'include' =>'workadmin.workerdays'], 
   // 'crudview' => 'crudbase_4', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
    'cim' => '', //a templétben megjelenő cím
    'getT' => [],
    'search' => true, // ha false kikapcsolja az index táblázat kereső mezőjét 
    //usereknél false ra kell áálítani mert nins megoldva az userre szűkítés
    'show'=>['auto'],// a show file generálja a megjelenítést
    'show'=>[['colname'=>'id','label'=>'Id']]
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
    'obname'=>'\App\User',//lehet tömb is ha ha a setobArray trait-et  hívjuk be
    'orm'=>[
        'with'=>['roles','Worker'],
        'where'=>[['id','=','1'],['name','=','admin']],
        'orwhere'=>[['id','=','2'],['id','<>','3']],
        'order_by'=>['id'=>'desc','name'=>'asc']
],
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
public function create_set()
{
    $this->BASE['data']['basedaytype'] = Daytype::get();
    $this->BASE['data']['checked_daytype'] = [5];

}

/**
 * Show the form for editing the specified resource.
 *
 * @param  int  $id
 *
 * @return \Illuminate\View\View
 */
public function edit_set()
{

    $this->BASE['data']['basedaytype'] = Daytype::get();

    foreach ($this->BASE['data']->daytype as $role) {

        $checked_daytype[] = $role->id;
    }
    $this->BASE['data']['checked_daytype'] = $checked_daytype;
    $this->BASE['data']['id'] = $id;
}

public function store_set()
{
    $id = $this->BASE['ob']->id;
    $this->BASE['ob']->daytype()->attach($this->BASE['request']->daytype_id);
    /*   foreach ($this->BASE['request']->timeframe_id as $tf) {
Workertimeframe::create(['worker_id'=>$worker_id,'timeframe_id'=>$tf]);
}*/
}

public function update_set()
{
    $this->BASE['ob']->daytype()->sync($request->daytype_id);
}

public function destroy_set()
{
    $this->BASE['ob']->daytype()->detach($this->BASE['request']->daytype_id);

}

}