<?php

namespace App\Handler\trt\get;
//use Illuminate\Support\Facades\Input;
use App\facades\MoCal; 

Trait Day
{
    public function getMonthDays()
    {
      //  $calendar=new \App\Handler\Calendar;
       // $this->BASE['data']['calendar']=$calendar->getMonthDays($this->BASE['data']['ev'],$this->BASE['data']['ho']); 
        $this->BASE['data']['calendar']=MoCal::getMonthDays($this->BASE['data']['ev'],$this->BASE['data']['ho']); 
   
   
    }
    public function getDay()
    { 
        $ev=$this->BASE['data']['ev'];
        $ho=$this->BASE['data']['ho'];
        //-----------------------
        $dayT= \App\Day::with('daytype')->where('datum',  'LIKE', $ev."-".$ho."%")
        ->orwhere('datum',  'LIKE', "0000-".$ho."%")
        ->get()->toarray();
        foreach($dayT as $day) 
        {
            $day['datum']= str_replace("0000", $ev, $day['datum']); 
            //blade hez egyszerúsítés
            $day['munkanap']=$day['daytype']['workday'];
            $day['type']=$this->BASE['data']['daytype'][$day['daytype_id']];
            //----------------
            $this->BASE['data']['calendar'][$day['datum']]['baseday']=array_merge($this->BASE['data']['calendar'][$day['datum']]['baseday'],$day);
            
        }


    }
public function getWorkerday($worker_id=0)
    {  
        $res=[];
        if($worker_id==0){ $worker_id=$this->BASE['data']['worker_id'] ?? 0;}
       
        $ev=$this->BASE['data']['ev'];
        $ho=$this->BASE['data']['ho'];
      
        //------------------------
        $workerdayT= \App\Workerday::with('daytype')->where([
          //  ['pub', '=', 0],
            ['worker_id', '=', $worker_id],
            ['datum',  'LIKE', $ev."-".$ho."%"],
            ])->get()->toarray(); 
      
            foreach($workerdayT as $day) 
            { 
                //blade hez egyszerúsítés
                    $day['munkanap']=$day['daytype']['workday'];
                    $day['type']=$this->BASE['data']['daytype'][$day['daytype_id']];
                // ---------   
                if($day['pub']=='0'){
                $this->BASE['data']['calendar'][$day['datum']]['baseday']=array_merge($this->BASE['data']['calendar'][$day['datum']]['baseday'],$day);
                 }
                 else{$this->BASE['data']['calendar'][$day['datum']]['days'][]=$day;}
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
        ])->get()->toarray();

            foreach($dayT as $day) 
            {   
                //blade hez egyszerúsítés  
                  $day['munkanap']=$day['daytype']['workday'];
                $day['type']=$this->BASE['data']['daytype'][$day['daytype_id']];           
               //--------------------
                $this->BASE['data']['calendar'][$day['datum']]['baseday']=array_merge($this->BASE['data']['calendar'][$day['datum']]['baseday'],$day);
             }  

    }
}