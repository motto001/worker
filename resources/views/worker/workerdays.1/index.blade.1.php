@extends($param['crudview'].'.index')
@section('table')
@include($param['view'].'.style')
    @php
    $yearnow[]=\Carbon::now()->year-2;
    $yearnow[]=\Carbon::now()->year-1;
    $yearnow[]=\Carbon::now()->year;
    $yearnow[]=\Carbon::now()->year+1;
    $yearnow[]=\Carbon::now()->year+2;
    
    $years=$data['years'] ?? $yearnow;
    
    $months=['Január','Február','Március','Április','Jájus','Június','Július','Augusztus','Szeptember','Október','November','Decenber'];
    
    @endphp
     <br><br>        
        @foreach($years  as $year)
        <a href=" {!! MoHandF::url($param['routes']['base'],$param['getT'],['ev'=>$year]) !!}" 
          title="worker választás"
                              @if ($data['ev']==$year)    
                               class="btn btn-danger btn-xs">
                              @else
                               class="btn btn-warning btn-xs">
                              @endif         
                                        {!!    $year !!}
                                   
                                    </a>
                 @endforeach  
    <br><br>
                 @foreach($months  as $key=>$month)
                                    <a href=" {!! MoHandF::url($param['routes']['base'],$param['getT'],['ho'=>$key+1]) !!}" 
                                    title="worker választás"
                       @if ($data['ho']==$key+1)    
                               class="btn btn-danger btn-xs">
                              @else
                               class="btn btn-warning btn-xs">
                              @endif
                                        {!!    $month !!}
                                    
                                    </a>
                 @endforeach 
  
    <ul class="flex-container nowrap">
        <li class="flex-item "  style="height:40px;color:red;">Vasárnap</li>
        <li class="flex-item "  style="height:40px">Hétfő</li>
        <li class="flex-item "  style="height:40px">Kedd</li>
        <li class="flex-item "  style="height:40px">Szerda</li>
        <li class="flex-item "  style="height:40px">Csütörtök</li>
        <li class="flex-item "  style="height:40px">Péntek</li>
        <li class="flex-item "  style="height:40px; color:red;">Szombat</li>       
    </ul>
@php
$create=true;
@endphp
@if($create)
    @include('worker.workerdays.form')   
@else
    @include('worker.workerdays.form') 
@endif
        @foreach($data['calendar'] as $dt) 
         @if($dt['dayOfWeek']==0 or $dt['day']==1) 
              <ul class="flex-container nowrap" style="justify-content:flex-start"> 
                @if ($dt['day']==1 && $dt['dayOfWeek']>0 ) 
                    @for ($i = 0; $i < $dt['dayOfWeek']; $i++)
                       <li class="flex-item" style="border: 1px solid silver;"> </li>
                    @endfor
    
                @endif
         @endif
           @php
            $color = 'grey';
            $wishcolor =  'wishbase';
            if($dt['dayOfWeek']==0 || $dt['dayOfWeek']==6 ){ $color =  'red';}
            
            $daytype_id = $dt['daytype_id'] ?? 1; 
            if($dt['daytype_id']<1){$daytype_id = 1;}

            $wish_id=$dt['wish_id'] ?? $daytype_id ;
            
            if( $dt['datatype']!='base'){if($dt['daytype_id']>0 ){$color =  'green';}}
          
            if( $daytype_id!=$wish_id){$wishcolor = 'wishcolor';}
                
            @endphp
  

           <li class="flex-item" style="border: 1px solid silver;">
            <div style="color:{{ $color }}">{{ $dt['day'] }}., {{ $data['daytype'][$daytype_id] }}</div>
            @if($dt['wrole_id']!=0) 
            <div style="display: flex;width:100%;justify-content:flex-end;border: 1px solid silver; ">            
                    <span>     wrole_id:     {{ $dt['wrole_id']  }}</span>  
            </div> 
            @endif 
            @if($dt['wrunit_id']!=0) 
            <div style="display: flex;width:100%;justify-content:flex-end;border: 1px solid silver; ">            
                      <span>    wrunit_id:     {{ $dt['wrunit_id']  }}</span> <br> 
            </div> 
            @endif      
                @foreach($dt['wrtimes'] as $time)  
               <div style="display: flex;width:100%;justify-content:flex-end;border: 1px solid silver; ">        
               <span style="color:blue">            {{  $time['start'].'-'.$time['end']   }}    
               </div> 
                @endforeach               
            </li>
     
        @if($dt['dayOfWeek']==6) 
        </ul > 
        @endif 
        @endforeach
        @if($dt['dayOfWeek']<6) 
                @for ($i = $dt['dayOfWeek']; $i < 6; $i++)
                       <li class="flex-item" style="border: 1px solid silver;"> </li>
                @endfor
        </ul > 
        @endif 
             
                

@endsection
