<?php
namespace App\Handler\trt\calendar;
use Session;
use App\Workertime;
use App\Wrole;
use App\Wroletime;
use App\Worker;
use App\Workerday;

trait Savecal 
{

    public function set_savecal($id)
    {  
        $savecal=Savecal::with(['savecalday','savecaltime'])->find($id)->toarray();
        $monthdays =\MoCalF::getMonthDays($this->BASE['data']['ev'],$this->BASE['data']['ho']);     
       
        $this->BASE['data']['savecal']['id']=$savecal['id'];
        $this->BASE['data']['savecal']['worker_id']=$savecal['worker_id'];
        $this->BASE['data']['savecal']['ev']=$savecal['ev'];
        $this->BASE['data']['savecal']['ho']=$savecal['ho'];
        $this->BASE['data']['savecal']['name']=$savecal['name'];
        $this->BASE['data']['savecal']['note']=$savecal['note'];
        $this->BASE['data']['savecal']['created_at']=$savecal['created_at'];
        $this->BASE['data']['savecal']['updated_at']=$savecal['updated_at'];

       foreach ( $savecal['savecalday'] as $day) {
        $this->BASE['data']['calendar'][$day['datum']]['days'][]=array_merge($monthdays[$day['datum']],$day);    
       }
       foreach ( $savecal['savecaltime'] as $time) {
        $this->BASE['data']['calendar'][$time['datum']]['times'][]=$time;    
       }
     
    }
    public function store_savecal()
    {  
        $request=$this->BASE['request'];
        $savecal_data=[
            'worker_id'=>$this->BASE['data']['worker_id'],
            'ev'=>$this->BASE['data']['ev'],
            'ho'=>$this->BASE['data']['ho'],
            'name'=>$request->name,
            'note'=>$request->note,

        ];
        $savecal= \App\Savecal::create($savecal_data);
       
        foreach ($this->BASE['data']['calendar']  as $datum =>$calendar) {
            $calendar['savecal_id'] =$savecal->id; 
            $savecalday=\App\SavecalDay::create($calendar); 
         
            if(isset($calendar['times']) && is_array($calendar['times'])){
                foreach ($calendar['times'] as  $time) {
                    $time['savecal_id'] = $savecal->id; 
                    \App\SavecalDayTime::create($time);
                }
            }  
        }
    }
    public function update_savecal($savecal)
    {  
        $request=$this->BASE['request'];
        $savecal_data=[];
        if($request->name !=null){$savecal_data['name']=$request->name;}
        if($request->note !=null){$savecal_data['note']=$request->note;}
        if(!empty($savecal_data)){$savecal->update($savecal_data);}
       
        \App\SavecalDay::where('savecal_id', '=',  $savecal->id )->delete();
        foreach ($this->BASE['data']['calendar']  as $datum =>$calendar) { 
            $calendar['savecal_id'] =$savecal->id; 
            $savecalday=\App\SavecalDay::create($calendar); 

            \App\SavecalDayTime::where('savecal_id', '=', $savecal->id )->delete();

            if(isset($calendar['times']) && is_array($calendar['times'])){
                foreach ($calendar['times'] as  $time) {
                    $time['savecal_id'] = $savecal->id; 

                    \App\SavecalDayTime::create($time);
                }
            }
        }
    }
    public function update_store_savecal()
    {  
        $savecal= \App\Savecal::where(['worker_id'=>$this->BASE['data']['worker_id'],'ev'=>$this->BASE['data']['ev'],'ho'=>$this->BASE['data']['ho']])->first();
        // var_dump($savecal);
        if(isset($savecal->id))
        {
            $this->update_savecal($savecal);
        }else{
            $this->store_savecal();
        }
    }
}