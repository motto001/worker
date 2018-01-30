<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Workertype;
use Illuminate\Http\Request;
use Session;

class WorkertypesController extends Controller
{
    protected $paramT= [
        'baseroute'=>'manager/workertypes',
        'baseview'=>'manager.workertypes', 
        'cim'=>'Munkatipus',
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
            $workertypes = Workertype::where('name', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $workertypes = Workertype::paginate($perPage);
        }
        $data['list']=$workertypes;
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
			'name' => 'required|string',
			'note' => 'string|nullable'
		]);
        $requestData = $request->all();
        
        Workertype::create($requestData);

        Session::flash('flash_message', 'Workertype added!');

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
        $data = Workertype::findOrFail($id);

        return view($this->paramT['baseroute'].'.show', compact('data'));
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
        $data= Workertype::findOrFail($id);
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
			'name' => 'required|string',
			'note' => 'string|nullable'
		]);
        $requestData = $request->all();
        
        $workertype = Workertype::findOrFail($id);
        $workertype->update($requestData);

        Session::flash('flash_message', 'Workertype updated!');

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
        Workertype::destroy($id);

        Session::flash('flash_message', 'Workertype deleted!');

        return redirect($this->paramT['baseroute']);
    }
}
