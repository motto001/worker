@if(!isset($param['modal']))
@extends('layouts.backend')

@section('content')
            @include('admin.sidebar')          
@endif 
 @if(isset($param['linkT']['create']))
    @php
    $createlink=$param['linkT']['create'];
    @endphp
 @else 
    @php
     $createlink=MoHandF::url($param['baseroute'].'/create',$param['getT']);
    @endphp
 @endif


<section id="main-content">  
    <section class="wrapper">
        <div class="row">   
            <div class="col-lg-12 main-chart">
                <div class="panel panel-default">
                    <div class="panel-heading">{{  $param['cim'] or ''  }} lista</div>
                    <div class="panel-body">
                 
               
                      
                        <a href="{!! $createlink !!} " class="btn btn-success btn-sm" title="Add New Wroletime">
                            <i class="fa fa-plus" aria-hidden="true"></i> Új {{  $param['cim'] or ''  }}
                        </a>
 @if(isset($param['linkT']['cancel']))
 
    <a href="{{ '/'.$param['linkT']['cancel'] }}" title="Cancel"><button class="btn btn-warning btn-sm">
    <i class="fa fa-arrow-left" aria-hidden="true"></i> Vissza</button></a>

 @endif

                        
                        <br />
                        <br />
     
                        {!! Form::open(['method' => 'GET', 'url' =>  MoHandF::url($param['baseroute'],$param['getT']) , 
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
                      
@include ($param['baseview'].'.table')

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