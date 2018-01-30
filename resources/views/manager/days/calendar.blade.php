<style>
.weekness{
color:red;
border: 1px solid red; 
}
.workday{
color:silver;
border: 1px solid silver; 
}
.flex-container {
    padding: 0;
    margin: 0;
    list-style: none;
    justify-content:flex-end;
    -ms-box-orient: horizontal;
    display: -webkit-box;
    display: -moz-box;
    display: -ms-flexbox;
    display: -moz-flex;
    display: -webkit-flex;
    display: flex;
  }
  .nowrap  { 
    -webkit-flex-wrap: nowrap;
    flex-wrap: nowrap;
  }

  .flex-item { 
    background: white;
    padding: 5px;
    width: 13.7%;
   /* height: 100px;*/
    margin: 0.3%;
    text-align: center;
    overflow:hidden;
  }
</style>
<ul class="flex-container nowrap">
    <li class="flex-item "  style="height:40px;color:red;">Vasárnap</li>
    <li class="flex-item "  style="height:40px">Hétfő</li>
    <li class="flex-item "  style="height:40px">Kedd</li>
    <li class="flex-item "  style="height:40px">Szerda</li>
    <li class="flex-item "  style="height:40px">Csütörtök</li>
    <li class="flex-item "  style="height:40px">Péntek</li>
    <li class="flex-item "  style="height:40px; color:red;">Szombat</li>       
</ul>

    @foreach($data['calendar'] as $dt) 
     @if($dt['weeknum']==0) 
          <ul class="flex-container nowrap" style="justify-content:flex-start"> 
     @endif
        @if($dt['type']=='empty')
        <li class="flex-item" style="border: 1px solid silver;">
                   
        </li>
        @else          
        <li class="flex-item" style="border: 1px solid silver;">
        <div>{{ $dt['day'] }}.,  {{ $dt['type'] }}</div>
        <div style="display: flex;width:100%;justify-content:flex-end;border: 1px solid silver; ">            
            {!! Form::model($data, [
                            'method' => 'POST',
                            'url' =>  MoHandF::url($param['baseroute'], $param['getT']),
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}
            {!! Form::hidden('datum',$dt['date']) !!}            
            {!! Form::select('daytype_id',$data['daytype'],
           null, ['class' => 'form-control', 'required' => 'required']) !!}
 </div>  <div> 
            <a href="{{ url('/manager/workerusers/') }}"  title="View Workeruser"><button class="btn btn-info btn-xs">
                <i class="fa fa-save" aria-hidden="true"></i>Mentés </button>
            </a>
           {!! Form::close() !!}      
            </div> 
                    
        </li>
             
       
        @endif 
    @if($dt['weeknum']==6) 
    </ul > 
    @endif 
    @endforeach
    