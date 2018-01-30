
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>Name</th><th>Email</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data['list']  as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td><td>{{ $item->name }}</td><td>{{ $item->email }}</td>
                                        <td>
                            
<a href="{{ url('/'.$param['baseroute'].'/' . $item->id . '/edit'.$param['route_param']) }}"
    title="Edit "><button class="btn btn-primary btn-xs">
    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button></a>
   
   {!! Form::open([
       'method'=>'DELETE',
       'url' => ['/'.$param['baseroute']. '/'. $item->id. $param['route_param']],
       'style' => 'display:inline'
   ]) !!}
       {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> ', array(
               'type' => 'submit',
               'class' => 'btn btn-danger btn-xs',
               'title' => 'Törlés',
               'onclick'=>'return confirm("Confirm delete?")'
       )) !!}
       {!! Form::close() !!}
                                       
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                     </div>

