<?php

namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Chemail;
use Illuminate\Http\Request;
use Session;

class ChemailController extends Controller
{
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
            $chemail = Chemail::where('email', 'LIKE', "%$keyword%")
				->orWhere('password', 'LIKE', "%$keyword%")
				->orWhere('password2', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $chemail = Chemail::paginate($perPage);
        }

        return view('user.chemail.index', compact('chemail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('user.chemail.create');
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
			'email' => 'required|email',
			'password' => 'required|min:6',
			'password2' => 'required|same:password'
		]);
        $requestData = $request->all();
        
        Chemail::create($requestData);

        Session::flash('flash_message', 'Chemail added!');

        return redirect('user/chemail');
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
        $chemail = Chemail::findOrFail($id);

        return view('user.chemail.show', compact('chemail'));
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
        $chemail = Chemail::findOrFail($id);

        return view('user.chemail.edit', compact('chemail'));
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
			'email' => 'required|email',
			'password' => 'required|min:6',
			'password2' => 'required|same:password'
		]);
        $requestData = $request->all();
        
        $chemail = Chemail::findOrFail($id);
        $chemail->update($requestData);

        Session::flash('flash_message', 'Chemail updated!');

        return redirect('user/chemail');
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
        Chemail::destroy($id);

        Session::flash('flash_message', 'Chemail deleted!');

        return redirect('user/chemail');
    }
}
