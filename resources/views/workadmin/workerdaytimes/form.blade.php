
{!! Form::open(['url' => MoHandF::url($param['routes']['base'].'/'.$data['worker_id'],$getT), 
'class' => 'form-horizontal', 'files' => true]) !!}
<h3>Nap típus kérés</h3>

 <div class="row"> 
<div class="col-md-3">  <span>Nap típus </span>  
    {!! Form::select('daytype_id', $data['daytype'], null, ['class' => 'form-control input-sm', 'required' => 'required']) !!}       
     {!! $errors->first('daytype_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="col-md-3"><span>Megjegyzés</span>
    {!! Form::text('managernote', null, ['class' => 'form-control input-sm']) !!}
    {!! $errors->first('managernote', '<p class="help-block">:message</p>') !!}
</div>
<div class="col-md-4"><div> -</div>
    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Kérés küldése', ['class' => 'btn btn-primary','name' => 'daytypechange']) !!}
   {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Kérés törlése', ['class' => 'btn btn-danger','name' => 'daytypedel']) !!}

</div>
<input type="hidden" name="worker_id" value="{{$data['worker_id']}}" >
</div>
<h3>Munkaidő felvitele </h3>
<div class="row"> 
  
        <div class="col-xs-3"><span>Kezdés</span>
            {!! Form::input('time','start', null, ['class' => 'form-control input-sm']) !!}

            {!! $errors->first('start', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-md-2"><span>Befejezés</span>
            {!! Form::input('time','end', null, ['class' => 'form-control input-sm']) !!}
            {!! $errors->first('end', '<p class="help-block">:message</p>') !!}
        </div>

      <div class="col-md-2">  <span>Idő típus </span>  
            {!! Form::select('timetype_id', $data['timetype'], null, ['class' => 'form-control input-sm', 'required' => 'required']) !!}       
             {!! $errors->first('timetype_id', '<p class="help-block">:message</p>') !!}
        </div>


        <div class="col-md-2"><span>Megjegyzés</span>
            {!! Form::text('managernote2', null, ['class' => 'form-control input-sm']) !!}
            {!! $errors->first('managernote2', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-md-4"><div> -</div>
            {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Munkaidő felvitel', ['class' => 'btn btn-primary','name' => 'timeadd']) !!}
          {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Munkaidők törlése', ['class' => 'btn btn-danger','name' => 'timedel']) !!}
        
        </div>
     
        </div>

@include('calendar.calendar')

{!! Form::close() !!}
  