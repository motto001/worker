<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Session;
use App\Facades\MoView;

class NH_old_UsersController extends Controller
{
    protected $paramT= [
        'baseroute'=>'manager/users',
        'baseview'=>'manager.users', 
        'cim'=>'Felhasználók',
    ];
    
    function __construct(Request $request){
        $this->paramT['id']=$request->route('id') ;
        $this->paramT['parrent_id']=Input::get('parrent_id') ?? 0;

        if($this->paramT['parrent_id']>0){
            $this->paramT['route_param']='/?parrentid='.$this->paramT['parrent_id'];}
        else{
            $this->paramT['route_param']='';}

        View::share('param',$this->paramT);
       }
    
    //use SoftDeletes;  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $users = User::where('name', 'LIKE', "%$keyword%")
				->orWhere('email', 'LIKE', "%$keyword%")
				->orWhere('password', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $users = User::paginate($perPage);
        }
        $data['list']= $users;
        return view('crudbase.index', compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('crudbase.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'name' => 'required|max:100',
			'email' => 'required|email',
			'password' => 'required|min:6'
		]);
        $requestData = $request->all();
        
        User::create($requestData);

        Session::flash('flash_message', 'User added!');

        return redirect($this->paramT['baseroute']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $data = User::findOrFail($id);

 //return  MoView::view( 'manager.users.show',$user,'user');
 return view($this->paramT['baseview'].'.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data = User::findOrFail($id);
        $data['id']=$id ;
        return view('crudbase.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
			'name' => 'required|max:100',
			'email' => 'required|email',
			'password' => 'required|min:6'
		]);
        $requestData = $request->all();
        
        $user = User::findOrFail($id);
        $user->update($requestData);

        Session::flash('flash_message', 'User updated!');

        return redirect($this->paramT['baseroute']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        User::destroy($id);

        Session::flash('flash_message', 'User deleted!');

        return redirect($this->paramT['baseroute']);
    }
}
