@extends($param['crudview'].'.create')
@section('form')

 {!! Form::hidden('worker_id', $data['worker_id']) !!}

 <div class="form-group {{ $errors->has('wish_id') ? 'has-error' : ''}}">
    {!! Form::label('wish_id', 'Munkarend', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-7">
             {!! Form::select('wish_id',$data['wrunit'],
             null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('wish_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('datum') ? 'has-error' : ''}}">
    {!! Form::label('datum', 'Dátum', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('datum', null, ['class' => 'form-control datepicker']) !!}
        {!! $errors->first('datum', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('note') ? 'has-error' : ''}}">
    {!! Form::label('note', 'Jegyzet', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('note', null, ['class' => 'form-control ']) !!}
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
</div>

     

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>

@endsection
