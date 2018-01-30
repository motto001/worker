<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('szorzo') ? 'has-error' : ''}}">
    {!! Form::label('szorzo', 'Szorzo', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
       {!! Form::number('szorzo', null, ['class' => 'form-control','type'=>'range','min' =>'0' ,'max'=>'10' ,'step'=>'0.01']) !!}
        {!! $errors->first('szorzo', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('fixplusz') ? 'has-error' : ''}}">
    {!! Form::label('fixplusz', 'Fixplusz', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('fixplusz', null, ['class' => 'form-control']) !!}
        {!! $errors->first('fixplusz', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('color') ? 'has-error' : ''}}">
    {!! Form::label('color', 'Color', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('color', null, ['class' => 'form-control']) !!}
        {!! $errors->first('color', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('note') ? 'has-error' : ''}}">
    {!! Form::label('note', 'Note', ['class' => 'col-md-4 control-label']) !!}
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
