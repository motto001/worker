
@if(!isset($param['modal']))
@extends('layouts.backend')

@section('content')
@include('layouts.sidebar')          
@endif 

@php
if(!isset($data)) {$data=[];}
if(!isset($data['list'])) {$data['list']=$data;}
if(!isset($param['getT'])) {$param['getT']=[];}
$createlink=$param['routes']['create'] ?? MoHandF::url($param['routes']['base'].'/create',$param['getT']);
$cim=$param['cim'] ?? '';
$addbutton_label=$param['addbutton_label'] ?? 'Új '.$cim;
if(!isset($param['search'])){$param['search']=true;}
$create_button=$param['create_button'] ?? true;

@endphp



<section id="main-content">  
    <section class="wrapper">
        <div class="row">   
            <div class="col-lg-12 main-chart">
                <div class="panel panel-default">
                    <div class="panel-heading">{{  $param['cim'] or ''  }} lista</div>
                    <div class="panel-body">

                 
                @if($create_button)
                      
                        <a href="{!! $createlink !!} " class="btn btn-success btn-sm" title="Add New Wroletime">
                            <i class="fa fa-plus" aria-hidden="true"></i>  {{  $addbutton_label  }}
                        </a>
                @endif     
                        <br />
                        
      @if($param['search'])
                        {!! Form::open(['method' => 'GET', 'url' =>  MoHandF::url($param['routes']['base'],$param['getT']) , 
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
         @endif            
@yield('table')

     <div class="pagination-wrapper"> {!! $data['list']->appends(['search' => Request::get('search')])->render() !!} </div>  
                        <br/>
                        <br/>
 
                    </div>
                </div>
            </div>
        </div>
           </div>
</section>
</section>      
@if(!isset($param['modal']))        
    </div>
@endsection

@endif