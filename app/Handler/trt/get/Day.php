<?php

namespace App\Handler\trt\get;
//use Illuminate\Support\Facades\Input;
Trait Day
{

    public function getWorkerday()
    {
        $res=[];
        $worker_id=$this->BASE['data']['worker_id'];
        $ev=$this->BASE['data']['ev'];
        $ho=$this->BASE['data']['ho'];
        //-----------------------
        $dayT= \App\Day::where('datum',  'LIKE', $ev."-".$ho."%")
            ->orwhere('datum',  'LIKE', "0000-".$ho."%")
            ->get();
            foreach($dayT as $day) 
            {
               // $dayev = substr($day->datum, 4); 
               $day->datum = str_replace("0000", $ev, $day->datum);
               $ujdayT=  ['datatype'=>'day','datum'=>$day->datum,'id'=>$day->id,'ch'=>'days',
               'type'=>$this->BASE['data']['daytype'][$day->daytype_id]];
                $this->BASE['data']['calendar'][$day->datum]=array_merge($this->BASE['data']['calendar'][$day->datum],$ujdayT);
            }  

        //------------------------
        $workerdayT= \App\Workerday::where([
            ['pub', '=', 0],
            ['worker_id', '=', $worker_id],
            ['datum',  'LIKE', $ev."-".$ho."%"],
            ])->get(); 
      // print_r($workerdayT);
            foreach($workerdayT as $day) 
            { 
                $ujdayT= ['datatype'=>'day','datum'=>$day->datum,'id'=>$day->id,'ch'=>'workerdays',
                'type'=>$this->BASE['data']['daytype'][$day->daytype_id]];
                $this->BASE['data']['calendar'][$day->datum]=array_merge($this->BASE['data']['calendar'][$day->datum],$ujdayT);    
               $res[$day->datum]=array_merge($this->BASE['data']['calendar'][$day->datum],$ujdayT);
            }   
           
return $res;
    }

}