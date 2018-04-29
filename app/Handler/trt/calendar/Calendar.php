<?php
namespace App\Handler\trt\calendar;
//use App\Http\Requests;
//use App\Workeruser;
//use App\Facades\MoView;
use Session;
use Carbon\Carbon;
use App\facades\MoCal;

trait Calendar 
{


    public function getMonths()
    { 
      return  MoCal::getMonths();
    }
    public function twoChar($num)
    {
 
      return  MoCal::twoChar($num);
    }
    public function datumTwoChar($datum,$sep='-')
    {

      return   MoCal::datumTwoChar($datum,$sep);
    }


    public function getDate($year='0',$month='0')
    {
        return MoCal::getDate($year,$month);
    }
 
public function getMonthDays($year='0',$month='0')
{
    return MoCal::getDate($year,$month);    
}
/*
    public function getDays($year='0',$month='0',$dayT=[],$timeT=[])
    {
        $date=$this->getDate($year,$month);
        if($date->dayOfWeek>0){
           $days=$this->getFirstEmptyDays($date->dayOfWeek-1); 
        }
        else{$days=[];}
        $aktMonth=$date->month;

        while ($aktMonth == $date->month) { 
            //$datum=$year.'-'.$month.'-'.$date->day;
            $datum= \MoCalF::datumTwoChar($year.'-'.$month.'-'.$date->day);
            $ujdays= [
                'name'=>$this->days[$date->dayOfWeek],
                'day'=>$date->day,
                'weeknum'=>$date->dayOfWeek,
                'date'=>$datum,
                'type'=>'Munkanap',
            ]; 
            if( $date->dayOfWeek==0){$ujdays['color']='red';$ujdays['type']='Szabadnap';}
            if($date->dayOfWeek==6 ){$ujdays['color']='red';$ujdays['type']='Pihenőnap';}
          foreach($dayT as $d){

            if($d['datum']==$datum){
                $ujdays['type']=$d['type'] ?? '';
                $ujdays['color']=$d['color'] ?? '';
               // $ujdays['bgcolor']=$dayT[$datum]['bgcolor'] ?? '';
              //  $ujdays['bordercolor']=$dayT[$datum]['bordercolor'] ?? '';
            }}
            if(in_array($datum,$timeT)){$ujdays['times']=$timeT[$datum];}
            $days[]= $ujdays;
            $date->addDay();
        }  
        if($date->dayOfWeek<6){
            $days=$this->getLastEmptyDays($date->dayOfWeek,$days);
         }
        
        return $days;
    }
 */
}