<div class="col-md-3">

 
            <div class="panel panel-default panel-flush">
                <div class="panel-heading">
                  Menü
                </div>

                <div class="panel-body">
                    <ul class="nav" role="tablist">
 @if (Auth::user()->hasRole('workadmin'))                 
                    
 <li role="workadmin">
                                <a href="{{ url('/workadmin/workerdays') }}">
                                    Munkaidő
                                </a>
                            </li>






                            
@elseif(Auth::user()->hasRole('worker'))
<li role="admin">
                                <a href="{{ url('/user/personal') }}">
                                   Személyes adatok
                                </a>
                            </li>

                             <li role="admin">
                                <a href="{{ url('/user/worktime') }}">
                                   Munkaidő
                                </a>
                            </li>

 @endif
 @if (Auth::user()->hasRole('manager'))  
                            <li role="manager">
                                <a href="{{ url('/manager/workerusers') }}">
                                    Dolgozok
                                </a>
                            </li>
                              <li role="manager">
                                <a href="{{ url('/manager/users') }}">
                                    Felhasználók
                                </a>
                            </li>
 </li>
                              <li role="manager">
                                <a href="{{ url('/manager/status') }}">
                                    Dolgozói státusz
                                </a>
                            </li>

 </li>
                              <li role="manager">
                                <a href="{{ url('/manager/workertype') }}">
                                    Dolgozói csoportok
                                </a>
                            </li>
 </li>
                              <li role="manager">
                                <a href="{{ url('/manager/users') }}">
                                    Felhasználók
                                </a>
                            </li>
                            

@elseif (Auth::user()->hasRole('workadmin'))
                        <li role="manager">
                                <a href="{{ url('/workadmin/workers') }}">
                                    Dolgozok
                                </a>
                            </li>

 @endif
 @if (Auth::user()->hasRole('workadmin'))  
                           
                            <li role="manager">
                                <a href="{{ url('/workadmin/days') }}">
                                    Napok
                                </a>
                            </li>
                     
                         
 @endif




 @if (Auth::user()->hasRole('admin'))                     
                            <li role="root">
                                <a href="{{ url('/admin/roles') }}">
                                    Jogok
                                </a>
                            </li>
                            <li role="root">
                                <a href="{{ url('/admin/permissions') }}">
                                    Szabályok
                                </a>
                            </li>
                            <li role="root">
                                <a href="{{ url('/admin/give-role-permissions') }}">
                                   Give role-permissions
                                </a>
                            </li>
                            <li role="root">
                                <a href="{{ url('/admin/conf') }}">
                                  Config
                                </a>
                            </li>

 @endif
         
           <li role="user">
                                <a href="{{ url('/user/chpassword') }}">
                                   Password
                                </a>
                            </li>              

                    </ul>
                </div>
            </div>


       @if (Auth::user()->hasRole('admin'))  
            <div class="panel panel-default panel-flush">
                <div class="panel-heading">
                    Tools
                </div>

                <div class="panel-body">
                    <ul class="nav" role="tablist">
                      
                            <li role="admin">
                                <a href="{{ url('/admin/generator') }}">
                                    Generator
                                </a>
                            </li>
                        
                    </ul>
                </div>
            </div>
        @endif

</div>

