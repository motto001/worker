//cancel-----------
<a href="{!!  MoHandF::url($param['routes']['base'],$param['getT']) !!}" 
title="Cancel"><button class="btn btn-warning btn-xs">  <i class="fa fa-arrow-left" aria-hidden="true"></i> 
    @lang('mo.cancel')</button></a>
//vagy
    <a href="/{{ $cancelurl }}" title="@lang('mo.cancel')"><button class="btn btn-warning btn-xs">
    <i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('mo.cancel')</button></a>
           
//create------------
<a href="{!!  MoHandF::url($param['routes']['base'].'/create',$param['getT']) !!}" 
class="btn btn-success btn-sm" title="Add New ">
    <i class="fa fa-plus" aria-hidden="true"></i>  Új 
</a>
//show------------
<a href="{{ url('/'.$param['routes']['base'].'/' . $item->id. $param['route_param']) }}" 
    title="View "><button class="btn btn-info btn-xs">
    <i class="fa fa-eye" aria-hidden="true"></i> </button></a>
//edit------------------
<a href="{!!  MoHandF::url($param['routes']['base'].'/'.$item->id.'/edit',$param['getT']) !!} "
class="btn btn-primary btn-xs" title="edit">
    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 
</a> 
//delete-------------
{!!
MoHandF::delButton([
'tip'=>'del',
'link'=>MoHandF::url($param['routes']['base'].'/'.$item->id,$param['getT']),
'fa'=>'trash-o']) 
!!}
// állapot jelző-------------
@if($item->pub==1)
<span class="btn btn-primary btn-xs"> uj</span>
@elseif($item->pub==0)
<span class="btn btn-success btn-xs" title="">
   <i class="fa fa-check-square-o" aria-hidden="true"></i>
</span>
@elseif($item->pub==2)
<span class="btn btn-danger btn-xs" title="">
   <i class="fa fa-times" aria-hidden="true"></i> 
</span>
@endif
//pub-unpub---------------
@if($item->pub==0 )
                                
<a href="{!!  MoHandF::url($param['routes']['base'],$param['getT'],['task'=>'unpub','id'=>$item->id]) !!} "
 class="btn btn-success btn-xs" title="unPub">
    <i class="fa fa-check-square-o" aria-hidden="true"></i>
</a>
@else
<a href="{!!  MoHandF::url($param['routes']['base'],$param['getT'],['task'=>'pub','id'=>$item->id]) !!} "
class="btn btn-danger btn-xs" title="pub">
    <i class="fa fa-times" aria-hidden="true"></i> 
</a>
@endif

//manager  3 állású pub