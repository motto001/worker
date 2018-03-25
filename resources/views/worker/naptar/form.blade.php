@include('calendar.ev_ho')
{!! Form::open(['url' => MoHandF::url($param['routes']['base'],$getT), 
'class' => 'form-horizontal', 'files' => true]) !!}
<h3>Nap típus kérés</h3>

<div class="row"> 
<div class="col-md-3">  <span>Nap típus </span>  
    {!! Form::select('daytype_id', $data['daytype'], null, ['class' => 'form-control', 'required' => 'required']) !!}       
     {!! $errors->first('daytype_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="col-md-3"><span>Megjegyzés</span>
    {!! Form::text('workernote', null, ['class' => 'form-control']) !!}
    {!! $errors->first('workernote', '<p class="help-block">:message</p>') !!}
</div>
<div class="col-md-2"><div> -</div>
    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Kérés küldése', ['class' => 'btn btn-primary','name' => 'daytypechange']) !!}

</div>
<div class="col-md-1"><div> -</div>
    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Kérés törlése', ['class' => 'btn btn-danger','name' => 'daytypedel']) !!}

</div>
</div>
<h3>Munkaidő felvitele </h3>
<div class="row"> 
  
        <div class="col-md-2"><span>Kezdés</span>
            {!! Form::input('time','start', null, ['class' => 'form-control']) !!}
            {!! $errors->first('start', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-md-2"><span>Befejezés</span>
            {!! Form::input('time','end', null, ['class' => 'form-control']) !!}
            {!! $errors->first('end', '<p class="help-block">:message</p>') !!}
        </div>

      <div class="col-md-2">  <span>Idő típus </span>  
            {!! Form::select('timetype_id', $data['timetype'], null, ['class' => 'form-control', 'required' => 'required']) !!}       
             {!! $errors->first('timetype_id', '<p class="help-block">:message</p>') !!}
        </div>


        <div class="col-md-2"><span>Megjegyzés</span>
            {!! Form::text('workernote2', null, ['class' => 'form-control']) !!}
            {!! $errors->first('workernote2', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-md-2"><div> -</div>
            {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Munkaidő felvitel', ['class' => 'btn btn-primary','name' => 'timeadd']) !!}
        
        </div>
        <div class="col-md-1"><div> -</div>
            {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Munkaidők törlése', ['class' => 'btn btn-danger','name' => 'timedel']) !!}
        
        </div>
        </div>

@include('calendar.calendar')

{!! Form::close() !!}
  