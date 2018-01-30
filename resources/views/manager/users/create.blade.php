@extends('layouts.backend')
@section('content')
@include('admin.sidebar')
<section id="main-content">
   <section class="wrapper">
        <div class="row">   
            <div class="col-lg-12 main-chart">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New User</div>
                    <div class="panel-body">
                        <a href="{{ url('/manager/users') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(['url' => '/manager/users', 'class' => 'form-horizontal']) !!}

                        @include ('manager.users.form')

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </section>
</section>  
@endsection
