<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Conf;
use Illuminate\Http\Request;
use Session;

class ConfController extends Controller
{
    use  \App\Handler\trt\crud\IndexSimple;
    use  \App\Handler\trt\crud\CrudSimple;
    protected $PAR= [ 
    'routes'=>['base'=>'root\conf'],
    'view'=>'admin.conf', 
    'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
    'cim'=>'Conf',  //a templétben megjelenő cím
    'search'=>true,  // ha false kikapcsolja az index táblázat kereső mezőjét     
    ];

    protected $BASE= [
        'perpage'=>50, //táblázat ennyi elemet listáz
        'search_column'=>['name','value','note'],
        'obname'=>'\App\Conf',
        'data'=>[], // az aktuális viewnek átadott adatok
    ];
    protected $val= [	
    'name' => 'string|required|max:200',
    'value' => 'string|required|max:200',
    'note' => 'string|max:200'];
}
