<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Handler\MoController;

use App\Conf;
use Illuminate\Http\Request;
use Session;

class ConfController extends MoController
{
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOCrud;
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;
    
    protected $PAR= [ 
    'routes'=>['base'=>'root\conf'],
    'view' => ['base' => 'crudbase', 'include' => 'admin.conf'],
    'cim'=>'Conf',  //a templétben megjelenő cím
  ];

    protected $BASE= [
        'viewfunc'=>'mo_view', //ha nincs megadva a laravel viewet használja, a A PAR[view] nem lehet tömb!
        'redirfunc'=>'mo_redirect', //ha nincs megadva a laravel redir használja, a A PAR[routes][base]-el    
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
