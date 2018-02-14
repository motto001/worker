<?php

namespace App\Handler\trt\crud;

use Illuminate\Http\Request;
use Session;
//use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Image;
trait IndexFull
{

    public function index_set()
    {}

    public function index_base()
    {

        $perPage = $this->PAR['perpage'] ?? 50;
        $getT = $this->PAR['getT'] ?? [];
        $search_input_name = $this->PAR['search_input_name'] ?? 'search';
        if (is_callable([$this->BASE['request'], 'get'])) {$this->BASE['keyword'] = $this->BASE['request']->get($search_input_name) ?? '';} else { $this->BASE['keyword'] = '';}

        $ob = $this->BASE['ob']['base'] ?? $this->BASE['ob'];

        if (!empty($this->BASE['keyword'])) {
            if (is_callable([$this, 'search'])) {
                $ob = $this->search($ob);
            }
        } else {
            if (is_callable([$this, 'set_orm'])) {
                $ob = $this->set_orm($ob);
            }
        }
        $this->BASE['data']['list'] = $ob->paginate($perPage);
        if (!empty($getT)) {$this->BASE['data']['list']->appends($getT);}
        //  $this->index_set();
    }
    public function index(Request $request)
    {
        // $this->BASE['ob_base'] =$this->BASE['ob'] ;
        $funcT = $this->TBASE['index']['task_func'] ?? ['index_base', 'index_set'];
        $this->call_func($funcT);
        $viewfunc = $this->BASE['viewfunc'] ?? 'mo_view';
        if (is_callable([$this, $viewfunc])) {return $this->$viewfunc();} else {return view($this->PAR['view'] . '.index', compact('data'));}

    }
}
