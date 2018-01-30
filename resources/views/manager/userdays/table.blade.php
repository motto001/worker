

    <div class="table-responsive">
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>ID</th><th>Tipus</th><th>Datum</th><th>Jegyzet</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data['list'] as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->daytype->name}}</td><td>{{ $item->datum }}</td><td>{{ $item->note }}</td>
                    <td>
        @include('crudbase.listbuttons')
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
      
    </div>

 {!! $data['calendar']->generate() !!}
