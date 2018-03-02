{!! Form::open([
    'url' => MoHandF::url($param['routes']['base'],$param['getT']), 
'class' => 'form-horizontal', 'files' => true]) !!}
</br></br></br>
<div class="form-group {{ $errors->has('start') ? 'has-error' : ''}} {{ $errors->has('end') ? 'has-error' : ''}} {{ $errors->has('hour') ? 'has-error' : ''}}">
    {!! Form::label('timetype_id', 'Időtipus', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-2">
        {!! Form::select('timetype_id',  $data['timetype'], null, ['class' => 'form-control', 'required' => 'required']) !!}    
         {!! $errors->first('timetype_id', '<p class="help-block">:message</p>') !!}
    </div>
   
    {!! Form::label('start', 'kezdés', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-2">
        {!! Form::input('time', 'start', null , ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('start', '<p class="help-block">:message</p>') !!}
    
    </div> 
    {!! Form::label('end', 'Befejezés', ['class' => 'col-md-1 control-label']) !!}  
    <div class="col-md-2">
        {!! Form::input('time', 'end',null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('end', '<p class="help-block">:message</p>') !!}
    </div>
    {!! Form::label('hour', 'Óraszám', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-1">
        {!! Form::number('hour', 1, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('hour', '<p class="help-block">:message</p>') !!}
    </div>
  
</div>


<div class="form-group {{ $errors->has('datum') ? 'has-error' : ''}} {{ $errors->has('end') ? 'has-error' : ''}} {{ $errors->has('hour') ? 'has-error' : ''}}">

    {!! Form::label('datum', 'Dátum', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-2">
        {!! Form::input('text', 'datum', $data['datum'] , ['class' => 'form-control datepicker', 'required' => 'required']) !!}
        {!! $errors->first('datum', '<p class="help-block">:message</p>') !!}
     
    </div> 
    <!-- 
    {!! Form::label('dateend', 'Befejeződátum', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-2">
        {!! Form::input('text', 'dateend',$data['datum'] , ['class' => 'form-control datepicker', 'required' => 'required']) !!}
        {!! $errors->first('dateend', '<p class="help-block">:message</p>') !!}
    </div>
--> 
    <div class=" col-md-1">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Mentés', ['class' => 'btn btn-primary']) !!}
    </div>
</div>

    
</div>

<div class="form-group">
    
</div>
{!! Form::close() !!}
