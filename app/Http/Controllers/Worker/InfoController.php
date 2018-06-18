<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class InfoController extends Controller
{
public function index($dir,$file){

  //  return view('admin.'.$dir.'.'.$file, compact('permissions'));
  return view('worker.'.$dir.'.'.$file);

}


}
