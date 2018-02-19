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
                                                {!! 
                                                    MoHandF::linkButton([
                                                    'link'=> MoHandF::url($param['routes']['base'].'/'.$item->id.'/edit',$getT),
                                                    'fa'=>'pencil-square-o']) 
                                                !!}
                                                {!!
                                                     MoHandF::delButton([
                                                    'tip'=>'del',
                                                    'link'=>MoHandF::url($param['routes']['base'].'/'.$item->id,$getT),
                                                    'fa'=>'trash-o']) 
                                                !!} 
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                          