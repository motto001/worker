

<div class="form-group {{ $errors->has('daytype_id') ? 'has-error' : ''}}">
    {!! Form::label('daytype_id', 'Naptipus', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
             {!! Form::select('daytype_id',$data['daytype'], null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('daytype_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('ev') ? 'has-error' : ''}}">
    {!! Form::label('ev', 'Év, ha üres minden évre érvényes', ['class' => 'col-md-4 control-label ']) !!}
    <div class="col-md-6">
        {!! Form::text('ev', null, ['class' => 'form-control ']) !!}
        {!! $errors->first('ev', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('datum') ? 'has-error' : ''}}">
    {!! Form::label('datum', 'Datum', ['class' => 'col-md-4 control-label ']) !!}
    <div class="col-md-6">
        {!! Form::text('datum', null, ['class' => 'form-control datepickernoyear', 'required' => 'required']) !!}
        {!! $errors->first('datum', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('note') ? 'has-error' : ''}}">
    {!! Form::label('note', 'Note', ['class' => 'col-md-4 control-label']) !!}
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




