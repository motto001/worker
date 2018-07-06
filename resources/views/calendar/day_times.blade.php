@php
 $daytype='base';
  $timetype='base';
    $pubview=$param['calendar']['pubview'] ?? 'all';
    $checkbox=$param['calendar']['checkbox'] ?? true;
@endphp 


@php 
    if($dt['baseday']['dayOfWeek']==6 || $dt['baseday']['dayOfWeek']==0 ){$daytype='hollyday';}  
@endphp 
  <li class="flex-item" style="{{ $daystyle[$daytype]['li'] }}">  
    <div style="border: 1px solid grey; "> 
        <div style="{{ $daystyle[$daytype]['div'] }}  ">   
                <!-- checkbox-------------------------------------->      
                @if($checkbox==true)
                @php 
                $checked=false; 
                if( is_array(session('datum')) && in_array($dt['baseday']['datum'], session('datum'))){$checked=true;}
                $munkanap=$dt['baseday']['workday'] ?? false;
                $munkanapClass='';
                if($munkanap){$munkanapClass='workerdayclass';}
                @endphp
            
                {{Form::checkbox('datum[]', $dt['baseday']['datum'],$checked,['class' => 'checkboxjel '.$munkanapClass ])}} 
                @endif  
                <!-- /checkbox--------------------------------------> 
            <span style="color:black;font-size:14px;" >   {{ $dt['baseday']['day'] }}.,</span><span style="color:black;" >  {{ $dt['baseday']['type'] }} </span>      
         </div>
      
        @if($pubview=='all')
        @foreach($dt['days'] as $day) 
            @if($day['pub']==1)
            <div style="color:gray;">       
                    Új: {{ $day['type'] }}       
                </div>
            @endif
            @if($day['pub']==2)
            <div style=" color:red;">       
                    Tilt: {{ $day['type'] }}       
                </div>
            @endif   
        @endforeach
        @endif 
    </div>    
  <!-- idők-------------------------------------->        
    @if(isset($dt['times']))
        @foreach($dt['times'] as $time) 
            @if($time['pub']==0) 
                <div style="display: flex;width:100%;justify-content:flex-end;}}">   
                    <span style="color:blue;" > 
                     OK: {{ str_limit($time['start'], 5,'' ).'-'.str_limit($time['end'], 5,'' )  }}    
                    </span>
                </div>    
            @endif
        @endforeach     
        @if($pubview=='all')
            @foreach($dt['times'] as $time) 
                @if($time['pub']==1) 
                <div style="display: flex;width:100%;justify-content:flex-end;}}">   
                    <span style="color:gray" > 
                    Új: {{ str_limit($time['start'], 5,'' ).'-'.str_limit($time['end'], 5,'' )  }}    
                    </span>
                </div>    
                @endif
            @endforeach    
            @foreach($dt['times'] as $time) 
                @if($time['pub']==2) 
                <div style="display: flex;width:100%;justify-content:flex-end; }}">   
                    <span style="color:red" > 
                    Tilt: {{ str_limit($time['start'], 5,'' ).'-'.str_limit($time['end'], 5,'' )  }}    
                    </span>
                </div>    
                @endif
            @endforeach  
        @endif          
    @endif 
    
    <!-- /idők------------------------------------ -->   
 
   
    </li>    