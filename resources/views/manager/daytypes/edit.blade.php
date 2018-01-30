@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Daytype #{{ $daytype->id }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/manager/daytypes') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($daytype, [
                            'method' => 'PATCH',
                            'url' => ['/manager/daytypes', $daytype->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('manager.daytypes.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
