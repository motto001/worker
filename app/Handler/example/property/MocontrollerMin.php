<?php
trait MoControllerBase{
protected $par = [
    'routes' => ['base'=>'admin/users'],
    'view' => ['base'=>'crudbase','include'=>'admin.users',],
    ];
    protected $base = [
   'obname' => 'app/User', //lehet tömb is ha ha a setobArray trait-et  hívjuk be
   ];

    protected $val = []; //pl.:['wroleunit_id' => 'required|integer','end' => 'date_format:H:i','note' => 'string|max:200|nullable']

}

