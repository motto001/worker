<?php
namespace App\Handler;
//use App\Http\Requests;
//use App\Workeruser;
//use App\Facades\MoView;
use Session;
use Carbon\Carbon;

class MoCal
{
    public $days=['vasárnap','hétfő','kedd','szerda','csütörtök','péntek','szombat'];
    public $day_propertyT= [
        'datatype'=>'base',
        'name'=>'',
        'day'=>0,
        'dayOfWeek'=>0,
        'datum'=>'0000-00-00',
        'daytype_id'=>1,
        'type'=>'Munkanap',
        'workday'=>true,
    ];

    public function getMonths()
    { 
      return  [       
            1=>['name'=>'január','id'=>'1'],
            2=>['name'=>'február','id'=>'2'],
            3=>['name'=>'Március','id'=>'3'],
            4=>['name'=>'Április','id'=>'4'],
            5=>['name'=>'Május','id'=>'5'],
            6=>['name'=>'Június','id'=>'6'],
            7=>['name'=>'Július','id'=>'7'],
            8=>['name'=>'Augusztus','id'=>'8'],
            9=>['name'=>'Szeptember','id'=>'9'],
            10=>['name'=>'Október','id'=>'10'],
            11=>['name'=>'November','id'=>'11'],
            12=>['name'=>'December','id'=>'12']       
        ];    
    }
    public function twoChar($num)
    {
        if(strlen($num)<2){
            $num='0'.$num;
        }
      return  $num; 
    }
    public function datumTwoChar($datum,$sep='-')
    {
    $datumT= explode($sep,$datum);
    $datumT[1]=$this->twoChar($datumT[1]);
    $datumT[2]=$this->twoChar($datumT[2]);
      return  implode($sep,$datumT); 
    }


    public function getDate($year='0',$month='0')
    {
        $current = new Carbon();
        if($year=='0' && $month=='0'){$dt = Carbon::create($current->year,$current->month, 1, 0);}
        elseif($year=='0'){           $dt = Carbon::create($current->year, $month , 1, 0); }
        elseif($month=='0') {        $dt = Carbon::create($year, $current->month , 1, 0);}    
        else{                         $dt = Carbon::create($year, $month , 1, 0);}
        return $dt;
    }

   
public function getMonthDays($year='0',$month='0')
{
    $date=$this->getDate($year,$month);
    $aktMonth=$date->month;
    
            while ($aktMonth == $date->month) { 
                //$datum=$year.'-'.$month.'-'.$date->day;
                $datum= \MoCalF::datumTwoChar($year.'-'.$month.'-'.$date->day);
                $ujdaysB= [
                    'name'=>$this->days[$date->dayOfWeek],
                    'day'=>$date->day,
                    'dayOfWeek'=>$date->dayOfWeek,
                    'datum'=>$datum,
                ]; 
                $ujdays=array_merge($this->day_propertyT, $ujdaysB);
                if( $date->dayOfWeek==0){$ujdays['daytype_id']=2;$ujdays['type']='Szabadnap';$ujdays['workday']=false;}
               if($date->dayOfWeek==6 ){$ujdays['daytype_id']=3;$ujdays['type']='Pihenőnap';$ujdays['workday']=false;}
                $days[$datum]['baseday']= $ujdays;
                $days[$datum]['days']= [];
                $date->addDay();
            }  
     return $days;       
}

 
}