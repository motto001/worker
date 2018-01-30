
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>Name</th><th>Szorzo</th><th>Fixplusz</th><th>Megjegyzés</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data['list']  as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td><td>{{ $item->szorzo }}</td><td>{{ $item->fixplusz }}</td><td>{{str_limit($item->note, 20)  }}</td>
                                        <td>
                                  @include('crudbase.listbuttons')
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
</div>

