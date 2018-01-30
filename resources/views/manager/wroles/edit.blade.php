@extends($param['crudview'].'.edit')
@section('form')

<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-7">
        {!! Form::text('name', $data->name, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group ">    
        {!! Form::label('muszak', 'Műszak hozzáadása:', ['class' => 'col-md-3 control-label']) !!} 
     
<div class="col-md-7">    
   
@foreach($data['wroleunits_all'] as $unit)
    <a href=" {!! MoHandF::url($param['routes']['base'],$param['getT'],['wrole_id'=>$data['id'],'wrunit_id'=>$unit['id'],'task'=>'addunit']) !!}" 
    title="" class="btn btn-warning btn-xs">
        {!!  $unit['name'] !!}
    </a>
@endforeach


</div>
</div>
<a href="{!! MoHandF::url('manager/wroleunits/create',$param['getT'],['wrole_id'=>$data['id'],'wru_redir'=>'wrole']) !!} " 
class="btn btn-success btn-sm" title="Add New Wru">
    <i class="fa fa-plus" aria-hidden="true"></i> Új műszak 
</a>
    <div class="table-responsive">
        <table class="table table-borderless">
            <thead>
                <tr>
                   <th>Múszaknév</th><th>időegység</th><th>hossz</th><th>Munkaidők</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data->wroleunit as $item)
                <tr>
                    <td>{{ $item->name }}</td><td>{{ $item->unit }}</td><td>{{ $item->long }}</td>
                    <td>
                    @foreach($item->wroletime as $time) 
                    {{ '['.str_limit($time->start, 5, '').'-'.str_limit($time->end, 5, '').']'  }}
                    @endforeach
                    </td>
                    <td>
                        <a href=" {!! MoHandF::url($param['routes']['base'],$param['getT'],['wrole_id'=>$data['id'],'wrunit_id'=>$item['id'],'task'=>'delunit']) !!}" 
                            title="" class="btn btn-danger btn-xs" ><i class="fa fa-trash-o" aria-hidden="true"></i>
                            
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
</div>


<div class="form-group {{ $errors->has('note') ? 'has-error' : ''}}">
    {!! Form::label('note', 'Note', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-7">
        {!! Form::text('note',  $data->note, ['class' => 'form-control']) !!}
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('start') ? 'has-error' : ''}}">
    {!! Form::label('start', 'Start', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-7">
        {!! Form::text('start', $data->start, ['class' => 'form-control datepicker']) !!}
        {!! $errors->first('start', '<p class="help-block">:message</p>') !!}
    </div>
</div>

        {!! Form::hidden('pub', 0) !!}

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Mentés', ['class' => 'btn btn-primary']) !!}
    </div>
</div>

@endsection
