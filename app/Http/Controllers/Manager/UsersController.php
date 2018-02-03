<?php
namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Handler\MoController;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Session;

class UsersController extends MoController
{
    use \App\Handler\trt\crud\CrudWithSetfunc;
    use  \App\Handler\trt\SetController;

    protected $par= [
         'get_key'=>'user',
        'routes'=>['base'=>'workadmin/workertimes','worker'=>'manager/worker'],
        //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
        'view'=>'Manager.users', //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim'=>'Felhasználók',
        'getT'=>[],  
        

    ];
  
    protected $base= [
       // 'search_column'=>'daytype_id,datum,managernote,usernote',
        'get'=>['ev'=>null,'ho'=>null], //a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
       // 'get_post'=>['ev'=>null,'ho'=>null],//a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be ha van ilyen kulcs a postban azzal felülírja
        'obname'=>'\App\User',
        'ob'=>null,
       // 'func'=>[  'set_task', 'set_getT','set_date', 'set_redir','set_routes','set_ob'],
      //  'with'=>['worker','timetype'],

    ];


    protected $val= ['name' => 'required', 'email' => 'required', 'password' => 'required', 'roles' => 'required'];
    protected $editval=  ['name' => 'required', 'email' => 'required', 'roles' => 'required'];
    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create_set()
    {
        $roles = Role::select('id', 'name', 'label')->get();
        $this->BASE['data']['roles'] = $roles->pluck('label', 'name');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function store_set(Request $request)
    {

        $this->BASE['data']['password'] = bcrypt( $this->BASE['request']->password);


        foreach ($this->BASE['request']->roles as $role) {
            $user->assignRole($role);
        }
    }

  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit_set($id)
    {
        $roles = Role::select('id', 'name', 'label')->get();
        $this->BASE['data']['roles'] = $roles->pluck('label', 'name');
        $this->BASE['data']['user'] = User::with('roles')->select('id', 'name', 'email')->findOrFail($id);
       
        $this->BASE['data']['user_roles'] = [];
        foreach ($user->roles as $role) {
            $this->BASE['data']['user_roles'] = $role->name;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int      $id
     * @param  \Illuminate\Http\Request  $request
     *
     * @return void
     */
    public function update_set($id, Request $request)
    {     
        if ($this->BASE['request']->has('password')) {
        $this->BASE['data']['password'] = bcrypt( $this->BASE['request']->password);
        }   
        foreach ($this->BASE['request']->roles as $role) {
            $user->assignRole($role);
        }

    }

  
}
