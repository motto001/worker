@extends($param['crudview'].'.edit')
@section('form')


                        {!! Form::model($data, [
                            'method' => 'PATCH',
                            'url' => ['/manager/daytypes', $data->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('manager.daytypes.form', ['submitButtonText' => 'Mentés'])

                        {!! Form::close() !!}

@endsection
