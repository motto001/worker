@extends($param['crudview'].'.create')
@section('form')

                        {!! Form::model($data, [
                            'method' => 'POST',
                            'url' => ['/manager/daytypes'],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('manager.daytypes.form', ['submitButtonText' => 'Mentés'])

                        {!! Form::close() !!}
 
@endsection
