
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>Day Id</th><th>Timetype Id</th><th>Start</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($workertimes as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->day_id }}</td><td>{{ $item->timetype_id }}</td><td>{{ $item->start }}</td>
                                        <td>
                               @include('crudbase.listbuttons')
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                       </div>
