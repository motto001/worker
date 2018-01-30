<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Daytype;
use App\Timeframe;
use Illuminate\Http\Request;
use Session;

class TimeframesController extends Controller
{
    protected $paramT= [
        'baseroute'=>'manager/timeframes',
        'baseview'=>'manager.timeframes', 
        'cim'=>'Időkeretek',
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
            $timeframes = Timeframe::where('name', 'LIKE', "%$keyword%")
				->orWhere('unit', 'LIKE', "%$keyword%")
				->orWhere('long', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('hourmax', 'LIKE', "%$keyword%")
				->orWhere('hourmin', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $timeframes = Timeframe::paginate($perPage);
        }

       
        $data['list']=$timeframes;
        return view('crudbase.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['basedaytype']=Daytype::get();
        $data['checked_daytype']=[5];
        return view('crudbase.create',compact('data'));
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
			'name' => 'required|max:200',
			'unit' => 'required|max:50',
			'long' => 'required',
			'note' => 'max:200',
			'pub' => 'max:4'
		]);
        $requestData = $request->all();
        
       // Timeframe::create($requestData);
        Timeframe::create($requestData)->daytype()->sync($request->daytype_id);

        Session::flash('flash_message', 'Timeframe added!');

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
        $data = Timeframe::findOrFail($id);

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

        $data = Timeframe::with(['daytype'])->findOrFail($id);
        $data['basedaytype']=Daytype::get();
    
        foreach($data->daytype as $role){
            
            $checked_daytype[] =  $role->id;
        }
        $data['checked_daytype']=$checked_daytype;
        $data['id']=$id ;
       // $timeframe = Timeframe::findOrFail($id);

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
			'name' => 'required|max:200',
			'unit' => 'required|max:50',
			'long' => 'required',
			'note' => 'max:200',
			'pub' => 'max:4'
		]);
        $requestData = $request->all();
      
        $timeframe = Timeframe::findOrFail($id);
        
        $timeframe->update($requestData);

        $timeframe->daytype()->sync($request->daytype_id);

        //$timeframe = Timeframe::findOrFail($id);
       // $timeframe->update($requestData);

        Session::flash('flash_message', 'Timeframe updated!');

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
        Timeframe::destroy($id);
        \DB::table('daytype_timeframe')->where('timeframe_id', '=', $id)->delete();
        Session::flash('flash_message', 'Timeframe deleted!');

        return redirect($this->paramT['baseroute']);
    }
}
