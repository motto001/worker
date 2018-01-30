<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Timetype;
use App\Wroletime;
use Illuminate\Http\Request;
use Session;

class NH_WroletimesController extends Controller
{
        protected $paramT= [
            'baseroute'=>'manager/wroletimes',
            'baseview'=>'manager.wroletimes', 
            'cim'=>'Munkarendidők',
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
            $wroletimes = Wroletime::where('wroleunit_id', 'LIKE', "%$keyword%")
				->orWhere('timetype_id', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('end', 'LIKE', "%$keyword%")
				->orWhere('hour', 'LIKE', "%$keyword%")
				->orWhere('managernote', 'LIKE', "%$keyword%")
				->orWhere('workernote', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $wroletimes = Wroletime::with('timetype')->paginate($perPage);
        }
        $data['list']=$wroletimes;
        return view('crudbase.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $wroletime = Wroletime::get();
        $wroletime['timetype']= Timetype::pluck('name','id');
        $wroletime['wroleunit_id']= 0;
        return view('manager.wroletimes.create',compact('wroletime'));
    }
    public function create2($id)
    {
        $wroletime = Wroletime::get();
        $wroletime['timetype']= Timetype::pluck('name','id');
        $wroletime['wroleunit_id']= $id;
        return view('manager.wroletimes.create',compact('wroletime'));
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
			'wroleunit_id' => 'required|integer',
			'timetype_id' => 'required|integer',
			'start' => 'required|date_format:H:i',
			'end' => 'date_format:H:i',
			'hour' => 'required|integer|max:24',
			'managernote' => 'string|max:200|nullable',
			'workernote' => 'string|max:200|nullable',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        Wroletime::create($requestData);

        Session::flash('flash_message', 'Wroletime added!');

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
        $data = Wroletime::findOrFail($id);

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
        $data = Wroletime::findOrFail($id);
        $data['timetype']= Timetype::pluck('name','id');
        $data['id']=$id ;
        return view('crudbase.edit', compact('data'));
    }
    /*
    public function edit2($id,$wroleunit_id)
    {
        $wroletime = Wroletime::findOrFail($id);
        $wroletime['timetype']= Timetype::pluck('name','id');
        $wroletime['wroleunit_id']= $wroleunit_id;
        return view('manager.wroletimes.edit', compact('wroletime'));
    }*/
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
            'wroleunit_id' => 'required|integer',
			'timetype_id' => 'required|integer',
			'start' => 'required|date_format:H:i',
			'end' => 'date_format:H:i',
			'hour' => 'required|integer|max:24',
			'managernote' => 'string|max:200|nullable',
			'workernote' => 'string|max:200|nullable',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        $wroletime = Wroletime::findOrFail($id);
        $wroletime->update($requestData);

        Session::flash('flash_message', 'Wroletime updated!');

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
        Wroletime::destroy($id);

        Session::flash('flash_message', 'Wroletime deleted!');

        return redirect($this->paramT['baseroute']);
    }
}
