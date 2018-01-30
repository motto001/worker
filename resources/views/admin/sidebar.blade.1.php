<div class="col-md-3">
<div class="panel panel-default panel-flush">
@if (Auth::user()->hasRole('admin'))             
    <div class="panel-heading">
        Admin
    </div>
    <div class="panel-body">
       <ul class="nav" role="tablist">
            <li role="workadmin">
                <a href="{{ url('/admin/conf') }}">
                   Config
                </a>
            </li>
            <li role="workadmin">
                <a href="{{ url('/admin/roles') }}">
                    Jogok
                </a>
            </li>
            <li role="workadmin">
                <a href="{{ url('/admin/users') }}">
                   Felhasználók, Jogok
                </a>
            </li>
        </ul>
    </div>
</div>
@endif
@if (Auth::user()->hasRole('manager'))  
<div class="panel panel-default panel-flush">         
    <div class="panel-heading">
        Manager
    </div>
    <div class="panel-body">
        <ul class="nav" role="tablist">
            <li role="manager">
                <a href="{{ url('/manager/users') }}">
                    Felhasználók
                </a>
            </li>
        </ul>
        <ul class="nav" role="tablist">
            <li role="manager">
                <a href="{{ url('/manager/workersfull') }}">
                   Dplgozók
                </a>
            </li>
        </ul>
        <ul class="nav" role="tablist">
            <li role="manager">
                <a href="{{ url('/manager/statuses') }}">
                    Dolgozói státusz
                </a>
            </li>
        </ul>
         <ul class="nav" role="tablist">
            <li role="manager">
                <a href="{{ url('/manager/workergroups') }}">
                    Dolgozói csoportok
                </a>
            </li>
        </ul>
         <ul class="nav" role="tablist">
            <li role="manager">
                <a href="{{ url('/manager/workertypes') }}">
                    Munka tipusok
                </a>
            </li>
        </ul>
        <ul class="nav" role="tablist">
            <li role="manager">
                <a href="{{ url('/manager/days') }}">
                    Napok
                </a>
            </li>
            <li role="manager">
                <a href="{{ url('/manager/daytypes') }}">
                    Naptipusok
                </a>
            </li>
            <li role="manager">
                <a href="{{ url('/manager/timeframes') }}">
                    Időkeretek
                </a>
            </li>
            <li role="manager">
                <a href="{{ url('/manager/timetypes') }}">
                    Munkaidőtipusok
                </a>
            </li>     
            <li role="manager">
                <a href="{{ url('/manager/wroles') }}">
                    Munkarendek
                </a>
            </li>  
            <li role="manager">
                <a href="{{ url('/manager/wroleunits') }}">
                    Munkarend ciklusok
                </a>
            </li>  
            <li role="manager">
                <a href="{{ url('/manager/wroletimes') }}">
                    Munkarend ciklusidők
                </a>
            </li>
            <li role="worker">
                <a href="{{ url('/workadmin/workerdays') }}">
                  költdég térítés
                </a>
            </li>
       </ul>
    </div>
</div>
@endif
@if (Auth::user()->hasRole('workadmin')) 
<div class="panel panel-default panel-flush">          
    <div class="panel-heading">
        Workadmin
    </div>
    <div class="panel-body">
        <ul class="nav" role="tablist">
            <li role="workadmin">
                <a href="{{ url('/workadmin/workerdays') }}">
                   Munkaidők
                </a>
            </li>
            <li role="workadmin">
                <a href="{{ url('/workadmin/') }}">
                    Szabadság, betegállomány
                </a>
            </li>
             <li role="worker">
                <a href="{{ url('/workadmin/workerdays') }}">
                   kiküldetés
                </a>
            </li>
            
            <li role="workadmin">
                <a href="{{ url('/workadmin/') }}">
                    Dolgozok
                </a>
            </li>
        </ul>
    </div>
</div>
@endif
@if (Auth::user()->hasRole('worker'))   
<div class="panel panel-default panel-flush">         
    <div class="panel-heading">
        Worker
    </div>
    <div class="panel-body">
        <ul class="nav" role="tablist">
            <li role="worker">
                <a href="{{ url('/workadmin/workerdays') }}">
                    Saját adatok
                </a>
            </li>
            <li role="worker">
                <a href="{{ url('/workadmin/workerdays') }}">
                   Szabadság, betegállomány
                </a>
            </li>
            <li role="worker">
                <a href="{{ url('/workadmin/workerdays') }}">
                   kiküldetés
                </a>
            </li>
            <li role="worker">
                <a href="{{ url('/workadmin/workerdays') }}">
                   Munkaidő nyilvántartás
                </a>
            </li>
            <li role="worker">
                <a href="{{ url('/workadmin/workerdays') }}">
                  költdég térítés
                </a>
            </li>
        </ul>
    </div>
</div>
@endif
</div>


