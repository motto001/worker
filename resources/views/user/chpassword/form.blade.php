<div class="form-group {{ $errors->has('oldpassword') ? 'has-error' : ''}}">
    {!! Form::label('oldpassword', 'Oldpassword', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::password('oldpassword', ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('oldpassword', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
    {!! Form::label('password', 'Password', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::password('password', ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('password2') ? 'has-error' : ''}}">
    {!! Form::label('password2', 'Password2', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::password('password2', ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('password2', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
