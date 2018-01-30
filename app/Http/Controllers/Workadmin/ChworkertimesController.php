<?php

namespace App\Http\Controllers\Workadmin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Chworkertime;
use Illuminate\Http\Request;
use Session;

class ChworkertimesController extends Controller
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
            $chworkertimes = Chworkertime::where('workerday_id', 'LIKE', "%$keyword%")
				->orWhere('workertime_id', 'LIKE', "%$keyword%")
				->orWhere('timetype_id', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('end', 'LIKE', "%$keyword%")
				->orWhere('hour', 'LIKE', "%$keyword%")
				->orWhere('managernote', 'LIKE', "%$keyword%")
				->orWhere('workernote', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $chworkertimes = Chworkertime::paginate($perPage);
        }

        return view('workadmin.chworkertimes.index', compact('chworkertimes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('workadmin.chworkertimes.create');
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
			'day_id' => 'required|integer',
			'Timetype_id' => 'required|integer',
			'start' => 'required|time',
			'end' => 'time',
			'hour' => 'required|integer|max:24',
			'managernote' => 'string|max:200',
			'workernote' => 'string|max:200',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        Chworkertime::create($requestData);

        Session::flash('flash_message', 'Chworkertime added!');

        return redirect('workadmin/chworkertimes');
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
        $chworkertime = Chworkertime::findOrFail($id);

        return view('workadmin.chworkertimes.show', compact('chworkertime'));
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
        $chworkertime = Chworkertime::findOrFail($id);

        return view('workadmin.chworkertimes.edit', compact('chworkertime'));
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
			'day_id' => 'required|integer',
			'Timetype_id' => 'required|integer',
			'start' => 'required|time',
			'end' => 'time',
			'hour' => 'required|integer|max:24',
			'managernote' => 'string|max:200',
			'workernote' => 'string|max:200',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        $chworkertime = Chworkertime::findOrFail($id);
        $chworkertime->update($requestData);

        Session::flash('flash_message', 'Chworkertime updated!');

        return redirect('workadmin/chworkertimes');
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
        Chworkertime::destroy($id);

        Session::flash('flash_message', 'Chworkertime deleted!');

        return redirect('workadmin/chworkertimes');
    }
}
