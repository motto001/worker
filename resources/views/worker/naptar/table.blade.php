@php
$savecalid=$data['savecal']['id'] ?? 0;
$savecalname=$data['savecal']['savecalname'] ?? '';
@endphp

@if($savecalid>0)
{{ $savecalname}}
@else
{{ $savecalname }}
@endif
@include('calendar.ev_ho')           
@include('calendar.calendar')
