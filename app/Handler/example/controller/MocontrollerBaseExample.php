<?php
namespace App\Http\Controllers\Manager; //átírni!!!!!!!!!!!!!!!!!!!!!!!!!!!!
use App\Handler\MoController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
//use App\Role; //átírni!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//use App\User;
class UsersController extends MoController
{
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOCrud;
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;
    use \App\Handler\trt\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use \App\Handler\trt\property\MoControllerBase; //PAR és BASE propertyk hogy legyen mit kiegéaszíteni
    use \App\Handler\trt\set\Orm; // with, where, order_by

    protected $par = [
        'routes' => ['base' => 'manager/users'],
        'view' => ['base' => 'crudbase', 'include' => 'manager.users'],//'editform' => 'Manager.users.edit_form' innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        'cim' => '',
        'show' => ['auto'], // a show file generálja a megjelenítést
        //  'show'=>[['colname'=>'id','label'=>'Id']]
    ];

    protected $base = [
        'obname' => '\App\User',
        'orm' => [
            'with' => ['roles', 'Worker'],
            'where' => [['id', '=', '1'], ['name', '=', 'admin']],
            'orwhere' => [['id', '=', '2'], ['id', '<>', '3']],
            'order_by' => ['id' => 'desc', 'name' => 'asc'],
        ],
    ];

    // protected $val = []; //pl.:['wroleunit_id' => 'required|integer','end' => 'date_format:H:i','note' => 'string|max:200|nullable']

    // protected $val_update = [];

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
