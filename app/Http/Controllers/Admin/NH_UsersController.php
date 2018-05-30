<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Session;
class NH_UsersController extends Controller
{

 public   $val= ['name' => 'required', 'email' => 'required', 'roles' => 'required'];

}