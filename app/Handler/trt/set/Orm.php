<?php

trait Orm{

public function set_orm($ob){
        $with=$this->BASE['orm']['with'] ?? '';
        if ($with!='') { $ob->with($with); }
        $where=$this->BASE['orm']['where'] ?? '';
        if ($where!='') { $ob->where($where);} 
         $orwhere=$this->BASE['orm']['orwhere'] ?? '';
        if ($orwhere!='') { $ob->orWhere($orwhere);} 
        $order_by=$this->BASE['orm']['order_by'] ?? [];  
        foreach ($order_by as $column => $direction) {
            $ob-->orderBy($column, $direction);
        }
        return $ob;
    }

}

