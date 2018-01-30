<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Conf;
use Illuminate\Http\Request;
use Session;

class ConfController extends Controller
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
            $conf = Conf::where('name', 'LIKE', "%$keyword%")
				->orWhere('value', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $conf = Conf::paginate($perPage);
        }

        return view('admin.conf.index', compact('conf'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.conf.create');
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
			'name' => 'string|required|max:200',
			'value' => 'string|required|max:200',
			'note' => 'string|max:200'
		]);
        $requestData = $request->all();
        
        Conf::create($requestData);

        Session::flash('flash_message', 'Conf added!');

        return redirect('admin/conf');
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
        $conf = Conf::findOrFail($id);

        return view('admin.conf.show', compact('conf'));
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
        $conf = Conf::findOrFail($id);

        return view('admin.conf.edit', compact('conf'));
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
			'name' => 'string|required|max:200',
			'value' => 'string|required|max:200',
			'note' => 'string|max:200'
		]);
        $requestData = $request->all();
        
        $conf = Conf::findOrFail($id);
        $conf->update($requestData);

        Session::flash('flash_message', 'Conf updated!');

        return redirect('admin/conf');
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
        Conf::destroy($id);

        Session::flash('flash_message', 'Conf deleted!');

        return redirect('admin/conf');
    }
}
