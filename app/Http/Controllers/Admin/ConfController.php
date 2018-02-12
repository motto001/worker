<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Handler\MoController2;

use App\Conf;
use Illuminate\Http\Request;
use Session;

class ConfController extends MoController2
{
    use \App\Handler\trt\crud\IndexSimple;
    use \App\Handler\trt\crud\CrudSimple;
//use  \App\Handler\trt\redirect\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;
    
    protected $PAR= [ 
    'routes'=>['base'=>'root\conf'],
    'view'=>'admin.conf', 
    'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
    'cim'=>'Conf',  //a templétben megjelenő cím
    'search'=>true,  // ha false kikapcsolja az index táblázat kereső mezőjét     
    ];

    protected $BASE= [
        'viewfunc'=>'mo_view', //ha nincs megadva a laravel viewet használja, a A PAR[view] nem lehet tömb!
        'redirfunc'=>'mo_redirect', //ha nincs megadva a laravel redir használja, a A PAR[routes][base]-el    
        'perpage'=>50, //táblázat ennyi elemet listáz
        'search_column'=>['name','value','note'],
        'obname'=>'\App\Conf',
        'data'=>[], // az aktuális viewnek átadott adatok
        'func'=>[ // a constructor által lefuttatni kívánt funkciók  
           // 'set_baseparam',  //hogy ne kelljen  a set base felülírnii
            'set_ob',   //$this, a fő objektumot állítja elő az 'ob'-ba az 'obname' alapján 
        ],
    ];
    protected $val= [	
    'name' => 'string|required|max:200',
    'value' => 'string|required|max:200',
    'note' => 'string|max:200'];
}
