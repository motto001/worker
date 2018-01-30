<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Day;
use App\Daytype;
use Illuminate\Http\Request;
use Session;

class UserdayscalendarController extends Controller
{

    protected $paramT= [
        'baseroute'=>'manager/userdays',
        'baseview'=>'manager.userdays', 
        'cim'=>'Napok',
    ];
    protected $valT=[
        'worker_id' => 'integer',
        'datum' => 'required|date',
        'datum' => 'required|string',
        'note' => 'string'
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
            $days = Day::with('daytype')->where('daytype_id', 'LIKE', "%$keyword%")
				->orWhere('datum', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $days = Day::with('daytype')->paginate($perPage);
        }

        $data['list']=$days;

    // Generate a new fullcalendar instance
    $calendar = new \Edofre\Fullcalendar\Fullcalendar();
    
            // You can manually add the objects as an array
            $events = $this->getEvents();
            $calendar->setEvents($events);
            // Or you can add a route and return the events using an ajax requests that returns the events as json
            //$calendar->setEvents(route('fullcalendar-ajax-events'));
    
            // Set options
            $calendar->setOptions([
                'locale'      => 'hu',
                'weekNumbers' => true,
                'selectable'  => true,
                'defaultView' => 'agendaWeek',
                // Add the callbacks
                'eventClick' => new \Edofre\Fullcalendar\JsExpression("
                    function(event, jsEvent, view) {
                        console.log(event);
                    }
                "),
                'viewRender' => new \Edofre\Fullcalendar\JsExpression("
                    function( view, element ) {
                        console.log(\"View \"+view.name+\" rendered\");
                    }
                "),
            ]);
    
            // Check out the documentation for all the options and callbacks.
            // https://fullcalendar.io/docs/
    
       //     return view('fullcalendar.index', [
       //         'calendar' => $calendar,
       //     ]);

       $data['calendar']=$calendar;
        return view('crudbase.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        //$data = Day::get();
        $data['daytype']=Daytype::get()->pluck('name','id');
        $data['datum']='01-01';
        return view('crudbase.create' ,compact('data'));
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
        $this->validate($request,$this->valT);
        $requestData = $request->all();
        $request->ev=$request->ev ?? '0000';
        $requestData['datum']= $request->ev.'-'. $request->datum;
        Day::create($requestData);

        Session::flash('flash_message', 'Day added!');

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
        $data['datum']=substr($data['datum'],5);
        $data['daytype']=Daytype::get()->pluck('name','id');
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
        $this->validate($request,$this->valT);
        $requestData = $request->all();
        $request->ev=$request->ev ?? '0000';
        $requestData['datum']= $request->ev.'-'. $request->datum;
        $day = Day::findOrFail($id);
        $day->update($requestData);

        Session::flash('flash_message', 'Day updated!');

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

        Session::flash('flash_message', 'Day deleted!');

        return redirect($this->paramT['baseroute']);
    }


    /**
     * @param Request $request
     * @return string
     */
    public function ajaxEvents(Request $request)
    {
        // start and end dates will be sent automatically by fullcalendar, they can be obtained using:
        // $request->get('start') & $request->get('end')
        $events = $this->getEvents();
        return json_encode($events);
    }

    /**
     * @return array
     */
    private function getEvents()
    {
        $events = [];
        $events[] = new \Edofre\Fullcalendar\Event([
            'id'     => 0,
            'title'  => 'Rest',
            'allDay' => true,
            'start'  => Carbon::create(2016, 11, 20),
            'end'    => Carbon::create(2016, 11, 20),
        ]);

        $events[] = new \Edofre\Fullcalendar\Event([
            'id'    => 1,
            'title' => 'Appointment #' . rand(1, 999),
            'start' => Carbon::create(2016, 11, 15, 13),
            'end'   => Carbon::create(2016, 11, 15, 13)->addHour(2),
        ]);

        $events[] = new \Edofre\Fullcalendar\Event([
            'id'               => 2,
            'title'            => 'Appointment #' . rand(1, 999),
            'editable'         => true,
            'startEditable'    => true,
            'durationEditable' => true,
            'start'            => Carbon::create(2016, 11, 16, 10),
            'end'              => Carbon::create(2016, 11, 16, 13),
        ]);

        $events[] = new \Edofre\Fullcalendar\Event([
            'id'               => 3,
            'title'            => 'Appointment #' . rand(1, 999),
            'editable'         => true,
            'startEditable'    => true,
            'durationEditable' => true,
            'start'            => Carbon::create(2016, 11, 14, 9),
            'end'              => Carbon::create(2016, 11, 14, 10),
            'backgroundColor'  => 'black',
            'borderColor'      => 'red',
            'textColor'        => 'green',
        ]);
        return $events;
    }




}
