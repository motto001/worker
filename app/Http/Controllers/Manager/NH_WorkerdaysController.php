<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;

use App\Workerday;
use Illuminate\Http\Request;
use Session;

class WorkerdaysController extends Controller
{
    protected $paramT= [
        'baseroute'=>'manager/workerdays',
        'baseview'=>'manager.workerdays', 
        'crudbase'=>'crudbase_1', 
        'cim'=>'Dolgozói napok',
    ];
    
    function __construct(Request $request){
    
        $this->paramT['id']=$request->route('id') ;
        $this->paramT['parrent_id']=Input::get('parrent_id') ?? 0;

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
            $workerdays = Workerday::where('worker_id', 'LIKE', "%$keyword%")
				->orWhere('daytype_id', 'LIKE', "%$keyword%")
				->orWhere('datum', 'LIKE', "%$keyword%")
				->orWhere('managernote', 'LIKE', "%$keyword%")
				->orWhere('usernote', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $workerdays = Workerday::paginate($perPage);
        }

        $data['list']=$workerdays;
        return view($this->paramT['crucbase'].'.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view($this->paramT['crucbase'].'.create');
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
			'worker_id' => 'integer',
			'daytype_id' => 'integer',
			'datum' => 'required|date',
			'managernote' => 'string|max:150',
			'usernote' => 'string|max:150'
		]);
        $requestData = $request->all();
        
        Workerday::create($requestData);

        Session::flash('flash_message', 'Workerday added!');

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
        $data = Workerday::findOrFail($id);

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
        $data = Workerday::findOrFail($id);
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
			'worker_id' => 'integer',
			'daytype_id' => 'integer',
			'datum' => 'required|date',
			'managernote' => 'string|max:150',
			'usernote' => 'string|max:150'
		]);
        $requestData = $request->all();
        
        $workerday = Workerday::findOrFail($id);
        $workerday->update($requestData);

        Session::flash('flash_message', 'Workerday updated!');

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
        Workerday::destroy($id);

        Session::flash('flash_message', 'Workerday deleted!');

        return redirect($this->paramT['baseroute']);
    }
}
