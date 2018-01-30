
 <ul class="flex-container nowrap">
        <li class="flex-item "  style="height:40px">Hétfő</li>
        <li class="flex-item "  style="height:40px">Kedd</li>
        <li class="flex-item "  style="height:40px">Szerda</li>
        <li class="flex-item "  style="height:40px">Csütörtök</li>
        <li class="flex-item "  style="height:40px">Péntek</li>
        <li class="flex-item "  style="height:40px; color:red;">Szombat</li>
        <li class="flex-item "  style="height:40px;color:red;">Vasárnap</li>

    </ul>
    @foreach($data['days'] as $dt) 
            @if($dt['weeknum']==1 || $dt['date']==1)
            <ul class="flex-container nowrap" 
            @if($dt['date']>21)
            style="justify-content:flex-start"
            @endif
            >
            @endif
            
            
                <li class="flex-item {{ $dt['class'] }}"
                
                @if($dt['date']==$data['day'])
                style="border-color:blue;"
                @endif
                
                >
                    
            

                    <span>{{ $dt['date'] }}</span>
        <div style="display: flex;width:100%;justify-content:flex-end;border: 1px solid silver; ">            
        <a href="{{ url('/manager/workerusers/') }}" 
        title="View Workeruser"><button class="btn btn-info btn-xs">
        <i class="fa fa-eye" aria-hidden="true"></i> </button>
        </a>
        <span 
            title="Edit Workeruser"><button class="btn btn-primary btn-xs"
        @if($data['userid']>0) 
            onClick="javascript:window.location.href='/workadmin/workerdays/create/{{$data['year']}}/{{$data['month']}}/{{$dt['date']}}/{{$data['userid']}}'" 
        @else
            onClick="alert('Ki kell jelölni egy felhasználót!')"
        @endif
            >
            <i class="fa fa-pencil-square-o" aria-hidden="true">szerk</i></button>
            </span>
            </div> 
                    
                </li>
            
        @if($dt['weeknum']==0 )
        </ul >
        @endif
            
        @endforeach
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