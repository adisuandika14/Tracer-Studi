@extends('layoutadmin.layout')
@section('title', 'Periode Lulusan Alumni')
@section('collapse5')
    collapse-item active
@endsection

@section('active2')
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


    @if (count($errors)>0)
    <div class="row">
      <div class="col-sm-12 alert alert-danger alert-dismissible fade show" role="alert">
          <ul>
            @foreach ($errors->all() as $item)
                <li>{{$item}}</li>
            @endforeach
          </ul>
          <button type="button" class="close" data-dismiss="alert"
              aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
    </div>
  @endif

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
              <h6 class="m-0 font-weight-bold text-primary">Data Periode Lulusan Alumni</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#create"><i
                            class="fas fa-plus"></i> Tambah Periode Lulus
                    </button>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width: fit-content;">No.</th>
                      <th style="text-align:center;">Tahun Lulus </th>
                      <th style="text-align:center;">Periode </th>
                      <th style="text-align:center;">Status </th>
                      <th style="text-align:center;">Data Alumni </th>                      
                      <th style="text-align:center;">Aksi</th>

                      
                    </tr>
                  </thead>

                  <tbody>
                        @foreach ($periodealumni as $periodes => $status)
                            <tr class="success">
                             
                                <td style="width: fit-content;">{{ $loop->iteration }}</td>
                                <td>{{ $status->relasiPeriodealumnitoTahun->tahun_periode }}</td>
                                <td>{{ $status->relasiPeriodealumnitoPeriode->periode }}</td>
                                <td style="width: fit-content;" class="text-center">
                                    <label class="switch"  >
                                        @if($status->status == "Aktif")
                                          <input type="checkbox" id="status_{{$status->id_periode_alumni}}" onclick="statusBtn({{$status->id_periode_alumni}})" checked>
                                        @else
                                          <input type="checkbox" id="status_{{$status->id_periode_alumni}}" onclick="statusBtn({{$status->id_periode_alumni}})">
                                        @endif
                                      <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <a href="/admin/alumni/{{$status->id_periode_alumni}}">
                                        <button type="button" class="btn btn-primary btn-sm text-center"><i class="fas fa-eye">Lihat Data Alumni</i></button></a>
                                </td>
                                <td class="text-center">
                                    {{-- <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#show{{$status->id_periode_alumni}}"><i class="fas fa-eye"></i>
                                    </button> --}}
                                    <!-- Edit -->
                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#update{{$status->id_periode_alumni}}"><i class="fas fa-edit"></i>
                                    </button>
                                    <!--Delete -->
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{$status->id_periode_alumni}}"><i class="fas fa-trash"></i>
                                    </button>
                                </td>
                               
                            </tr>
                        @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          @foreach($periodealumni as $datass)
        <!-- Modal Show -->
        <div class="modal fade"  id="show{{$datass->id_periode_alumni}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                        <div class="modal-dialog"  role="document" >
                            <div class="modal-content" >
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Periode Lulusan Alumni</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table width="100%" cellspacing="30">
                                        <td>
                                        <input type="hidden" name="id_lab" value="{{$datass->id_periode_alumni}}">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Tahun</label>
                                            <input type="text" class="form-control" id="periode" name="periode"
                                                value="{{$datass->relasiPeriodealumnitoTahun->tahun_periode}}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Periode</label>
                                            <input type="text" class="form-control" id="periode" name="periode"
                                                value="{{$datass->relasiPeriodealumnitoPeriode->periode}}" readonly>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Delete -->
                    <div class="modal fade" id="delete{{$datass->id_periode_alumni}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <a href="/admin/periodealumni/{{$datass->id_periode_alumni}}/delete"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Ya</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Delete -->

                    <!-- //Update -->
                    <div class="modal fade" id="update{{$datass->id_periode_alumni}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Periode Lulusan Alumni</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                  <form action="/admin/periodealumni/updateperiode" method="POST" enctype="multipart/form-data">
                                  <input type="hidden" name="id_periode_alumni" value="{{$datass->id_periode_alumni}}">
                                    {{ csrf_field() }}
                                        
                                    

                                    <div class="form-group">
                                        <label for="id_tahun_periode" class="font-weight-bold text-dark">Tahun</label>
                                            <select name="id_tahun_periode" id="id_tahun_periode" class="custom-select" required>
                                                <option>-- Pilih Tahun --</option>
                                                @foreach($tahun as $tahuns)
                                                <option value="{{$tahuns->id_periode_alumni}}" @if($datass->id_tahun_periode==$tahuns->id_tahun_periode) selected @endif>{{$tahuns->tahun_periode}}</option>
                                                @endforeach
                                            </select>
                                      </div>
                
                                      <div class="form-group">
                                        <label for="id_periode" class="font-weight-bold text-dark">Periode</label>
                                            <select name="id_periode" id="id_periode" class="custom-select" required>
                                                <option>-- Pilih Periode --</option>
                                                @foreach($periode as $periodes)
                                                <option value="{{$periodes->id_periode}}" @if($periodes->id_periode==$periodes->id_periode) selected @endif>{{$periodes->periode}}</option>
                                                @endforeach
                                            </select>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Periode Lulusan Alumni</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/admin/periodealumni/createperiode" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                    <label class="font-weight-bold text-dark">Pilih Periode Alumni</label>
                    
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
                                @foreach($periode as $periodes)
                                <option value="{{$periodes->id_periode}}">{{$periodes->periode}}</option>
                                @endforeach
                            </select>
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
          title: 'Anda yakin ingin mengaktifkan kuesioner ini?',
          icon: 'warning',
          buttons: ["Tidak", "Ya"],
      }).then(function(value) { 
          if (value) {
            jQuery.ajax({  
              url: "/admin/periodealumni/"+id+"/Aktif",
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
          title: 'Anda yakin ingin menonaktifkan kuesioner ini?',
          icon: 'warning',
          buttons: ["Tidak", "Ya"],
      }).then(function(value) {
          if (value) {
            jQuery.ajax({
              url: "/admin/periodealumni/"+id+"/Tidak Aktif",
              type: "GET",
              success: function(result){
              }
          });
        }else{  
          document.getElementById("status_"+id_peruide_alumni).checked = true;
        }
      });
    }

  }
  $('#sidebarPengumuman').addClass("active");

</script>


@endsection
