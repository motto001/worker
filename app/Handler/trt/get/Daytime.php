<?php

namespace App\Handler\trt\get;
//use Illuminate\Support\Facades\Input;
use App\facades\MoCal; 

Trait Daytime
{
use \App\Handler\trt\get\Day;
use \App\Handler\trt\get\Time;
public function set()
{
    $this->BASE['data']['daytype']=\App\Daytype::get()->pluck('name','id');//App\Handler\trt\get\Day; függvényeinek kell
    $this->BASE['data']['timetype']=\App\Timetype::get()->pluck('name','id');
    $this->BASE['data']['daytype']['0']='nincs változtatás';
}
public function getWorkerCal($worker_id)
{
    $this->set();
    $worker=\App\Worker::with('user')->find($worker_id);
    $group_id=$worker->group_id ?? 0;

    $this->getMonthDays();

    $this->getDay();

    $this->getMonthDays($worker_id); 
    if( $group_id>0){$this->getGroupday($group_id);}  
    $this->getWorkerday($worker_id);

    if( $group_id>0){$this->getGrouptime($group_id);}  
    $this->getWorkertime($worker_id);
}
public function getWorkerCal_or_savecal($worker_id)
{
    $ev=$this->BASE['data']['ev'];
    $ho=$this->BASE['data']['ho'];

    $cal=\App\Savecal::with(['savecalday','savecalday.savecaldaytime'])->where([
        //  ['pub', '=', 0],
          ['worker_id', '=', $worker_id],
          ['ev',  '=', $ev],
          ['ho',  '=', $ho],
          ['pub',  '=', 0],
          ])->orderBy('id', 'desc')->orderBy('lezart', 'desc')->first(); 
    if(isset($cal->id)){
        $this->BASE['data']['savecal']['id']=$cal->id;
        $this->BASE['data']['savecal']['savecalname']=$cal->name ;
        $cal=$cal->toarray();
        $this->BASE['data']['calendar']  =\MoHand::setIndexFromKey($cal['savecalday'],'datum') ;
    }else{
        $this->BASE['data']['savecal']['id']='0';
        $this->BASE['data']['savecal']['savecalname']='Ehhez az időszakhoz még nem készült jóváhagyott Munkarend.';
        $this->getWorkerCal($worker_id);
    }
}
}