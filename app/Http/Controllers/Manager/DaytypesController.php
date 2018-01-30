<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use App\Daytype;
use Illuminate\Http\Request;
use Session;

class DaytypesController extends Controller
{
protected $paramT= [
        'baseroute'=>'manager/daytypes',
        'baseview'=>'manager.daytypes', 
        'cim'=>'Nap tipusok',
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
            $daytypes = Daytype::where('name', 'LIKE', "%$keyword%")
				->orWhere('szorzo', 'LIKE', "%$keyword%")
				->orWhere('fixplusz', 'LIKE', "%$keyword%")
				->orWhere('color', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $daytypes = Daytype::paginate($perPage);
        }
        $data['list']= $daytypes;
        return view('crudbase.index', compact('data'));;
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
			'name' => 'required|string|min:5|max:50',
			'szorzo' => 'between:0,99.99|nullable',
			'fixplusz' => 'integer|nullable',
			'color' => 'string|nullable|max:50',
			'note' => 'string|nullable|max:150'
		]);
        $requestData = $request->all();
        
        Daytype::create($requestData);

        Session::flash('flash_message', 'Daytype added!');

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
        $data = Daytype::findOrFail($id);

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
        $data = Daytype::findOrFail($id);
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
			'name' => 'required|string|min:5|max:50',
			'szorzo' => 'between:0,99.99|nullable',
			'fixplusz' => 'integer|nullable',
			'color' => 'string|nullable|max:50',
			'note' => 'string|nullable|max:150'
		]);
        $requestData = $request->all();
        
        $daytype = Daytype::findOrFail($id);
        $daytype->update($requestData);

        Session::flash('flash_message', 'Daytype updated!');

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
        Daytype::destroy($id);

        Session::flash('flash_message', 'Daytype deleted!');

        return redirect($this->paramT['baseroute']);
    }
}
