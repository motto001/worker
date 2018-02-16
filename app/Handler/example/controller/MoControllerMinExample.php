<?php
namespace App\Http\Controllers\Manager;

use App\Handler\MoController;
use App\Http\Requests;
//use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\View;

class DaytypesController extends MoController
{
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOcrud;
    use \App\Handler\trt\redirect\Base;
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg

    protected $par = [
        'routes' => ['base' => 'admin/users'],
        'view' => ['base' => 'crudbase', 'include' => 'admin.users'],
    ];
    protected $base = [
        'obname' => 'app/User', //lehet tömb is ha ha a setobArray trait-et  hívjuk be
    ];

    protected $val = [
        'name' => 'required|string|min:5|max:50',
        'szorzo' => 'between:0,3|nullable',
        'fixplusz' => 'integer|nullable',
        'color' => 'string|nullable|max:50',
        'datum' => 'date|nullable',
    ];

}
