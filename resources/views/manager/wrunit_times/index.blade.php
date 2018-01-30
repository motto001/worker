@extends($param['crudview'].'.index')
@section('table')
<a href=" {!! MoHandF::url($param['routes']['base'],$param['getT'],['wru_id'=>0]) !!}" 
    title="Munkarend ciklus választás">
@if ($param['getT']['wru_id']==0)    
<button class="btn btn-danger btn-xs">
@else
<button class="btn btn-warning btn-xs">
@endif
    Mind
    </button>
    </a>        
@foreach($data['wroleunit'] as $unit)
    <a href=" {!! MoHandF::url($param['routes']['base'],$param['getT'],['wru_id'=>$unit['id']]) !!}" 
    title="Munkareng ciklus választás">
@if ($param['getT']['wru_id']==$unit['id'])    
<button class="btn btn-danger btn-xs">
@else
<button class="btn btn-warning btn-xs">
@endif
        {!!    $unit['name'] !!}
    </button>
    </a>
@endforeach 
             

      <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                     <th>Műszak</th><th>Időtipus</th><th>Start</th><th>End</th><th>Óra</th><th>Szorzó</th><th>Fixplusz</th><th>mejegyzés</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['list'] as $item)
                                    <tr>
                                        <td>{{ $item['wroleunit']['name'] }}</td>
                                        <td>{{ $item['timetype']['name'] }}</td>
                                        <td>{{ $item->start }}</td><td>{{ $item->end }}</td><td>{{ $item->hour }}</td><td>{{ $item['timetype']['szorzo'] }}</td><td>{{ $item['timetype']['fixplusz ']}}</td>
                                        <td>
                                          {{ str_limit($item->managernote, 20,  '...') }}
                                        </td>  
                                        <td>
                                    {!! 
                                        MoHandF::linkButton([
                                        'link'=> MoHandF::url($param['routes']['base'].'/'.$item->id.'/edit',$param['getT']),
                                        'fa'=>'pencil-square-o']) 
                                    !!}
                                    {!!
                                         MoHandF::delButton([
                                        'tip'=>'del',
                                        'link'=>MoHandF::url($param['routes']['base'].'/'.$item->id,$param['getT']),
                                        'fa'=>'trash-o']) 
                                    !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                         </div>
    



                

@endsection
