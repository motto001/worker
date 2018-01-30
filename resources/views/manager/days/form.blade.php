<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    {!! Form::label('daytype_id', 'Naptipus', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
      
          {!! Form::select('daytype_id',$data['daytype'],
           null, ['class' => 'form-control', 'required' => 'required']) !!}

        {!! $errors->first('daytype_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
 
<div class="form-group {{ $errors->has('datum') ? 'has-error' : ''}}">
    {!! Form::label('datum', 'Datum', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('datum', null, ['class' => 'form-control','placeholder' => '000-01-31', 'required' => 'required']) !!}
        {!! $errors->first('datum', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('note') ? 'has-error' : ''}}">
    {!! Form::label('note', 'Usernote', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('note', null, ['class' => 'form-control']) !!}
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
