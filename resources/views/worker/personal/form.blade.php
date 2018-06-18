<div class="form-group {{ $errors->has('oldpassword') ? 'has-error' : ''}}">
    {!! Form::label('oldpassword', 'Régi jelszó', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::password('oldpassword', ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('oldpassword', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
    {!! Form::label('password', 'Új jelszó', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::password('password', ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
        {!! Form::label('', '', ['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
                <p id="passwordHelpBlock" class="form-text text-muted">
                        A jelszónak legalább  8 karakterből kell állnia. és tartalmazni kell kis és nagybetűt, számot, valamint speciális karaktert (@#$&).
                </p>
        </div>
    </div>

<div class="form-group {{ $errors->has('password2') ? 'has-error' : ''}}">
    {!! Form::label('password2', 'Új jelszó mégegyszer', ['class' => 'col-md-4 control-label']) !!}
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
