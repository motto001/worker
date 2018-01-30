@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Személyes </div>
                    <div class="panel-body">

                        

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr><th>ID</th><td>{{ $workeruser->id }}</td></tr>
                                    <tr><th> User Id </th><td> {{ $workeruser->user_id }} </td></tr>
                                    <tr><th> Name </th><td> {{ $workeruser['name'] }} </td></tr>
                                    <tr><th> Email </th><td> {{ $workeruser['email'] }} </td></tr>
                                    <tr><th> Cim </th><td> {{ $workeruser->cim }} </td></tr>
                                    <tr><th>Tel </th><td> {{ $workeruser->tel }} </td></tr>
                                    <tr><th> Birth</th><td> {{ $workeruser->birth }} </td></tr>
                                    <tr><th> Ado </th><td> {{ $workeruser->ado }} </td></tr>
                                    <tr><th> Cim </th><td> {{ $workeruser->cim }} </td></tr>
                                    <tr><th> Tb</th><td> {{ $workeruser->tb }} </td></tr>
                                    <tr><th> Kezdés </th><td> {{ $workeruser->start }} </td></tr>
                                    <tr><th> Befejezés</th><td> {{ $workeruser->end }} </td></tr>
                                    <tr><th> Statusz </th><td> {{ $workeruser->statusz }} </td></tr>


                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
