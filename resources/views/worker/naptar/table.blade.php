
@include($param['view']['include'].'.style')
    @php

/*  use app\Http\Controllers\Worker\NaptarController;
    {{ NaptarController::proba('param') }}
    {{ App::make("app\Http\Controllers\Worker\NaptarController")->proba2('param') }} */

    $daystyle=[
        'empty'=>'border: 1px solid silver;',
        'base'=>['li'=>'border: 1px solid silver;','div'=>'','span'=>'color:silver'],
        'hollyday'=>['li'=>'border: 1px solid red;','div'=>'','span'=>'color:red'],
        'special'=>['li'=>'border: 1px solid blue;','div'=>'','span'=>'color:blue'],
    ];
    $timestyle=[
        'base'=>['div'=>'border: 1px solid silver;','span'=>'color:blue'],
    ];
  @endphp

    @include($param['view']['include'].'.pdf_print')

     <br><br>        
    @include($param['view']['include'].'.ev_ho')



    <ul class="flex-container nowrap">
        <li class="flex-item "  style="height:40px;color:red;">Vasárnap</li>
        <li class="flex-item "  style="height:40px">Hétfő</li>
        <li class="flex-item "  style="height:40px">Kedd</li>
        <li class="flex-item "  style="height:40px">Szerda</li>
        <li class="flex-item "  style="height:40px">Csütörtök</li>
        <li class="flex-item "  style="height:40px">Péntek</li>
        <li class="flex-item "  style="height:40px; color:red;">Szombat</li>       
    </ul>
<div id="naptar">
        @foreach($data['calendar'] as $dt) 
<!-- sorkezdés---------------------------------------------->
         @if($dt['dayOfWeek']==0 or $dt['day']==1) 
              <ul class="flex-container nowrap" style="justify-content:flex-start"> 
<!-- **sortöltés üres divek---------------------------------------------------------->
                @if ($dt['day']==1 && $dt['dayOfWeek']>0 ) 
                    @for ($i = 0; $i < $dt['dayOfWeek']; $i++)
                       <li class="flex-item" style="{{ $daystyle['empty'] }}"> </li>
                    @endfor
    
                @endif
 <!-- **------------------------------------------------------------------->               
         @endif
 <!-- Napok--------------------------------------------------->        
 @php

  $daytype='base';
  if($dt['dayOfWeek']==6 || $dt['dayOfWeek']==0 ){$daytype='hollyday';}
  
  if($dt['ch']=='workerdays' || $dt['ch']=='days'  ){$daytype='special';}
  $timetype='base';
  @endphp 
  <li class="flex-item" style="{{ $daystyle[$daytype]['li'] }}">
        <div style="{{ $daystyle[$daytype]['div'] }}">{{ $dt['day'] }}., {{ $dt['type'] }}
        </div>
  <!-- idők-------------------------------------->        
 @if(isset($dt['times']))
  @foreach($dt['times'] as $time)  

  <div style="display: flex;width:100%;justify-content:flex-end;{{ $timestyle[$timetype]['div'] }}">        
  <span style="{{ $timestyle[$timetype]['span'] }}">            {{ str_limit($time['start'], 5,'' ).'-'.str_limit($time['end'], 5,'' )  }}    
  </div> 
@endforeach 
 @endif        
            </li>
<!-- sor lezárása ha teljes a hét------------------------->   
        @if($dt['dayOfWeek']==6) 
        </ul > 
        @endif 
        @endforeach

 <!-- üres divek sortöltés és sorlezárás ha nem teljes a hét------------------------------------>
 @if($dt['dayOfWeek']<6) 
 @for ($i = $dt['dayOfWeek']; $i < 6; $i++)
        <li class="flex-item" style="{{ $daystyle['empty'] }}"> </li>
 @endfor
</ul > 
@endif 
             
    </div>                

