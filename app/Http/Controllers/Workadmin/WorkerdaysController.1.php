<?php

namespace App\Http\Controllers\Workadmin;

use App\Day;
use App\Daytype;
use App\Handler\MoController;
use App\Worker;
use App\Workerday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Session;

class WorkerdaysController1 extends MoController
{
    use \App\Handler\trt\crud\IndexFull;
    use \App\Handler\trt\crud\MOCrud;
    use \App\Handler\trt\view\Base;
    use \App\Handler\trt\redirect\Base;

    use \App\Handler\trt\set\Base; //akkor kell ha csak kiegészítjük A paramétereket nem PAR-t csak par-t adunk meg
    use \App\Handler\trt\set\GetT;
    use \App\Handler\trt\set\Redir;
    use \App\Handler\trt\set\Routes;
    use \App\Handler\trt\set\Task;
    use \App\Handler\trt\set\Orm;

    use \App\Handler\trt\property\MoControllerBase; //PAR és BASE propertyk hogy legyen mit kiegéaszíteni

    protected $par = [
        //'baseroute'=>'workadmin/workerdays',
        'routes' => ['base' => 'workadmin/workerdays', 'worker' => 'manager/worker'],
        //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
        'view' => ['base' => 'crudbase', 'include' => 'workadmin.workerdays'], //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        'cim' => 'Dolgozói napok',
        'getT' => ['w_id' => 0],
    ];

    protected $base = [
        'search_column' => 'daytype_id,datum,managernote,usernote',
        'get' => ['w_id' => null, 'ev' => null, 'ho' => null], //a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
        // 'get_post'=>[],//a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be ha van ilyen kulcs a postban azzal felülírja
        'obname' => '\App\Workerday',
        'ob' => null,
        'orm' => [
            'with' => ['worker', 'daytype'],
            'order_by' => ['id' => 'desc'],
        ],
    ];

    protected $val = [
        'worker_id' => 'required|integer',
        'daytype_id' => 'integer',
        'wish_id' => 'integer',
        'day' => 'integer|max:31',
        'datum' => 'date',
        'managernote' => 'string|max:150',
        //  'usernote' => 'string|max:150'
    ];
    protected $val_edit = [];

    public function set_date()
    {

        $t = \Carbon::now();
        $this->BASE['data']['ev'] = $this->PAR['getT']['ev'] ?? $t->year;
        $this->BASE['data']['ho'] = $this->PAR['getT']['ho'] ?? $t->month;
        if (strlen($this->BASE['data']['ho']) < 2) {
            $this->BASE['data']['ho'] = '0' . $this->BASE['data']['ho'];
        }
    }
    public function construct_set()
    {
        $worker_id = $this->PAR['getT']['w_id'] ?? 0;
        if ($worker_id > 0) {$this->BASE['orm']['where'] = [['worker_id', '=', $worker_id]];}
    }
    public function index_set()
    {
//print_r($this->BASE['data']);
        $data['years'] = ['2017', '2018'];
        $data['daytype'] = Daytype::get()->pluck('name', 'id');
        $data['workers'] = Worker::with('user')->get()->toarray();
        $data['workers'][] = ['name' => 'osszes worker', 'id' => 0, 'user' => ['name' => 'összes']];
        $this->BASE['data'] = array_merge($this->BASE['data'], $data);

  
    }

    public function getWorkerday($worker_id, $ev, $ho)
    {
        $res = [];
        //-----------------------
        $dayT = Day::where('datum', 'LIKE', $ev . "-" . $ho . "%")
            ->orwhere('datum', 'LIKE', "0000-" . $ho . "%")
            ->get();

        foreach ($dayT as $day) {$res[$day->datum] = ['datatype' => 'day', 'datum' => $day->datum, 'id' => $day->id, 'daytype_id' => $day->daytype_id, 'wish_id' => 1];}
        //------------------------
        $workerdayT = Workerday::where([
            ['worker_id', '=', $worker_id],
            ['datum', 'LIKE', $ev . "-" . $ho . "%"],
        ])->get();
        foreach ($workerdayT as $day) {$res[$day->datum] = ['datatype' => 'workerday', 'datum' => $day->datum, 'id' => $day->id, 'daytype_id' => $day->daytype_id, 'wish_id' => $day->wish_id];

        }
//   print_r($worker_id);
        return $res;

    }

    public function create_set()
    {
        $this->set_date();
        $workerdayT = [];
        $data['daytype'] = Daytype::get()->pluck('name', 'id');
        $data['workers'] = Worker::with('user')->get();
       
        if (isset($this->PAR['getT']['w_id']) && $this->PAR['getT']['w_id'] > 0) {
            $workerdayT = $this->getWorkerday($this->PAR['getT']['w_id'], $this->PAR['getT']['ev'], $this->PAR['getT']['ho']);
            $calendar = new \App\Handler\Calendar;
            $calT = $calendar->getMonthDays($this->PAR['getT']['ev'], $this->PAR['getT']['ho']);
            $data['calendar'] = \MoHandF::mergeAssoc($calT, $workerdayT);
        }

        $this->BASE['data'] = array_merge($this->BASE['data'], $data);
    }
//az egész store-t felül kell írni
    public function store(Request $request)
    {
        $this->validate($request, $this->val);
        $requestData = $request->all();
        $requestData['datum'] = $this->PAR['getT']['ev'] . '-' . $this->PAR['getT']['ho'] . '-' . $requestData['day'];
        $days = Workerday::select('id')->where([['datum', '=', $requestData['datum']], ['worker_id', '=', $requestData['worker_id']]])->first();
        if (isset($days->id) && $days->id > 0) {
            $this->update($days->id, $request);
        } else {
            Workerday::create($requestData);
            Session::flash('flash_message', 'Workerday added!');
            // echo 'store';
            return redirect(\MoHandF::url($this->PAR['baseroute'] . '/create', $this->PAR['getT']));
        }

    }


    public function pub()
    {
        $id = Input::get('id');

        $this->BASE['ob'] = $this->BASE['ob']->findOrFail($id);
        $wish_id = $this->BASE['ob']->wish_id;
        $this->BASE['ob']->update(['daytype_id' => $wish_id]);

        return $this->base_redirect();
    }

    public function edit_set($id)
    {
        $data = Workerday::with('worker')->findOrFail($id);
        $data['id'] = $id;
        $data['daytype'] = Daytype::get()->pluck('name', 'id');
        $this->BASE['data'] = array_merge($this->BASE['data'], $data);
    }

    public function update_set($id, $valT, $request)
    {
        $this->validate($request, $valT);
        $requestData = $request->all();
        if (isset($requestData['day']) && !isset($requestData['datum'])) {
            $requestData['datum'] = $this->PAR['getT']['ev'] . '-' . $this->PAR['getT']['ho'] . '-' . $requestData['day'];
        }
        return $requestData;
    }
}
