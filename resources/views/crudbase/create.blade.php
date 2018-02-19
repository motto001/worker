@php
//adatok-----------------
if(!isset($data)) {$data=[];}
$modal=$getT['modal'] ?? false;
$modal=$param['modal'] ?? $modal; 
$list=$data['list'] ?? [];
$getT=$param['getT'] ?? [];
$formbase=$param['view']['include'] ?? $param['view']['base'] ;
$formview=$param['view']['form'] ??  $formbase.'.form'; 
//urlek------------------------
$cancelUrl=$param['routes']['cancel'] ?? MoHandF::url($param['routes']['base'],$getT);
$formurl=$param['routes']['form'] ?? MoHandF::url($param['routes']['base'],$getT);
//gombok,mezők----------------------------------
$cancel_button=$param['cancel_button'] ?? false;
//feliratok----------------------
$cim=$param['cim'] ?? '';
$cancel_label=$param['label']['cancel'] ??  trans('mo.cancel');
@endphp

@if(!$modal)
@extends('layouts.backend')
@section('content')
@include('layouts.sidebar')    
@endif  


<section id="main-content">  
    <section class="wrapper">
        <div class="row">   
            <div class="col-lg-12 main-chart">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$cim }} </div>
                    <div class="panel-body">
@if($modal)
<a href="{{ $canceleUrl }}" title="Cancel"><button class="btn btn-warning btn-sm">
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

                        {!! Form::open(['url' => $formurl, 
                        'class' => 'form-horizontal', 'files' => true]) !!}

                        @include($formview)

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
           </div>
</section>
</section>         
@if(!$modal)        
    </div>
@endsection

@endif