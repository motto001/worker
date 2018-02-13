<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Route;
use App\Day;
use App\Worker;
use App\Daytype;
use Illuminate\Http\Request;
use Session;
use App\Handler\MoController2;

class DaysController extends MoController2
{
    protected $paramT= [
        'baseroute'=>'manager/days',
        'baseview'=>'manager.days', 
        'crudview'=>'crudbase_3', 
        'ob'=>'\App\Day', 
        'cim'=>'Napok'
      
    ];
    use \App\Handler\trt\crud\IndexSimple;
    use \App\Handler\trt\crud\CrudSimple;
//use  \App\Handler\trt\redirect\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;


protected $PAR= [ 
    'view_varname'=>'param', // ezen a néven kapják meg a view-ek a $PAR-t
      'routes'=>['base'=>'manager/days'],
    'view'=>'manager.days', //lehet tömb is pl view/base traitel.
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
    protected $valT= [
       // 'worker_id' => 'required|integer',
        'daytype_id' => 'integer',
        'datum' => ['required','unique:days','regex:/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/'],
        'note' => 'string|max:150',
       // 'usernote' => 'string|max:150'
    ];
    
function edit_set(){
    $this->BASE['data']['daytype']=Daytype::pluck('name','id');
}
}
