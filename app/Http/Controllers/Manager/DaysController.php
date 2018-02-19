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
use App\Handler\MoController;

class DaysController extends MoController
{
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOCrud;
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;
    

protected $PAR= [ 
   'routes'=>['base'=>'manager/days'],
    'view'=> ['base' => 'crudbase', 'include'=>'manager.days'], //lehet tömb is pl view/base traitel.
    'search'=>false,  // ha false kikapcsolja az index táblázat kereső mezőjét
    
];

protected $TPAR= [];


protected $BASE= [
 
];
    protected $val= [
       // 'worker_id' => 'required|integer',
        'daytype_id' => 'integer',
        'datum' => ['required','unique:days','regex:/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/'],
        'note' => 'string|max:150',
       // 'usernote' => 'string|max:150'
    ];
function create_set(){
        $this->BASE['data']['daytype']=Daytype::pluck('name','id');
    }    
function edit_set(){
    $this->BASE['data']['daytype']=Daytype::pluck('name','id');
}
}
