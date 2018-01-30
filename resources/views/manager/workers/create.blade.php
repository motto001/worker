@extends($param['crudview'].'.create')
@section('form')

<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    {!! Form::label('user_id', 'Felhasználó', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
      
          {!! Form::select('user_id',$data['user'],
           null, ['class' => 'form-control', 'required' => 'required']) !!}

        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('status_id') ? 'has-error' : ''}}">
    {!! Form::label('status_id', 'Status', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
       {!! Form::select('status_id',$data['status'],
           null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('status_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('workertype_id') ? 'has-error' : ''}}">
    {!! Form::label('workertype_id', 'Munkatipus', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
       {!! Form::select('workertype_id',$data['workertype'],
           null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('workertype_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('workergroup_id') ? 'has-error' : ''}}">
    {!! Form::label('workergroup_id', 'Munkacsoport', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
         {!! Form::select('workergroup_id',$data['workergroup'],
           null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('workergroup_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('salary') ? 'has-error' : ''}}">
    {!! Form::label('salary', 'Fizetés', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('salary', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('salary', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('salary_type') ? 'has-error' : ''}}">
    {!! Form::label('salary_type', 'fizetés tipus', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('salary_type', ['órabér'=>'órabér', 'hetibér'=>'hetibér', 'havibér'=>'havibér'], null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('salary_type', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('position') ? 'has-error' : ''}}">
    {!! Form::label('position', 'Beosztás', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('position', null, ['class' => 'form-control']) !!}
        {!! $errors->first('position', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
    {!! Form::label('image', 'Foto', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::file('image', null, ['class' => 'form-control']) !!}
        {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('fullname') ? 'has-error' : ''}}">
    {!! Form::label('fullname', 'Teljes név', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('fullname', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('fullname', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('cim') ? 'has-error' : ''}}">
    {!! Form::label('cim', 'Cim', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('cim', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('cim', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('tel') ? 'has-error' : ''}}">
    {!! Form::label('tel', 'Tel', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('tel', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('tel', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('birth') ? 'has-error' : ''}}">
    {!! Form::label('birth', 'Születési dátum', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('birth', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
        {!! $errors->first('birth', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('ado') ? 'has-error' : ''}}">
    {!! Form::label('ado', 'Ado', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('ado', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('ado', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('tb') ? 'has-error' : ''}}">
    {!! Form::label('tb', 'Tb', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('tb', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('tb', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('start') ? 'has-error' : ''}}">
    {!! Form::label('start', 'Munkaviszony kezdete', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('start', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
        {!! $errors->first('start', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('end') ? 'has-error' : ''}}">
    {!! Form::label('end', 'Munkaviszony vége', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('end', null, ['class' => 'form-control datepicker']) !!}
        {!! $errors->first('end', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('note') ? 'has-error' : ''}}">
    {!! Form::label('note', 'Note', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('note', null, ['class' => 'form-control']) !!}
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
</div>

 {!! Form::hidden('pub', 0) !!}
       


<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>

@endsection
