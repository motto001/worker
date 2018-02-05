<?php

namespace App\Handler\trt\crud;
use Illuminate\Http\Request;
use Session;
//use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Image;
Trait IndexFromARR
{
    function get_searchT($keyword,$resmod='all'){
        $res=[];
        if(isset($this->BASE['search_column'])){
            if(!is_array($this->BASE['search_column'])){$this->BASE['search_column']=explode(',',$this->BASE['search_column']);}
            foreach($this->BASE['search_column'] as $key)
            {
                $res[]=[$key, 'LIKE', "%$keyword%"];
            }
            if($resmod='firstno'){ unset($res[0]);}
            else if($resmod='first'){$res=$res[0];}
            }
            if(empty($res)){$res[]=['id', '>', "0"];} 
    return $res;
    }
    public function index_set(){ }
    public function search(){
        /* $this->BASE['ob_base']= $this->BASE['ob_base']
        ->where('user_id', 'LIKE', "%$keyword%")
        ->orWhere('wrole_id', 'LIKE', "%$keyword%")
        ->orWhere('status_id', 'LIKE', "%$keyword%")
        ->paginate($perPage);*/
        return '';
        }
    public function where_or_search(){
        if (!empty($this->BASE['keyword'] )) {
            $this->search();
        } else {
            $this->where();
            $this->orWhere();
        } 
    }

    public function where(){
        $where=$this->BASE['where'] ?? '';
        if ($where!='') {  
         $this->BASE['ob_base'] = $this->BASE['ob_base'] ->where($where);
        } 
     }
     public function orWhere(){
        $orwhere=$this->BASE['orwhere'] ?? '';
        if ($orwhere!='') {  
         $this->BASE['ob_base'] = $this->BASE['ob_base'] ->orWhere($orwhere);
        } 
     }
     public function with(){
        $with=$this->BASE['with'] ?? '';
        if ($with!='') {  
          $this->BASE['ob_base'] =$this->BASE['ob_base']->with($with);   
        }
     //   echo $with;
     }    
      public function order_by(){
        $order_by=$this->BASE['order_by'] ?? [];  
        foreach ($order_by as $column => $direction) {
            $this->BASE['ob_base'] =  $this->BASE['ob_base'] ->orderBy($column, $direction);
        }
     }

    public function index_base(){
        $perPage=$this->PAR['perpage'] ?? 50;
        $getT=$this->PAR['getT'] ?? ['a'=>'a'];
        $search_input_name=$this->PAR['search_input_name'] ?? 'search';

      //  $this->BASE['ob_base']=$this->BASE['ob']; //index-
        if(is_callable([$this->BASE['request'], 'get'])) {$this->BASE['keyword']  = $this->BASE['request']->get($search_input_name) ?? '';} 
        else{$this->BASE['keyword'] = '';}
        $this->index_set();
        $funcT=$this->TBASE['index']['base_func'] ?? ['with','where_or_search','order_by'];
        $this->call_func($funcT);

        
        $this->BASE['data']['list'] = $this->BASE['ob_base']->paginate($perPage)->appends($getT) ;  
        
    }
    public function index(Request $request)
    {
            $this->BASE['ob_base'] =$this->BASE['ob'] ;
            $funcT=$this->TBASE['index']['task_func'] ?? ['index_base'];
            $this->call_func($funcT);
//print_R($this->BASE['data']);
           if(method_exists($this, 'index_view')) {return  $this->index_view();}  
            else{return $this->base_view('index');}
       // return  \MoViewF::view( $this->PAR['view'].'.index',$data);
            
    }
}