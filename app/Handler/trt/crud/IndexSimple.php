<?php

namespace App\Handler\trt\crud;
use Illuminate\Http\Request;
use Session;
//use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Image;
Trait IndexSimple
{

   public function index(Request $request)
    {    
        $data=[];  
        $keyword = $request->get('search');
        $perPage = 25;
        $search_columnT=$this->BASE['search_column'] ?? [];
        $ob= new $this->BASE['obname']();
        if (!empty($keyword)) {
            $ob = $ob->where('id', '<', "1");
            foreach($search_columnT as $col)
            {
                $ob=$ob->orwhere('name', 'LIKE', "%$keyword%");
            }
			$data=$ob->paginate($perPage);
        } else {
            $data = $ob->paginate($perPage);
        }
        $param= $this->PAR;
    
        return view($this->PAR['view'].'.index', compact('data','param'));
         
    }
}