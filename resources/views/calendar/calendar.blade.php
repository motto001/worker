

@php
// TODO config file elkészítése
/*  use app\Http\Controllers\Worker\NaptarController;
    {{ NaptarController::proba('param') }}
    {{ App::make("app\Http\Controllers\Worker\NaptarController")->proba2('param') }} */

 $calendarbase=$param['calendar']['view']['base']  ?? 'calendar';

 $pdf_print_view=$param['calendar']['view']['pdf_print'] ??  $calendarbase;
 $pdf_print=$param['calendar']['pdf_print']  ?? true;

 $ev_ho_view=$param['calendar']['view']['ev_ho_view'] ??  $calendarbase;
 $ev_ho=$param['calendar']['ev_ho']  ?? true;
 $style_view=$param['calendar']['view']['style'] ??  $calendarbase;
 $days_view=$param['calendar']['view']['days'] ??  $calendarbase;

$daystyle=$param['calendar']['daystyle'] ?? [
        'empty'=>'border: 1px solid silver;',
        'base'=>['li'=>'border: 1px solid silver;','div'=>'','span'=>'color:silver'],
        'hollyday'=>['li'=>'border: 1px solid red;','div'=>'','span'=>'color:red'],
        'special'=>['li'=>'border: 1px solid blue;','div'=>'','span'=>'color:blue'],
    ];
$timestyle=$param['calendar']['timestyle'] ??[
        'base'=>['div'=>'border: 1px solid silver;','span'=>'color:blue'],
    ];
@endphp

@include($style_view.'.style')

@if( isset($param['calendar']['style_plus']))
    @include($param['calendar']['style_plus'].'.style_plus')
@endif  
@if( $pdf_print)
    @include($calendarview.'.pdf_print')
@endif    

     <br><br> 
@if( $ev_ho)            
@include($calendarview.'.ev_ho')
@endif 


    <ul class="flex-container nowrap">
       
        <li class="flex-item "  style="height:40px">Hétfő</li>
        <li class="flex-item "  style="height:40px">Kedd</li>
        <li class="flex-item "  style="height:40px">Szerda</li>
        <li class="flex-item "  style="height:40px">Csütörtök</li>
        <li class="flex-item "  style="height:40px">Péntek</li>
        <li class="flex-item "  style="height:40px; color:red;">Szombat</li>  
        <li class="flex-item "  style="height:40px;color:red;">Vasárnap</li>    
    </ul>
<div id="naptar">
@foreach($data['calendar'] as $dt) 
<!-- sorkezdés---------------------------------------------->
    @if($dt['dayOfWeek']==1 or $dt['day']==1) 
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
@include($days_view.'.days')
<!-- sor lezárása ha teljes a hét------------------------->   
        @if($dt['dayOfWeek']==0) 
        </ul > 
        @endif 
@endforeach

 <!-- üres divek sortöltés és sorlezárás ha nem teljes a hét------------------------------------>
@if($dt['dayOfWeek']>0) 
    @for ($i = $dt['dayOfWeek']; $i < 7; $i++)
            <li class="flex-item" style="{{ $daystyle['empty'] }}"> </li>
    @endfor
</ul > 
@endif 
             
    </div>                

