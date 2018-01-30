@extends($param['crudview'].'.edit')
@section('form')

<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('name', $data->name, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
   
    </div>
</div>

  <div class="table-responsive">
    <table class="table table-borderless">
        <thead>
            <tr>
                <th>Időtipus</th><th>Start</th><th>End</th><th>Óra</th><th>Szorzó</th><th>mejegyzés</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data->wroletime as $item)
            <tr>
                
                <td>{{ $item->timetype->name }}</td>
                <td>{{ $item->start }}</td><td>{{ $item->end }}</td><td>{{ $item->hour }}</td><td>{{ $item->timetype->szorzo }}</td>
                <td>
                    {{ str_limit($item->managernote, 20,  '...') }}
                </td>  
                <td>
                    <a href="{{ MoHandF::url('manager/wroletimes/'.$item->id.'/edit',$param['getT'],['wru_id'=>$data['id'],'wrtime_redir'=>'wru']) }} "
                        class="btn btn-primary btn-xs">
                       <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <a href="{{ MoHandF::url('manager/wroletimes',$param['getT'],['task'=>'del','wrtime_id'=>$item->id,'wru_id'=>$data['id'],'wrtime_redir'=>'wru']) }} "
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
  
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>

<a href="{{ MoHandF::url('manager/wroletimes/create',$param['getT'],['wru_id'=>$data['id'],'wrtime_redir'=>'wru']) }}" 
    class="btn btn-success btn-sm" title="Add New Wroletime">
    <i class="fa fa-plus" aria-hidden="true"></i> Idő hozzáadása
</a>

<div class="form-group {{ $errors->has('timetype_id') ? 'has-error' : ''}}">
    {!! Form::label('daytype_id', 'Naptípusok ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">     
            @foreach ($data['basedaytype'] as $time)  
           {{ Form::checkbox('daytype_id[]', $time['id'],in_array($time['id'],$data['checked_daytype']), ['multiple' => 'multiple']) }} {{ $time['name']}}   
            @endforeach            
         {!! $errors->first('daytype_id', '<p class="help-block">:message</p>') !!}
    </div>

</div>
<div class="form-group {{ $errors->has('unit') ? 'has-error' : ''}}">
    {!! Form::label('unit', 'Unit', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('unit',['nap'=>'nap', 'hét'=>'hét', 'hónap'=>'hónap'], $data->unit, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('unit', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('long') ? 'has-error' : ''}}">
    {!! Form::label('long', 'Long', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('long', $data->long, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('long', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('note') ? 'has-error' : ''}}">
    {!! Form::label('note', 'Note', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('note', $data->note, ['class' => 'form-control']) !!}
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
</div>
        {!! Form::hidden('pub', 0) !!}
  

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Mentés', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
@endsection