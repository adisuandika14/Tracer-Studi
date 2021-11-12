<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard">
    <div class="sidebar-brand-icon rotate-n-15">
        <!-- <i class="fas fa-laugh-wink"></i> -->
    </div>
    <div class="sidebar-brand-text mx-3">Tracer Study <sup></sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<div class="nav-item">
    <li class="@yield('active1')">
        <a class="nav-link" href="/admin/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
</div>

<!-- Divider -->
<hr class="sidebar-divider">

{{-- <!-- Heading -->
<div class="sidebar-heading">
    Data Tracer
</div> --}}

<!-- Nav Item - Pages Collapse Menu -->
<div class="nav-item ">
    <li  class="@yield('active2')">
        <a class="nav-link" href="/admin/periodealumni">
            <i class="fas fa-fw fa-users"></i>
            <span>Alumni</span></a>
    </li>
</div>

<!-- Nav Item - Pages Collapse Menu -->
<div class="nav-item">
    <li class="@yield('active3')">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKuesioner"
            aria-expanded="true" aria-controls="collapseKuesioner">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Kuesioner</span>
        </a>
        <div id="collapseKuesioner" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- //<h6 class="collapse-header">Login Screens:</h6> -->
                <div class="collapse-item">
                    <a class="@yield('collapse1')" href="/admin/periodekuesioner">Kuesioner Alumni</a>
                </div>
                <div class="collapse-item">
                    <a class="@yield('collapse2')" href="/admin/kuesioner/stakeholder">Kuesioner Stakeholder</a>
                </div>
            </div>
        </div>
    </li>
</div>


<!-- Nav Item - Pages Collapse Menu -->
<div class="nav-item">
    <li class="@yield('active10')">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsebank"
            aria-expanded="true" aria-controls="collapsebank">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Bank Soal</span>
        </a>
        <div id="collapsebank" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- //<h6 class="collapse-header">Login Screens:</h6> -->
                <div class="collapse-item">
                    <a class="@yield('collapse3')" href="/admin/banksoal/alumni">Bank Soal Alumni</a>
                </div>
                <div class="collapse-item">
                    <a class="@yield('collapse4')" href="/admin/banksoal/stakeholder">Bank Soal Stakeholder</a>
                </div>
            </div>
        </div>
    </li>
</div>

{{-- <div class="nav-item">
    <li class="@yield('active9')">
        <a class="nav-link" href="/admin/periodekuesioner">
            <i class="fas fa-fw fa-users"></i>
            <span>Periode Kuesioner</span></a>
    </li>
</div> --}}

{{-- <div class="nav-item">
    <li class="@yield('active8')">
        <a class="nav-link" href="/admin/tracer">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Tracer</span></a>
    </li>
</div> --}}

<!-- Nav Item - Pages Collapse Menu -->
<div class="nav-item">
    <li class="@yield('active11')">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsereport"
            aria-expanded="true" aria-controls="collapsereport">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Report</span>
        </a>
        <div id="collapsereport" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- //<h6 class="collapse-header">Login Screens:</h6> -->
                <div class="collapse-item">
                    <a class="@yield('collapse5')" href="/admin/reportalumni">Report Alumni</a>
                </div>
                <div class="collapse-item">
                    <a class="@yield('collapse6')" href="/admin/reportstakeholder">Report Stakeholder</a>
                </div>
            </div>
        </div>
    </li>
</div>

<div class="nav-item">
    <li class="@yield('active4')">
        <a class="nav-link" href="/admin/pengumuman">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Pengumuman</span>
        </a>
    </li> 
</div>

<div class="nav-item">
    <li class="@yield('active5')">
        <a class="nav-link" href="/admin/lowongan">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Lowongan</span></a>
    </li>
</div>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Master Data
</div>

<!-- Nav Item - Pages Collapse Menu -->
<div class="nav-item">
    <li class="@yield('active6')">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Master Data</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- //<h6 class="collapse-header">Login Screens:</h6> -->
                <div class="collapse-item">
                    <a class="@yield('collapse1')" href="/admin/angkatan">Angkatan</a>
                </div>
                <div class="collapse-item">
                    <a class="@yield('collapse2')" href="/admin/prodi">Program Studi</a>
                </div>
                <div class="collapse-item">
                    <a class="@yield('collapse3')" href="/admin/periode">Periode</a>
                </div>
                <div class="collapse-item">
                    <a class="@yield('collapse4')" href="/admin/mastertahun">Periode Tahun</a>
                </div>
                <!-- <div class="collapse-item">
                    <a class="@yield('collapse3')" href="/admin/pertanyaan">Pertanyaan</a>
                </div> -->


            </div>
        </div>
    </li>
</div>


<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>                                                                      

</ul>