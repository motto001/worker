@if(!isset($param['modal']))

@extends('layouts.backend')
@section('content')
@include('admin.sidebar')
           
@php 
$cancelurl=$param['routes']['redir'] ?? $param['routes']['base'];
$cancelurl=$data['link_cancel'] ?? $cancelurl;
@endphp
<section id="main-content">  
    <section class="wrapper">
        <div class="row">   
            <div class="col-lg-12 main-chart">
                <div class="panel panel-default">
                    <div class="panel-heading">{{  $param['cim']  or ''  }}  szerkesztés</div>
                    <div class="panel-body">
                        <a href="{{ $cancelurl }}" title="Cancel"><button class="btn btn-warning btn-xs">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Mégsem</button></a>
                        <br />
                        <br />

                     @yield('datas')
                  
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