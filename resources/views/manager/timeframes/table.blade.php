
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>Name</th><th>Unit</th><th>Long</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data['list']  as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td><td>{{ $item->unit }}</td><td>{{ $item->long }}</td>
                                        <td>
                                     @include('crudbase.listbuttons')
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                         </div>

