<?php

namespace App\Http\Controllers\Workadmin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Chworkerday;
use Illuminate\Http\Request;
use Session;

class ChworkerdayController extends Controller
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
            $chworkerday = Chworkerday::where('workerday_id', 'LIKE', "%$keyword%")
				->orWhere('daytype_id', 'LIKE', "%$keyword%")
				->orWhere('managernote', 'LIKE', "%$keyword%")
				->orWhere('workernote', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $chworkerday = Chworkerday::paginate($perPage);
        }

        return view('workadmin.chworkerday.index', compact('chworkerday'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('workadmin.chworkerday.create');
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
			'day_id' => 'integer',
			'daytype_id' => 'required|integer',
			'note' => 'string',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        Chworkerday::create($requestData);

        Session::flash('flash_message', 'Chworkerday added!');

        return redirect('workadmin/chworkerday');
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
        $chworkerday = Chworkerday::findOrFail($id);

        return view('workadmin.chworkerday.show', compact('chworkerday'));
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
        $chworkerday = Chworkerday::findOrFail($id);

        return view('workadmin.chworkerday.edit', compact('chworkerday'));
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
			'day_id' => 'integer',
			'daytype_id' => 'required|integer',
			'note' => 'string',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        $chworkerday = Chworkerday::findOrFail($id);
        $chworkerday->update($requestData);

        Session::flash('flash_message', 'Chworkerday updated!');

        return redirect('workadmin/chworkerday');
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
        Chworkerday::destroy($id);

        Session::flash('flash_message', 'Chworkerday deleted!');

        return redirect('workadmin/chworkerday');
    }
}
