
@extends('layouts.backend')
@section('content')
@include('layouts.sidebar') 

<section id="main-content">  
    <section class="wrapper">
        <div class="row">   
            <div class="col-lg-12 main-chart">
                <div class="panel panel-default">
                    <div class="panel-heading">{{  $param['cim']  or ''  }}  </div>
                    <div class="panel-body">
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                            @foreach($param['show'] as $show)
                            <tr>
                                    <th>{{ App::make("app\Http\Controllers\Worker\WorkersController")->label($show) }} </th>
                                    <td>{!! App::make("app\Http\Controllers\Worker\WorkersController")->data($show,$data) !!}</td>
                                </tr>
                            @endforeach
                                </tbody>
                            </table>
                        </div>       

                    </div>
                </div>
            </div>
        </div>
         
    </section>
</section> 
@endsection 
   



