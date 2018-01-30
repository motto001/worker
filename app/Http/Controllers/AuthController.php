<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Routing\Controller;

class AuthController extends Controller {
    public function logout() {
        
        Auth::logout();
        $dataT =[
            'message'=>'logged out'
        ]  ;
        return response()->json($dataT,200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
       }  
    public function authenticate()
    {
        $email='admin@dolgozo.com';
        $password='aaaaaa';
    if(isset($_POST['email'])) {$email=$_POST['email'];}
    if(isset($_POST['password'])) {$password=$_POST['password'];}
            if (Auth::attempt(['email' => $email, 'password' => $password]))
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
                    ] ,
                    'message'=>'logged'
                ]; 
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
                    ] ,
                    'message'=>'notlogged'
                ];
    
            }
           
           return response()->json($dataT,200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
           
           
           
           
            // return redirect()->intended('dashboard');
    }
    

}