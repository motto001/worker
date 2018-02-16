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
                    <td>{{ $item->name }}</td><td>{{ $item->szorzo }}</td><td>{{ $item->fixplusz }}</td><td>{{ str_limit($item->note, 20) }}</td>
                    <td>
                    
                        <a href="{!!  MoHandF::url($param['routes']['base'].'/'.$item->id.'/edit',$param['getT']) !!} "
                            class="btn btn-primary btn-xs" title="edit">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 
                        </a> 
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