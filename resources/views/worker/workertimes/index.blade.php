@extends($param['crudview'].'.index')
@section('table')


      <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                     <th>Időtipus</th><th>Dátum</th><th>Start</th><th>End</th><th>Óra</th><th>mejegyzés</th><th>Állapot</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['list'] as $item)
                                    <tr>
                                       
                                        <td>{{ $item['timetype']['name'] }}</td>
                                        <td>{{ $item->datum }}</td> <td>{{ $item->start }}</td><td>{{ $item->end }}</td><td>{{ $item->hour }}</td>
                                        <td>
                                          {{ str_limit($item->managernote, 20,  '...') }}
                                        </td>  
                                        <td>

                                                @if($item->pub==1)
                                                 <span class="btn btn-primary btn-xs"> uj</span>
                                                @elseif($item->pub==0)
                                                <span class="btn btn-success btn-xs" title="Add New Wroletime">
                                                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                                </span>
                                                @elseif($item->pub==2)
                                                <span class="btn btn-danger btn-xs" title="Add New Wroletime">
                                                    <i class="fa fa-times" aria-hidden="true"></i> 
                                                </span>
                                                @endif
    
                                            </td>
                                        <td>
                             @if($item->pub==1)          
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
                                @endif   
                                @endforeach
                                </tbody>
                            </table>
                         </div>
    



                

@endsection
