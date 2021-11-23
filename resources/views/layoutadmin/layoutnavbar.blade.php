@php
    use App\tb_notifikasi;
    use App\tb_alumni;
    if(!is_null(\Illuminate\Support\Facades\Auth::user())){
        $alumnis = tb_alumni::get();
        $notifs = tb_notifikasi::where('status','Mengajukan Perbaikan')->where('flag','0')->get();
    }
@endphp

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-inline rounded-circle mr-3">
                  <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
                <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form> -->

                        
                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                  <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                  <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-search fa-fw"></i>
                    </a>
                    
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                      <form class="form-inline mr-auto w-100 navbar-search">
                        <div class="input-group">
                          <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                          <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                              <i class="fas fa-search fa-sm"></i>
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </li>         
                  

 <!-- Nav Item - Messages -->
           <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">{{$notifs->count()}}</span>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    Pemberitahuan
                </h6>
                @if ($notifs->count() == '0')
                  <a class="dropdown-item d-flex align-items-center" >
                    <div>
                        <span class="font-weight-bold " >Tidak Ada Pemberitahuan Terbaru!</span>
                    </div>
                  </a>  
                @endif

                @foreach ($notifs as $notif => $alumnis)
                <a class="dropdown-item d-flex align-items-center" href="/admin/baca-notif/{{$alumnis->notifikasi_unique}}">
                    <div class="dropdown-list-image mr-3">
                      <img class="img-profile rounded-circle"
                      @if ($alumnis->relasiNotifikasitoAlumni->foto == NULL)
                          src="{{asset('assets/admin/img/profile.png')}}"
                      @else
                       src="{{$alumnis->relasiNotifikasitoAlumni->foto}}"
                      @endif>
                        <div class="status-indicator bg-success"></div>
                    </div>
                    
                    <div>
                        <span class="font-weight-bold">Alumni Dengan Nama: {{$alumnis->relasiNotifikasitoAlumni->nama_alumni}} Mengajukan Perbaikan</span>
                        <div class="small text-gray-500">{{$alumnis->relasiNotifikasitoAlumni->updated_at->format('d-m-Y') }}</div>
                    </div>
                </a>
                @endforeach
                {{-- <a class="dropdown-item text-center small text-gray-500" href="/admin/read-notif/{{$alumnis->flag = "0"}}">Tandai Telah Dibaca</a> --}}
            </div>
        </li>

          <div class="topbar-divider d-none d-sm-block"></div>
                  <!-- Nav Item - User Information --> 
                  <li class="nav-item dropdown no-arrow">
                  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{auth()->guard()->user()->nama}}</span>
                      <img class="img-profile rounded-circle"
                          @if(auth()->guard()->user()->foto == NULL) src="{{asset('assets/admin/img/profile.png')}}"
                          @else src="{{auth()->guard()->user()->foto}}"
                          @endif>
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                      <a class="dropdown-item" href="/admin/profile">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                      </a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                      </a>
                    </div>
                  </li>

                </ul>

              </nav>
              <!-- End of Topbar -->
