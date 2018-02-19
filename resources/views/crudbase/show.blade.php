@php
//use \app\Http\Controllers\Worker\WorkersController;
//adatok-----------------
if(!isset($data)) {$data=[];}
$showT=$param['show'] ?? [[
    ['colname'=>'id','label'=>'Id'],
    ['colname'=>'fullname','label'=>'név'],
    ['colname'=>'foto','label'=>'Foto','func'=>'image'],
    ['colname'=>'cim','label'=>'Cím'],
    ['colname'=>'birth','label'=>'Születési dátum'],
    ['colname'=>'tel','label'=>'Telefon'],
    ['colname'=>'ado','label'=>'Adószám'],
    ['colname'=>'tb','label'=>'TBszám'],
    ['colname'=>'start','label'=>'Kezdés'],
   ]];
$modal=$getT['modal'] ?? false;
$modal=$param['modal'] ?? $modal; 
$list=$data['list'] ?? $data;
$getT=$param['getT'] ?? [];
$formbase=$param['view']['include'] ?? $param['view']['base'] ;
$formview=$param['view']['form'] ??  $formbase.'.form'; 
//urlek------------------------
$cancelUrl=$param['routes']['cancel'] ?? MoHandF::url($param['routes']['base'],$getT);
$formurl=$param['routes']['form'] ?? MoHandF::url($param['routes']['base'],$getT);
//gombok,mezők----------------------------------
$cancel_button=$param['cancel_button'] ?? false;
//feliratok----------------------
$cim=$param['cim'] ?? '';
$cancel_label=$param['label']['cancel'] ??  trans('mo.cancel');
@endphp

@if(!$modal)
@extends('layouts.backend')
@section('content')
@include('layouts.sidebar')    
@endif 
 
<section id="main-content">  
    <section class="wrapper">
        <div class="row">   
            <div class="col-lg-12 main-chart">
                <div class="panel panel-default">
                    <div class="panel-heading">{{  $param['cim']  or ''  }}  </div>
                    <div class="panel-body">
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                            @foreach($showT as $show)
                            <tr>
                                    <th>{!! App::make("app\Http\Controllers\Worker\WorkersController")->label($show) !!}</th>
                                    <td>{!! App::make("app\Http\Controllers\Worker\WorkersController")->data($show,$data) !!}</td>
                                </tr>
                            @endforeach
                                </tbody>
                            </table>
                        </div>       

                    </div>
                </div>
            </div>
        </div>
          </div>
</section>
</section>        
@if(!$modal)        
    </div>
@endsection

@endif