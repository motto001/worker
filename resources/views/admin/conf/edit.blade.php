@extends('layouts.backend')
@section('content')
@include('admin.sidebar')
<section id="main-content">
   <section class="wrapper">
        <div class="row">   
            <div class="col-lg-12 main-chart">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Conf #{{ $conf->id }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/admin/conf') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($conf, [
                            'method' => 'PATCH',
                            'url' => ['/admin/conf', $conf->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('admin.conf.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
         </div>
    </section>
</section>   
@endsection
