@extends($param['crudview'].'.create')
@section('form')


                        {!! Form::open(['url' => '/admin/conf', 'class' => 'form-horizontal', 'files' => true]) !!}

                        @include ('admin.conf.form')

                        {!! Form::close() !!}

 
@endsection
