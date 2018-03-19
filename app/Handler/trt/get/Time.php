<?php

namespace App\Handler\trt\get;
//use Illuminate\Support\Facades\Input;
Trait Time
{

    public function getWorkertime($daytT)
    {
        $res=[];
        $worker_id=$this->BASE['data']['worker_id'];
        $ev=$this->BASE['data']['ev'];
        $ho=$this->BASE['data']['ho'];
      //  $dt = \Carbon::create($ev,$ho, 1, 0)->endOfMonth();

        //-----------------------
        $datum1=$ev.'-'.$ho.'-01';
        $datum2=\Carbon::create($ev,$ho, 1, 0)->endOfMonth();
       // echo  $datum2.'--------';
            //wrtimes-------------------------
            $wrtimes= [];
            $wrtimes= \App\Workertime::where('worker_id','=',$worker_id)
           // ->where('datum','>=',$datum1)
            //->where('datum','<=',$datum2)
            ->where('pub','=',0)
            ->whereBetween('datum', [$datum1,$datum2])
            ->get()->toarray() ?? $wrtimes ; 
         //   print_r($wrtimes);
        foreach($wrtimes as $time) 
        {
            //$this->BASE['data']['calendar'][$time['datum']]['times'][]=$time; 

            $daytT[$time['datum']]['times'][]=$time; 
        }  
return $daytT;
    }


}