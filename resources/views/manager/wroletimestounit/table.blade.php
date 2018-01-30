
        
                    

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Időtipus</th><th>Start</th><th>End</th><th>Óra</th><th>Szorzó</th><th>Fixplusz</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data['list'] as $item)
                                    <tr>
                                        <td>{{ $item->timetype->name }}</td>
                                        <td>{{ $item->start }}</td><td>{{ $item->end }}</td><td>{{ $item->hour }}</td><td>{{ $item->timetype->szorzo }}</td><td>{{ $item->timetype->fixplusz }}</td>
                                        <td>
                          @include('crudbase.listbuttons')
                                    
                                    </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                         </div>
    