<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Workertime;
use Illuminate\Http\Request;
use Session;

class WorkertimesController extends Controller
{
    protected $paramT= [
        'baseroute'=>'manager/workertimes',
        'baseview'=>'manager.workertimes', 
        'cim'=>'Munkaidők',
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
            $workertimes = Workertime::where('day_id', 'LIKE', "%$keyword%")
				->orWhere('timetype_id', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('end', 'LIKE', "%$keyword%")
				->orWhere('hour', 'LIKE', "%$keyword%")
				->orWhere('managernote', 'LIKE', "%$keyword%")
				->orWhere('workernote', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $workertimes = Workertime::paginate($perPage);
        }

        $data['list']= $workertimes;
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
        
        Workertime::create($requestData);

        Session::flash('flash_message', 'Workertime added!');

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
        $data = Workertime::findOrFail($id);

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
        $data = Workertime::findOrFail($id);
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
        
        $workertime = Workertime::findOrFail($id);
        $workertime->update($requestData);

        Session::flash('flash_message', 'Workertime updated!');

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
        Workertime::destroy($id);

        Session::flash('flash_message', 'Workertime deleted!');

        return redirect($this->paramT['baseroute']);
    }
}
