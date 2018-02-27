@foreach($years as $year)
<a href=" {!! MoHandF::url($param['routes']['base'],$param['getT'],['ev'=>$year]) !!}" title="worker választás" @if ($data[
    'ev']==$year) class="btn btn-danger btn-xs">
                      @else
                       class="btn btn-warning btn-xs">
                      @endif         
                                {!!    $year !!}
                           
</a>
 @endforeach
<br><br>
 @foreach($months as $key=>$month)
<a href=" {!! MoHandF::url($param['routes']['base'],$param['getT'],['ho'=>$key+1]) !!}" title="worker választás" @if ($data[
    'ho']==$key+1) class="btn btn-danger btn-xs">
                      @else
                       class="btn btn-warning btn-xs">
                      @endif
                                {!!    $month !!}
                            
  </a> @endforeach