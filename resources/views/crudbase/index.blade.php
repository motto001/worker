@php
//adatok-----------------
if(!isset($data)) {$data=[];}

$getT=$param['getT'] ?? [];
//$modal=$getT['modal'] ?? false;
//$modal=$param['modal'] ?? $modal;

$list=$data['list'] ?? [];
$tableview=$param['view']['table'] ??  $param['view']['include'].'.table'; 
//urlek------------------------
$createUrl=$param['routes']['create'] ?? MoHandF::url($param['routes']['base'].'/create',$getT);
$cancelUrl=$param['routes']['cancel'] ?? MoHandF::url($param['routes']['base'],$getT);
$formurl=$param['routes']['form'] ?? MoHandF::url($param['routes']['base'],$getT);
//gombok,mezők----------------------------------
$search= $param['search'] ?? true;
$create_button=$param['create_button'] ?? true;
$cancel_button=$param['cancel_button'] ?? false;
//feliratok----------------------
$cim=$param['cim'] ?? '';
$cancel_label=$param['label']['cancel'] ??  trans('mo.cancel');
$addbutton_label=$param['addbutton_label'] ?? trans('mo.new').' '.$cim;

@endphp  
@extends('layouts.backend')
@section('content')

@include('layouts.sidebar')               

<section id="main-content">  
    <section class="wrapper">
        <div class="row">   
            <div class="col-lg-12 main-chart">
                <div class="panel panel-default">

                    <div class="panel-heading">{{  $cim  }} lista</div>
                    <div class="panel-body">
@if($search)                
                  <div class="pagination-wrapper"> {!! $list->appends(['search' => Request::get('search')])->render() !!} </div>  
@endif   
@if($create_button)
                       
    <a href="{{ $createUrl }} " class="btn btn-success btn-sm" title="Add New Wroletime">
        <i class="fa fa-plus" aria-hidden="true"></i> {{ $addbutton_label }}
    </a>
 @endif                       
 @if($cancel_button)
 
    <a href="{{ $canceleUrl }}" title="Cancel"><button class="btn btn-warning btn-sm">
    <i class="fa fa-arrow-left" aria-hidden="true"></i>{{ $cancel_label }}</button></a>

@endif   

                        
                        <br />
                        <br />
     
                        {!! Form::open(['method' => 'GET', 'url' => $formurl, 
                        'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>

                        {!! Form::close() !!}
@include ($tableview)
                        <br/>
                        <br/>
 
                    </div>
                </div>
            </div>
        </div>
        
</section>
</section>      
     
@endsection

