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
      
       // echo $ev.'--------';

        $ho=$this->BASE['data']['ho'];
        //-----------------------
        $dayT= \App\Day::with('daytype')->where('datum',  'LIKE', $ev."-".$ho."%")
            ->orwhere('datum',  'LIKE', "0000-".$ho."%")
            ->get();
            foreach($dayT as $day) 
            {
               $day->datum = str_replace("0000", $ev, $day->datum);


               $ujdayT=  ['datatype'=>'day','datum'=>$day->datum,'id'=>$day->id,'ch'=>'days','munkanap'=>$day['daytype']['workday'],
               'type'=>$this->BASE['data']['daytype'][$day->daytype_id],'pub'=>0];
                $this->BASE['data']['calendar'][$day->datum]=array_merge($this->BASE['data']['calendar'][$day->datum],$ujdayT);
              }  

        //------------------------
        $workerdayT= \App\Workerday::with('daytype')->where([
          //  ['pub', '=', 0],
            ['worker_id', '=', $worker_id],
            ['datum',  'LIKE', $ev."-".$ho."%"],
            ])->get(); 
      
            foreach($workerdayT as $day) 
            { 
                $ujdayT= ['datatype'=>'day','datum'=>$day->datum,'id'=>$day->id,'munkanap'=>$day['daytype']['workday'],
                'type'=>$this->BASE['data']['daytype'][$day->daytype_id],'pub'=>$day->pub];
                if($day->pub=='0'){
                $this->BASE['data']['calendar'][$day->datum]=array_merge($this->BASE['data']['calendar'][$day->datum],$ujdayT);
                 }
                 else{$this->BASE['data']['calendar'][$day->datum]['wish']=$ujdayT;}
            }   
//print_r( $this->BASE['data']['calendar']); exit();
    }

    /**
     * nincs vissaztérési érték , BASE['data']['calendar']-ba hír
     */
    public function getGroupday($group_id)
    {
    
      //  $gruop_id=$this->BASE['data']['worker_id'];
        $ev=$this->BASE['data']['ev'];
        $ho=$this->BASE['data']['ho'];
        //-----------------------
        $dayT= \App\Groupday::with('daytype')->where([
        ['group_id', '=', $group_id ],
        ['datum',  'LIKE', $ev."-".$ho."%"],
        ])->get();

            foreach($dayT as $day) 
            {
               
               $ujdayT=  ['datatype'=>'day','datum'=>$day->datum,'id'=>$day->id,'ch'=>'days','munkanap'=>$day->daytype->munkanap,
               'type'=>$this->BASE['data']['daytype'][$day->daytype_id]];
                $this->BASE['data']['calendar'][$day->datum]=array_merge($this->BASE['data']['calendar'][$day->datum],$ujdayT);
            }  

    }
}