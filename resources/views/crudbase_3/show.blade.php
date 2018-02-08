@if(!isset($param['modal']))

@extends('layouts.backend')
@section('content')
@include('admin.sidebar')
@endif           
@php 
 use app\Http\Controllers\Worker\WorkersController;
 /*   {{ NaptarController::proba('param') }}
    {{ App::make("app\Http\Controllers\Worker\NaptarController")->proba2('param') }} */
if(!isset($param['getT'])) {$param['getT']=[];}
//print_r($data); echo '------------------';
@endphp

<section id="main-content">  
    <section class="wrapper">
        <div class="row">   
            <div class="col-lg-12 main-chart">
                <div class="panel panel-default">
                    <div class="panel-heading">{{  $param['cim']  or ''  }}  szerkesztés</div>
                    <div class="panel-body">
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                            @foreach($param['show'] as $show)
                            <tr>
                                    <th>{{ App::make("WorkersController")->label($show) }} </th>
                                    <td>{{ App::make("WorkersController")->label($show,$data) }}</td>
                                </tr>
                            @foreach
                                </tbody>
                            </table>
                        </div>       

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