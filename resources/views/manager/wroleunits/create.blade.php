@extends($param['crudview'].'.create')
@section('form')


<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>


</div><div class="form-group {{ $errors->has('timetype_id') ? 'has-error' : ''}}">
    {!! Form::label('daytype_id', 'Naptípusok ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">     
            @foreach ($data['basedaytype'] as $time)  
           {{ Form::checkbox('daytype_id[]', $time['id'],in_array($time['id'],$data['checked_daytype']), ['multiple' => 'multiple']) }} {{ $time['name']}}   
            @endforeach            
         {!! $errors->first('daytype_id', '<p class="help-block">:message</p>') !!}
    </div>

</div><div class="form-group {{ $errors->has('unit') ? 'has-error' : ''}}">
    {!! Form::label('unit', 'Unit', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('unit',['nap'=>'nap', 'hét'=>'hét', 'hónap'=>'hónap'], null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('unit', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('long') ? 'has-error' : ''}}">
    {!! Form::label('long', 'Long', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('long', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('long', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('note') ? 'has-error' : ''}}">
    {!! Form::label('note', 'Note', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('note', null, ['class' => 'form-control']) !!}
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>

        {!! Form::hidden('pub', 0) !!}
  

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
@endsection