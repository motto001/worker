@php
//adatok-----------------
if(!isset($data)) {$data=[];}

$list=$data['list'] ?? [];
$getT=$param['getT'] ?? [];
$formopen_in_crudview=$param['$formopen_in_crudview'] ?? true;
$formbase=$param['view']['include'] ?? $param['view']['base'] ;
$formview=$param['view']['form'] ??  $formbase.'.form'; 
//urlek------------------------
$cancelUrl=$param['routes']['cancel'] ?? MoHandF::url($param['routes']['base'],$getT);
$formurl=$param['routes']['form'] ?? MoHandF::url($param['routes']['base'],$getT);
//gombok,mezők----------------------------------
$cancel_button=$param['cancel_button'] ?? true;
//feliratok----------------------
$cim=$param['cim'] ?? '';
$cancel_label=$param['label']['cancel'] ??  trans('mo.cancel');
@endphp

@extends('layouts.backend')
@section('content')
@include('layouts.sidebar')    
 


<section id="main-content">  
    <section class="wrapper">
        <div class="row">   
            <div class="col-lg-12 main-chart">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$cim }} </div>
                    <div class="panel-body">
@if(isset($param['create_info_button_link']))  

<a href="{{ $param['create_info_button_link'] }}" title="Info" style="float:right;" data-toggle="modal" data-target="#myModal">
        <i class="fa fa-info-circle fa-3x"></i>
</a>       
@endif                         
@if($cancel_button)
<a href="{{ $cancelUrl }}" title="Cancel"><button class="btn btn-warning btn-sm">
<i class="fa fa-arrow-left" aria-hidden="true"></i>{{ $cancel_label }}</button></a>
@endif
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        @if ($formopen_in_crudview)
                        {!! Form::open(['url' => $formurl, 
                        'class' => 'form-horizontal', 'files' => true]) !!}
                        @endif
                        @include($formview)
                        @if ($formopen_in_crudview)
                        {!! Form::close() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
         
</section>
</section>         

@endsection
