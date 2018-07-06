<aside>
    <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
              
            <p class="centered"><a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/users' ? 'active' : '' }}" href="profile.html"><img src="/assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
            <h5 class="centered">{{ Auth::user()->name }} </h5>
            
   
          <!--      <ul class="sub">
                    <li><a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/users' ? 'active' : '' }}"  href="general.html">General</a></li>
                    <li><a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/users' ? 'active' : '' }}"  href="buttons.html">Buttons</a></li>
                    <li><a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/users' ? 'active' : '' }}"  href="panels.html">Panels</a></li>
                </ul> -->
            </li>
                        
 <!-- si**************************************************** -->

@if (Auth::user()->hasRole('admin'))             
 
   <li class="mt" style="margin:0px;"style="margin:0px 0px  5px 0px;">
                <a style="padding:10px;font-size:16px;" class="active" href="#">
                    <i class="fa fa-dashboard"></i>
                    <span style="color:red;font-size:18px;">Admin</span>
                </a>
   </li>
            <li class="sub-menu">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'root/proba' ? 'active' : '' }}" href="{{ url('/root/proba') }}">
                  <span> proba</span>
                </a>
            </li>
            <li class="sub-menu">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'root/conf' ? 'active' : '' }}" href="{{ url('/root/conf') }}">
                  <span> Config</span>
                </a>
            </li>
            <li class="sub-menu">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'root/roles' ? 'active' : '' }}" href="{{ url('/root/roles') }}">
                    Jogok
                </a>
            </li>
   
    
@endif
@if (Auth::user()->hasRole('manager'))  
         
   <li class="mt" style="margin:0px;"style="margin:0px 0px  5px 0px;">
                <a style="padding:10px;font-size:16px;"  class="active" href="#">
                    <i class="fa fa-dashboard"></i>
                    <span style="color:red;font-size:18px;">Manager</span>
                </a>
   </li>
    
            <li class="mt " style="margin:0px;" >
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/users' ? 'active' : '' }}"  href="{{ url('/manager/users') }}">
                    Felhasználók
                </a>
            </li>
        
       
            <li class="mt " style="margin:0px;" >
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/workers' ? 'active' : '' }}"  href="{{ url('/manager/workers') }}">
                   Dplgozók
                </a>
            </li>
        
       
            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/statuses' ? 'active' : '' }}" href="{{ url('/manager/statuses') }}">
                    Dolgozói státusz
                </a>
            </li>
        
        
            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/workergroups' ? 'active' : '' }}" href="{{ url('/manager/workergroups') }}">
                    Dolgozói csoportok
                </a>
            </li>
        
        
            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/workertypes' ? 'active' : '' }}" href="{{ url('/manager/workertypes') }}">
                    Munka tipusok
                </a>
            </li>
     
            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/days' ? 'active' : '' }}" href="{{ url('/manager/days') }}">
                    Napok
                </a>
            </li>  
         <!--    
            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/userdays' ? 'active' : '' }}" href="{{ url('/manager/userdays') }}">
                   Dolgozói napok
                </a>
            </li>
         -->    
            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/daytypes' ? 'active' : '' }}" href="{{ url('/manager/daytypes') }}">
                    Naptipusok
                </a>
            </li>
            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/timeframes' ? 'active' : '' }}" href="{{ url('/manager/timeframes') }}">
                    Időkeretek
                </a>
            </li>
            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/timetypes' ? 'active' : '' }}" href="{{ url('/manager/timetypes') }}">
                    Munkaidőtipusok
                </a>
            </li>     
            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/wroles' ? 'active' : '' }}" href="{{ url('/manager/wroles') }}">
                    Munkarendek
                </a>
            </li>  
            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/wroleunits' ? 'active' : '' }}" href="{{ url('/manager/wroleunits') }}">
                    Műszakok
                </a>
            </li>  
            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/wroletimes' ? 'active' : '' }}" href="{{ url('/manager/wroletimes') }}">
                    Műszak idők
                </a>
            </li>
           <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/workerdays' ? 'active' : '' }}" href="{{ url('/workadmin/workerdays') }}">
                  költdég térítés
                </a>
            </li>
      
    

@endif
@if (Auth::user()->hasRole('workadmin')) 
       
    <li class="mt" style="margin:0px;"style="margin:0px 0px  5px 0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/users' ? 'active' : '' }}" class="active" href="#">
                    <i class="fa fa-dashboard"></i>
                    <span style="color:red;font-size:18px;">Workadmin</span>
                </a>
   </li>
   <li class="mt" style="margin:0px;">
    <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'workadmin/workerwroles ' ? 'active' : '' }}" class="active" href="{{ url('/workadmin/workerwroles ') }}">
       Dolgozói munkarendek
    </a>
</li>
    <li class="mt" style="margin:0px;">
    <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'workadmin/workertimeframes ' ? 'active' : '' }}" class="active" href="{{ url('/workadmin/workertimeframes ') }}">
       Dolgozói időkeretek
    </a>
</li>     

            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'workadmin//workerwroleunit' ? 'active' : '' }}" href="{{ url('/workadmin/workerwroleunit') }}">
                  Dolgpzói műszakok
                </a>
            </li>

            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'workadmin/workerdays' ? 'active' : '' }}" href="{{ url('/workadmin/workerdays') }}">
                   Napok
                </a>
            </li>
            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'workadmin/workertimes' ? 'active' : '' }}" href="{{ url('/workadmin/workertimes') }}">
                   Munkaidők
                </a>
            </li>
            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'workadmin/workertimeswish' ? 'active' : '' }}" href="{{ url('/workadmin/workertimeswish') }}">
                   Munkaidő kérelmek
                </a>
            </li>
            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/users' ? 'active' : '' }}" href="{{ url('/workadmin/') }}">
                    Szabadság, betegállomány
                </a>
            </li>
             <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/users' ? 'active' : '' }}" href="{{ url('/workadmin/workerdays') }}">
                   kiküldetés
                </a>
            </li>
            
            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/users' ? 'active' : '' }}" href="{{ url('/workadmin/') }}">
                    Dolgozok
                </a>
            </li>
        

@endif
@if (Auth::user()->hasRole('worker'))   
         
   <li class="mt" style="margin:0px;"style="margin:0px 0px  5px 0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/users' ? 'active' : '' }}" class="active" href="#">
                    <i class="fa fa-dashboard"></i>
                    <span style="color:red;font-size:18px;">Dolgozó</span>
                </a>
   </li>
   <li class="mt" style="margin:0px;">
    <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'worker/workertimeswish' ? 'active' : '' }}" href="{{ url('/worker/workertimeswish') }}">
       Munkaidők
    </a>
</li>
<li class="mt" style="margin:0px;">
    <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'worker/workerwroleunits' ? 'active' : '' }}" href="{{ url('/worker/workerwroleunits') }}">
       Műszakcsere
    </a>
</li>      
           <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'worker/users' ? 'active' : '' }}" href="{{ url('/worker/workerdays') }}">
                    Saját adatok
                </a>
            </li>
            <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'worker/workerdays' ? 'active' : '' }}" href="{{ url('/worker/workerdays') }}">
                    Naptár
                </a>
            </li>

           <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'worker/users' ? 'active' : '' }}" href="{{ url('/worker/workerdays') }}">
                   Szabadság, betegállomány
                </a>
            </li>
           <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/users' ? 'active' : '' }}" href="{{ url('/workadmin/workerdays') }}">
                   kiküldetés
                </a>
            </li>
           <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/users' ? 'active' : '' }}" href="{{ url('/workadmin/workerdays') }}">
                   Munkaidő nyilvántartás
                </a>
            </li>
           <li class="mt" style="margin:0px;">
                <a style="padding:10px;font-size:16px;" class="{{ Request::path() == 'manager/users' ? 'active' : '' }}" href="{{ url('/workadmin/workerdays') }}">
                  költdég térítés
                </a>
            </li>
     

@endif

 <!-- si------- -->
    </ul>
              <!-- sidebar menu end-->
</div>
</aside>
