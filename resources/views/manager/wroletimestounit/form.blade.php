
@if($data['wroleunit_id']<1)
<div class="form-group {{ $errors->has('wroleunit_id') ? 'has-error' : ''}}">
    {!! Form::label('wroleunit_id', 'Wroleunit Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('wroleunit_id', null, ['class' => 'form-control']) !!}
        {!! $errors->first('wroleunit_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@else
 {!! Form::hidden('wroleunit_id', $data['wroleunit_id']) !!}

@endif

<div class="form-group {{ $errors->has('timetype_id') ? 'has-error' : ''}}">
    {!! Form::label('timetype_id', 'Timetype Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
      
        {!! Form::select('timetype_id', $data['timetype'], null, ['class' => 'form-control', 'required' => 'required']) !!}
        
         {!! $errors->first('timetype_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('start') ? 'has-error' : ''}}">
    {!! Form::label('start', 'Start', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::input('time', 'start', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('start', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('end') ? 'has-error' : ''}}">
    {!! Form::label('end', 'End', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::input('time', 'end', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('end', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('hour') ? 'has-error' : ''}}">
    {!! Form::label('hour', 'Hour', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('hour', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('hour', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('managernote') ? 'has-error' : ''}}">
    {!! Form::label('managernote', 'Managernote', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('managernote', null, ['class' => 'form-control']) !!}
        {!! $errors->first('managernote', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
