<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Route;
use App\Day;
use App\Worker;
use App\Daytype;
use Illuminate\Http\Request;
use Session;

class DaysController extends Controller
{
    protected $paramT= [
        'baseroute'=>'manager/days',
        'baseview'=>'manager.days', 
        'crudview'=>'crudbase_1', 
        'ob'=>'\App\Day', 
        'cim'=>'Napok'
      
    ];

    protected $valT= [
       // 'worker_id' => 'required|integer',
        'daytype_id' => 'integer',
        'datum' => ['required','unique:days','regex:/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/'],
        'note' => 'string|max:150',
       // 'usernote' => 'string|max:150'
    ];
    
    function __construct(Request $request){
  
        $this->paramT['id']=$request->route('id') ;//day id
        $t = \Carbon::now();
        $this->paramT['getT']['ev']=Input::get('ev') ?? $t->year; 
        $this->paramT['getT']['ho']=Input::get('ho') ?? $t->month; 

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
        $where[]= ['id', '<>','0']; //hogx mindenképpen legyen where
        //$where[]= ['datum', 'like', '0000%']; 
        if($this->paramT['getT']['ev']=='all'){}
        else if($this->paramT['getT']['ev']=='0000'){$where[]= ['datum', 'like','0000%'];}
        else{$where[]= ['datum', 'like', $this->paramT['getT']['ev'].'%'];}
        if (!empty($keyword)) {
            $workerdays = Day::with('daytype')
               // ->where($where )
				->orWhere('daytype_id', 'LIKE', "%$keyword%")
                ->orWhere('datum', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $workerdays = $this->paramT['ob']::with('daytype')
            ->where($where )
            ->paginate($perPage);
        } 
   
        $data['list']=$workerdays;
      //  $calendar=new \App\Handler\Calendar;
      //  $data['calendar']=$calendar->getDays($this->paramT['getT']['ev'],$this->paramT['getT']['ho']);
      // $data['daytype']=Daytype::get()->pluck('name','id');
      $data['years']=['all','0000','2017'];
        return view($this->paramT['crudview'].'.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
       // $data = Days::get();
        $data['daytype']=Daytype::get()->pluck('name','id');
        return view($this->paramT['crudview'].'.create',compact('data'));
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
        $this->validate($request,$this->valT );
        $requestData = $request->all();
       
        Day::create($requestData);
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
        $data = Day::findOrFail($id);

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
        $data = Day::findOrFail($id);
        $data['id']=$id ;
        $data['daytype']=Daytype::get()->pluck('name','id');
        return view($this->paramT['crudview'].'.edit', compact('data'));
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
        $this->validate($request,$this->valT );
        $requestData = $request->all();
        
        $workerday = Day::findOrFail($id);
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
        Day::destroy($id);

        Session::flash('flash_message', 'Workerday deleted!');

        return redirect($this->paramT['baseroute']);
    }
}
