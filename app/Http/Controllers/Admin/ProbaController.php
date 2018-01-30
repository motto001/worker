<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Proba2;
use App\Proba;
use Illuminate\Http\Request;
use Session;

class ProbaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(Request $request)
    {
       
    //  $roles = Role::where('name', 'LIKE', "%$keyword%")->orWhere('label', 'LIKE', "%$keyword%")->paginate($perPage);            
    //  $proba = Proba::with('proba23')->get();
    $with='proba4_hasone';
     $proba = Proba2::with($with)->select('id')->first();
  //  $proba = Proba2::with('proba4_hasone:proba2_id,name')->get()->pluck('proba4_hasone.name', 'id'); //lehet hogy a with mezőkbe be kellírni az id-et
  // $proba2= \MoHandF::subArrMerge($proba->toarray(),'proba4_hasone');
   // print_r($proba2);
   //print_r($proba->toarray());
    print_r($proba->toarray()); 
        //echo $proba->proba4_hasone->proba2_id;
        //return view('admin.roles.index', compact('roles'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        Role::create($request->all());

        Session::flash('flash_message', 'Role added!');

        return redirect('admin/roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);

        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int      $id
     * @param  \Illuminate\Http\Request  $request
     *
     * @return void
     */
    public function update($id, Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        $role = Role::findOrFail($id);
        $role->update($request->all());

        Session::flash('flash_message', 'Role updated!');

        return redirect('admin/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id)
    {
        Role::destroy($id);

        Session::flash('flash_message', 'Role deleted!');

        return redirect('admin/roles');
    }
}