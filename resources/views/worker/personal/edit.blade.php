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
 

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model(null, [
                            'method' => 'PATCH',
                            'url' => ['/worker/updatepasswd'],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('worker.personal.form', ['submitButtonText' => 'frissítés'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </section>
</section>             

@endsection

