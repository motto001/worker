
              
                 @foreach($data['years']  as $year)
                                <a href=" {!! MoHandF::url($param['routes']['base'],$param['getT'],['ev'=>$year]) !!}" 
                                title="worker választás">
                                <button class="btn btn-warning btn-xs">
                                    {!!    $year !!}
                                </button>
                                </a>
                   @endforeach  
             
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>Daytype</th><th>Datum</th><th>note</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data['list']  as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->daytype->name }}</td><td>{{ $item->datum }}</td><td>{{ $item->note }}</td>
                                        <td>
                                    {!! 
                                        MoHandF::linkButton([
                                        'link'=> MoHandF::url($param['routes']['base'].'/'.$item->id.'/edit',$param['getT']),
                                        'fa'=>'pencil-square-o']) 
                                    !!}
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

