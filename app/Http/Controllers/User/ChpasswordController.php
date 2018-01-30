<?php

namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\chpassword;
use Illuminate\Http\Request;
use Session;

use Illuminate\Support\Facades\Auth;

class ChpasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
       //$chpassword =['id'=> Auth::id()] ;

        return view('user.chpassword.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
      return view('user.chpassword.create');
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
  $this->update($request);
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
     
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
      return view('user.chpassword.create');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $this->validate($request, [
			'oldpassword' => 'required|min:6',
			'password' => 'required|min:6',
			'password2' => 'required|same:password'
		]);
        $requestData = $request->input('password');
        
        $chpassword = User::findOrFail( Auth::id());
        $chpassword->update($requestData);

        Session::flash('flash_message', 'chpassword updated!');

        return redirect('user/chpassword');
    }

   
}
