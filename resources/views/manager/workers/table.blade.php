@php

$getT=$param['getT'];
@endphp 

<div class="table-responsive">
    <div class="table-responsive">
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>ID</th><th>Foto</th><th>User név</th><th>Teljes név</th><th>Email</th><th>Munkakör</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data['list']  as $item)
                <tr>
                    <td>{{ $item->id }}</td><td> <img src="/{{ $item->foto }}" alt="foto" height="20" width="25"> </td>
                    <td>{{ $item['user']['name'] }}</td><td>{{ $item->fullname }}</td><td>{{ $item['user']['email'] }}</td><td>{{  $item->position }}</td>
                    <td>

                         
                        <a href=" {!! MoHandF::url($param['routes']['base'].'/'.$item->id,$getT) !!}  " title="View ">
                            <button class="btn btn-info btn-xs">
                                    <i class="fa fa-eye" aria-hidden="true"></i> 
                            </button>
                        </a>
                        
                       
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

</div>
