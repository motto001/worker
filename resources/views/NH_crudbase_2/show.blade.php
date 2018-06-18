@if(!isset($param['modal']))

@extends('layouts.backend')
@section('content')
@include('admin.sidebar')
           
@endif   
 @if(isset($data['cancelurl']))
    @php $cancelurl='/'.$data['cancelurl']; @endphp
 @else
   @php $cancelurl=MoHandF::url($param['baseroute'],$param['getT']); @endphp   
 @endif
<section id="main-content">  
    <section class="wrapper">
        <div class="row">   
            <div class="col-lg-12 main-chart">
                <div class="panel panel-default">
                    <div class="panel-heading">{{  $param['cim']  or ''  }}  szerkesztés</div>
                    <div class="panel-body">
                        <a href="{{ $cancelurl }}" title="Cancel"><button class="btn btn-warning btn-xs">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Mégsem</button></a>
                        <br />
                        <br />

                     @yield('datas')
                  
                    </div>
                </div>
            </div>
        </div>
          </div>
</section>
</section>        
@if(!isset($param['modal']))        
    </div>
@endsection

@endif