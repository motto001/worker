@extends('layouts.backend')
@include('layouts.sidebar')  
@section('content')
 
<section id="main-content">  
    <section class="wrapper">
        <div class="row">   
            <div class="col-lg-12 main-chart">
                <div class="panel panel-default">
                    <div style="background-color:#203047;color:white"  class="panel-heading"><h4>{{  $param['cim'] or ''  }} Dashboard</h4></div>
                    <div class="panel-body">
            Your application's dashboard.
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
@endsection
