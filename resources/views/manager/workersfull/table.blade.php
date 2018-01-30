
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>Név</th><th>munkarend</th><th>email</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data['list'] as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->fullname }}</td><td>{{ $item->wrole->name }}</td><td>{{ $item->user->email }}</td>
                                        <td>
                                          @include('crudbase.listbuttons')
                                            
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                           
                        </div>


