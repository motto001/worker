<?php

namespace App\Http\Controllers\Admin;

use App\Handler\MoController;
use Illuminate\Support\Facades\View;

class RolesController extends MoController
{
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOCrud;
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;

    protected $PAR = [
      'info_button_link' => '/root/info/roles/info', // role/controller/viewdir/blade
      'create_info_button_link' => '/root/info/roles/infocreate', // role/controller/viewdir/blade
        'routes' =>  ['base' => 'root/roles'], 
        'view' =>  ['base' => 'crudbase', 'include' => 'admin.roles'], //lehet tömb is pl view/base traitel
       //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim' => '', //a templétben megjelenő cím
        'search' => false, // ha false kikapcsolja az index táblázat kereső mezőjét

    ];

    protected $TPAR = [];

    protected $BASE = [
        'obname' => '\App\Role', //lehet tömb is ha ha a setobArray trait-et  hívjuk be
        'ob' => null,
 
    ];
    public $val = ['name' => 'required'];

}
