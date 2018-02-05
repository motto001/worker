@extends($param['crudview'].'.edit')
@section('form')
                    <div class="panel-heading">Edit Conf #{{ $data->id }}</div>
                    <div class="panel-body">
                        <a href="{{ url($param['routes']['base']) }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($data, [
                            'method' => 'PATCH',
                            'url' => [$param['routes']['base'], $data->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('admin.conf.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
   
@endsection
