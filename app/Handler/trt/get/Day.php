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
               
            // $dayev = substr($day->datum, 4); 
               $day->datum = str_replace("0000", $ev, $day->datum);

     //   echo $day->datum.'---'.$ev.' ';       
 /*   

               $ujdayT=  ['datatype'=>'day','datum'=>$day->datum,'id'=>$day->id,'ch'=>'days','munkanap'=>$day->daytype->munkanap,
               'type'=>$this->BASE['data']['daytype'][$day->daytype_id]];
                $this->BASE['data']['calendar'][$day->datum]=array_merge($this->BASE['data']['calendar'][$day->datum],$ujdayT);
            */    }  

        //------------------------
        $workerdayT= \App\Workerday::with('daytype')->where([
            ['pub', '=', 0],
            ['worker_id', '=', $worker_id],
            ['datum',  'LIKE', $ev."-".$ho."%"],
            ])->get(); 
      // print_r($workerdayT);
            foreach($workerdayT as $day) 
            { 
                $ujdayT= ['datatype'=>'day','datum'=>$day->datum,'id'=>$day->id,'ch'=>'workerdays','munkanap'=>$day->daytype->munkanap,
                'type'=>$this->BASE['data']['daytype'][$day->daytype_id]];
            //    $this->BASE['data']['calendar'][$day->datum]=array_merge($this->BASE['data']['calendar'][$day->datum],$ujdayT);    
            // if($day->workerday){}
             
                $res[$day->datum]=array_merge($this->BASE['data']['calendar'][$day->datum],$ujdayT);
            }   
            //------------------------
     //print_r($res);  
            $workerdaywishT= \App\Workerday::where([
            ['pub', '=', 1],
            ['worker_id', '=', $worker_id],
            ['datum',  'LIKE', $ev."-".$ho."%"],
            ])->get(); 
  
            foreach($workerdaywishT as $day) 
            {  
            $res[$day->datum]=array_merge($this->BASE['data']['calendar'][$day->datum],['wishdaytype'=>$this->BASE['data']['daytype'][$day->daytype_id]]);               
            // $res[$day->datum]['wishdaytype']=$this->BASE['data']['daytype'][$day->daytype_id];
            }    
return $res;
    }

}