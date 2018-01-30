{!! Form::model($data, [
    'method' => 'PATCH',
    'url' => MoHandF::url($param['routes']['base'].'/'.$data['formdata']->id,$param['getT']),
    'class' => 'form-horizontal',
    'files' => true
]) !!}

</br></br></br>
<div class="form-group {{ $errors->has('start') ? 'has-error' : ''}} {{ $errors->has('end') ? 'has-error' : ''}} {{ $errors->has('hour') ? 'has-error' : ''}}">
    {!! Form::label('timetype_id', 'Időtipus', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-2">
        {!! Form::select('timetype_id',  $data['timetype'], $data['formdata']->timetype_id, ['class' => 'form-control', 'required' => 'required']) !!}    
         {!! $errors->first('timetype_id', '<p class="help-block">:message</p>') !!}
    </div>
   
    {!! Form::label('start', 'kezdés', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-2">
        {!! Form::input('time', 'start', str_limit($data['formdata']->start , 5,'' ), ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('start', '<p class="help-block">:message</p>') !!}
    
    </div> 
    {!! Form::label('end', 'Befejezés', ['class' => 'col-md-1 control-label']) !!}  
    <div class="col-md-2">
        {!! Form::input('time', 'end',str_limit($data['formdata']->end , 5,'' ), ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('end', '<p class="help-block">:message</p>') !!}
    </div>
    {!! Form::label('hour', 'Óraszám', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-1">
        {!! Form::number('hour', $data['formdata']->hour, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('hour', '<p class="help-block">:message</p>') !!}
    </div>
    <div class=" col-md-1">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Mentés', ['class' => 'btn btn-primary']) !!}
    </div>
</div>    
</div>

<div class="form-group">
    
</div>
{!! Form::close() !!}