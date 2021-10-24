@extends('layoutadmin.layout')
@section('title', 'Periode Kuesioners')
@section('active3')
      nav-item active
@endsection

<style>
    /* The switch - the box around the slider */
    .switch {
     position: relative;
     display: inline-block;
     width: 60px;
     height: 34px;
   }
   
   /* Hide default HTML checkbox */
   .switch input {
     opacity: 0;
     width: 0;
     height: 0;
   }
   
   /* The slider */
   .slider {
     position: absolute;
     cursor: pointer;
     top: 0;
     left: 0;
     right: 0;
     bottom: 0;
     background-color: #ccc;
     -webkit-transition: .4s;
     transition: .4s;
   }
   
   .slider:before {
     position: absolute;
     content: "";
     height: 26px;
     width: 26px;
     left: 4px;
     bottom: 4px;
     background-color: white;
     -webkit-transition: .4s;
     transition: .4s;
   }
   
   input:checked + .slider {
     background-color: #2196F3;
   }
   
   input:focus + .slider {
     box-shadow: 0 0 1px #2196F3;
   }
   
   input:checked + .slider:before {
     -webkit-transform: translateX(26px);
     -ms-transform: translateX(26px);
     transform: translateX(26px);
   }
   
   /* Rounded sliders */
   .slider.round {
     border-radius: 34px;
   }
   
   .slider.round:before {
     border-radius: 50%;
   } 
   </style>

@section('content')
<div class="container">    
    <!-- {{-- notifikasi form validasi --}} -->
    @if ($errors->has('file'))
    <span class="invalid-feedback" role="alert">
      <strong>{{ $errors->first('file') }}</strong>
    </span>
    @endif
  
    <!-- {{-- notifikasi sukses --}} -->
    @if ($sukses = Session::get('sukses'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button> 
      <strong>{{ $sukses }}</strong>
    </div>
    @endif
  </div>

    <!-- Begin Page Content -->
    <div class="container-fluid">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar Periode Kuesioner</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#create"><i
                            class="fas fa-plus"></i> Tambah Tahun Periode
                    </button>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width: fit-content;">No.</th>
                      <th style="text-align:center;">Tahun </th>
                      <th style="text-align:center;">Periode </th>
                      <th style="text-align:center;">Tanggal Mulai </th>
                      <th style="text-align:center;">Tanggal Selesai </th>
                      <th style="text-align:center;">Status </th>
                      <th style="text-align:center;">Data Kuesioner</th>
                      <th style="text-align:center;">Aksi</th>
                    </tr>
                  </thead>

                  <tbody>
                        @foreach ($periode as $periodes => $status)
                            <tr class="success">
                                <td style="width: fit-content;">{{ $loop->iteration }}</td>
                                <td>{{ $status->relasiPeriodekuesionertoTahun->tahun_periode }}</td>
                                <td>{{ $status->relasiPeriodekuesionertoPeriode->periode }}</td>
                                <td style="width: fit-content;">{{ $status->tanggal_mulai }}</td>
                                <td style="width: fit-content;">{{ $status->tanggal_selesai }}</td>
                                <td style="width: fit-content;" class="text-center">
                                    <label class="switch"  >
                                        @if($status->status == "Aktif")
                                          <input type="checkbox" id="status_{{$status->id_periode_kuesioner}}" onclick="statusBtn({{$status->id_periode_kuesioner}})" checked>
                                        @else
                                          <input type="checkbox" id="status_{{$status->id_periode_kuesioner}}" onclick="statusBtn({{$status->id_periode_kuesioner}})">
                                        @endif
                                      <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <a href="/admin/kuesioner/{{$status->id_periode_kuesioner}}">
                                        <button type="button" class="btn btn-primary btn-sm text-center"><i class="fas fa-eye">Lihat Data Kuesioner</i></button></a>
                                </td>
                                <td class="text-center">
                                    {{-- <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#show{{$status->id_periode_kuesioner}}"><i class="fas fa-eye"></i>
                                    </button> --}}
                                    <!-- Edit -->
                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#update{{$status->id_periode_kuesioner}}"><i class="fas fa-edit"></i>
                                    </button>
                                    <!--Delete -->
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{$status->id_periode_kuesioner}}"><i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          @foreach($periode as $datass)
        <!-- Modal Show -->
        <div class="modal fade"  id="show{{$datass->id_tahun_periode}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                        <div class="modal-dialog"  role="document" >
                            <div class="modal-content" >
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"> Data periode</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table width="100%" cellspacing="30">
                                        <td>
                                        <input type="hidden" name="id_lab" value="{{$datass->id_tahun_periode}}">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Tahun periode</label>
                                            <input type="text" class="form-control" id="periode" name="periode"
                                                value="{{$datass->periode}}" readonly>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Delete -->
                    <div class="modal fade" id="delete{{$datass->id_periode_kuesioner}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Hapus Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin menghapus data Periode?</b>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                                    <a href="/admin/periodekuesioner/{{$datass->id_periode_kuesioner}}/delete"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Ya</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Delete -->

                    <!-- //Update -->
                    <div class="modal fade" id="update{{$datass->id_periode_kuesioner}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Tahun Periode</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                  <form action="/admin/periodekuesioner/update" method="POST" enctype="multipart/form-data">
                                  <input type="hidden" name="id_periode_kuesioner" value="{{$datass->id_periode_kuesioner}}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="id_tahun_periode" class="font-weight-bold text-dark">Tahun</label>
                                            <select name="id_tahun_periode" id="id_tahun_periode" class="custom-select" required>
                                                <option>-- Pilih Tahun --</option>
                                                @foreach($tahun as $tahuns)
                                                <option value="{{$tahuns->id_tahun_periode}}" @if($datass->id_tahun_periode==$tahuns->id_tahun_periode) selected @endif>{{$tahuns->tahun_periode}}</option>
                                                @endforeach
                                            </select>
                                      </div>
                
                                      <div class="form-group">
                                        <label for="id_periode" class="font-weight-bold text-dark">Periode</label>
                                            <select name="id_periode" id="id_periode" class="custom-select" required>
                                                <option>-- Pilih Periode --</option>
                                                @foreach($periodekuesioner as $periode)
                                                <option value="{{$periode->id_periode}}" @if($datass->id_periode==$periode->id_periode) selected @endif>{{$periode->periode}}</option>
                                                @endforeach
                                            </select>
                                      </div>

                                      <div class="form-group">
                                        <label class="font-weight-bold text-dark">Tanggal Mulai</label>
                                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{$datass->tanggal_mulai}}" placeholder="">
                                      </div>
                                      <div class="form-group">
                                        <label class="font-weight-bold text-dark">Tanggal Selesai</label>
                                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{$datass->tanggal_selesai}}"  placeholder="">
                                      </div> 

	      	            <div class="modal-footer">
		                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		                      <button type="submit" class="btn btn-success">Simpan</button>
		                  </div>
                      </form>
                                </div>
                            </div>
                        </div>
                    </div>
        @endforeach

    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Periode Kuesioner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/admin/periodekuesioner/create" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                    <label class="font-weight-bold text-dark">Pilih Periode Kuesioner</label>
                    
                    <div class="form-group">
                        <label for="id_tahun_periode" class="font-weight-bold text-dark">Tahun</label>
                            <select name="id_tahun_periode" id="id_tahun_periode" class="custom-select" required>
                                <option>-- Pilih Tahun --</option>
                                @foreach($tahun as $tahuns)
                                <option value="{{$tahuns->id_tahun_periode}}">{{$tahuns->tahun_periode}}</option>
                                @endforeach
                            </select>
                      </div>

                      <div class="form-group">
                        <label for="id_periode" class="font-weight-bold text-dark">Periode</label>
                            <select name="id_periode" id="id_periode" class="custom-select" required>
                                <option>-- Pilih Periode --</option>
                                @foreach($periodekuesioner as $periode)
                                <option value="{{$periode->id_periode}}">{{$periode->periode}}</option>
                                @endforeach
                            </select>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" placeholder="">
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" placeholder="">
                      </div>  

                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            </div>
    </div>

@endsection

@section('custom_javascript')
<script>
//Switch Status Pengumuman
  function statusBtn(id) {
    var checkBox = document.getElementById("status_"+id);
    // If the checkbox is checked, display the output text

    if (checkBox.checked == true){
      swal({
          title: 'Anda yakin ingin menerima kuesioner ini?',
          icon: 'warning',
          buttons: ["Tidak", "Ya"],
      }).then(function(value) { 
          if (value) {
            jQuery.ajax({  
              url: "/admin/periodekuesioner/"+id+"/Aktif",
              type: "GET",
              success: function(result){
              }
          });
        }else{
          document.getElementById("status_"+id).checked = false;
        }
      });
    } else {
      swal({
          title: 'Anda yakin ingin menolak kuesioner ini?',
          icon: 'warning',
          buttons: ["Tidak", "Ya"],
      }).then(function(value) {
          if (value) {
            jQuery.ajax({
              url: "/admin/periodekuesioner/"+id+"/Tidak Aktif",
              type: "GET",
              success: function(result){
              }
          });
        }else{  
          document.getElementById("status_"+id_periode_kuesioner).checked = true;
        }
      });
    }

  }
  $('#sidebarPengumuman').addClass("active");

</script>


@endsection
