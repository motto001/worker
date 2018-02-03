@php
if(isset($data['param'])){$param=array_merge($param,$data['param']);}   
if(!isset($param['getT'])){ $param['getT']=[]; }
$modal= $param['modal'] ?? false ;
$header= $param['header'] ?? true;
$sidebar = $param['sidebar'] ?? true ;
@endphp

@if(!$modal) 

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Simple Responsive Admin</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="/assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="/assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="/assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
window.Laravel = <?php echo json_encode([
    'csrfToken' => csrf_token(),
]); ?>
</script>
</head>

<body>
@endif     
        
 <div id="wrapper">

@if($header)           

    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="adjust-nav">
            <div class="navbar-header">
                 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                 </button>
<!-- Moeorker script -------------------------------------- -->
@include('layouts.mo_worker_script')
<!--  /MOWorker script ----------------------------------------------------------------  -->                    
            </div>
            <span class="logout-spn" > 
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu" >
                            <li>
                                <a href="{{ url('/logout') }} " 
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>  
        </span>      
    </div> 
</div> 
@endif  
<!--header end-->

@if($sidebar)
@include('layouts.sidebar')
@endif 
@yield('content')
</div>

@if(!$modal)       
<div class="footer">
<div class="row">
    <div class="col-lg-12" >
        &copy;  2014 yourdomain.com | Design by: <a href="http://binarytheme.com" style="color:#fff;" target="_blank">www.binarytheme.com</a>
    </div>
</div>
</div>
          

  <!-- /. WRAPPER  -->
 <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
 <!-- JQUERY SCRIPTS -->
 <script src="/assets/js/jquery-1.10.2.js"></script>
   <!-- BOOTSTRAP SCRIPTS -->
 <script src="/assets/js/bootstrap.min.js"></script>
   <!-- CUSTOM SCRIPTS -->
 <script src="/assets/js/custom.js"></script>

</body>
</html>
@endif 