@php

$getT=$param['getT'];
$addroute=str_replace("_","/",$getT['addroute']);
@endphp

<style>

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
             /* width: 13.7%;
          height: 100px;*/
            margin: 0.3%;
            text-align: center;
            overflow:hidden;
          }
 
        </style>



<ul class="flex-container nowrap" style="justify-content:flex-start;margin: 2%;"> 

    @foreach($data['list']  as $item)
        <div style="border: 1px solid grey; border-radius: 3px;margin: 0.5%;">   
            <li class="flex-item" >
            <div style="height:60px;width:60px;">  
                @if(isset($item->foto))
                 <img src="/{{ $item->foto }}" alt="foto" height="50px" width="50px"> 
                @else
                <i class="fa fa-user fa-3x"  aria-hidden="true"></i>
                @endif
            </div>   
                                {{ $item['user']['name'] }}
<br/>
                                    
                                    <a href=" {!! MoHandF::url($addroute,[],['task'=>'addworker','worker_id'=>$item->id,'group_id'=>$getT['group_id']]) !!}  " title="View "
                                        class=" btn-info btn-xs">
                                                <i class="fa fa-check" aria-hidden="true">Beszur</i> 
                                       
                                    </a>
            </li>                        
        </div>
    @endforeach    

</ul>       
          

