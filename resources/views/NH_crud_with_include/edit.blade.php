@if(!isset($param['modal']))

@extends('layouts.backend')
@section('content')
@include('layouts.sidebar')
@endif           
@php 
if(!isset($param['getT'])) {$param['getT']=[];}
$cancelurl=$param['routes']['redir'] ?? $param['routes']['base'];
$cancelurl=$data['link_cancel'] ?? '/'.$cancelurl;
$form=$param['view']['form'] ?? $param['view']['include'].'.form';
$form=$param['view']['editform'] ?? $form;
@endphp

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

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($data, [
                            'method' => 'PATCH',
                            'url' => MoHandF::url($param['routes']['base'].'/'.$data['id'],$param['getT']),
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include($form, ['submitButtonText' => trans('mo.save')])
                       
                        {!! Form::close() !!}

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