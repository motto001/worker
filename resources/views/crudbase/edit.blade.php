@php
if(!isset($data)) {$data=[];}
$getT=$param['getT'] ?? [];

$list=$data['list'] ?? $data;
$id=$list->id ?? '';
$formview=$param['view']['form'] ??  $param['view']['include'].'.form'; 
$formview=$param['view']['editform'] ??  $formview; 
//urlek------------------------
$cancelUrl=$param['routes']['cancel'] ?? MoHandF::url($param['routes']['base'],$getT);
$formurl=$param['routes']['editform'] ?? MoHandF::url($param['routes']['base'].'/'.$id,$getT);
//gombok,mezők----------------------------------
$cancel_button=$param['cancel_button'] ?? true;
//feliratok----------------------
$cim=$param['cim'] ?? 'Szekesztés';
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
                        <div class="panel-heading">{{  $cim  }} </div>          
                    <div class="panel-body">
@if($cancel_button)
<a href="{{ $cancelUrl }}" title="Cancel"><button class="btn btn-warning btn-sm">
<i class="fa fa-arrow-left" aria-hidden="true"></i>{{ $cancel_label }}</button></a>
@endif                    <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($data, [
                            'method' => 'PATCH',
                            'url' =>[$formurl] ,
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include($formview, ['submitButtonText' =>trans('mo.save')])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
        
</section>
</section>        
@endsection

