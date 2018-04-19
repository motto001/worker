@php
$getT=$param['getT'];
@endphp 

<div class="table-responsive">
    <div class="table-responsive">
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>ID</th><th>Dolgozó</th><th>Év</th><th>Hó</th><th>Mentés neve</th><th>Megjegyzés</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data['list']  as $item)
                <tr>
                    <td>{{ $item->id }}</td><td>{{ $item->worker_id }}</td>
                    <td>{{ $item->ev }}</td><td>{{ $item->ho }}</td><td>{{ $item->name }}</td><td>{{  $item->note }}</td>
                    <td>
                        <a href="{{ url('/'.$param['routes']['base'].'/calendar/' . $item->id,$param['getT']) }}" 
                            title="View "><button class="btn btn-info btn-xs">
                            <i class="fa fa-calendar" aria-hidden="true"></i> </button></a>

                    
                  
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>
