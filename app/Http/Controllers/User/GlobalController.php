<?php

namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GlobalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
       
       
        if (Auth::check())
        {
        $dataT =['user'=>[
                'id'=> Auth::id(),
                'email'=> Auth::user()->email,
                'name'=> Auth::user()->name,      
                ] ,
                'role'=>[      
                'manager'=> Auth::user()->hasRole('manager'),
                'workadmin'=> Auth::user()->hasRole('workadmin'),
                'worker'=> Auth::user()->hasRole('worker'),
                ]  ]; 
        }
        else{
        $dataT =['user'=>[
                'id'=> 0,
                'email'=> 'nomail',
                'name'=> 'noname',
                 ],
                'role'=>[      
                'manager'=> false,
                'workadmin'=> false,
                'worker'=> false,
                ]];

        }
       
       return response()->json($dataT,200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

   
   
}