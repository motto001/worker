<?php
namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Handler\MoController;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Session;
use \App\Handler\trt\set\Orm; // with, where, order_by
class UsersController extends MoController
{
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOCrud;
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;
    use \App\Handler\trt\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use \App\Handler\trt\property\MoControllerBase; //PAR és BASE 
    //use \App\Handler\trt\set\Orm; // with, where, order_by
    protected $par= [
         'get_key'=>'user',
        'routes'=>['base'=>'manager/users'],
        //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
        'view'=> ['base' => 'crudbase', 'include' => 'manager.users','editform' => 'Manager.users.edit_form'], //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        'cim'=>'Felhasználók',
   
        

    ];
  
    protected $base= [
       // 'search_column'=>'daytype_id,datum,managernote,usernote',
       // 'get'=>['ev'=>null,'ho'=>null], //a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
       // 'get_post'=>['ev'=>null,'ho'=>null],//a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be ha van ilyen kulcs a postban azzal felülírja
        'obname'=>'\App\User',
        'ob'=>null,

    ];


    protected $val= ['name' => 'required', 'email' => 'required', 'password' => 'required', 'roles' => 'required'];
    protected $val_update=  ['name' => 'required', 'email' => 'required', 'roles' => 'required'];
    public function index_set()
    {
    //   print_r($this->BASE['data']);
    }
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
    public function store_set()
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
    public function edit_set()
    {
        $roles = Role::select('id', 'name', 'label')->get();
        $this->BASE['data']['rolesbase'] = $roles->pluck('label', 'name');
      //  $this->BASE['data']['user'] = User::with('roles')->select('id', 'name', 'email')->findOrFail($id);
  
   //  print_r( $this->BASE['data']->roles);
      //  $this->BASE['data']['user_roles'] = [];
        foreach ($this->BASE['data']->roles as $role) {
            $user_roles[] = $role->name;
        }
        $this->BASE['data']['user_roles'] = $user_roles;
    //  print_r( );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int      $id
     * @param  \Illuminate\Http\Request  $request
     *
     * @return void
     */
    public function update_set()
    {     
        if ($this->BASE['request']->has('password')) {
        $this->BASE['data']['password'] = bcrypt( $this->BASE['request']->password);
        }   
        $this->BASE['ob_res']->roles()->detach();
        foreach ($this->BASE['request']->roles as $role) {
            $this->BASE['ob_res']->assignRole($role);
        }

    }

  
}
