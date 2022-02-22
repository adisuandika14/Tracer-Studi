@extends('layoutadmin.layout')
@section('title', 'Master Tahun')
@section('collapse2')
    collapse-item active
@endsection

@section('active6')
      nav-item active
@endsection

@section('content')
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
    @if ($errors->has('file') && $error->any)
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

        <!-- {{-- notifikasi gagal --}} -->
        @if ($error = Session::get('error'))
        <div class="alert alert-danger alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button> 
          <strong>{{ $error }}</strong>
        </div>
        @endif
      </div>
  

    <!-- Begin Page Content -->
    <div class="container-fluid">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar Tahun</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#create"><i
                            class="fas fa-plus"></i> Tambah Data Tahun
                    </button>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width: fit-content;">No.</th>
                      <th style="text-align:center;">Daftar Tahun</th>
                      <th style="text-align:center;">Aksi</th>
                    </tr>
                  </thead>

                  <tbody>
                        @foreach ($periode as $periodes)
                            <tr class="success">
                                <td style="width: 3@">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $periodes->tahun_periode }}</td>
                                <td class="text-center">
                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#show{{$periodes->id_tahun_periode}}"><i class="fas fa-eye"></i>
                                    </button>
                                    <!-- Edit -->
                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#update{{$periodes->id_tahun_periode}}"><i class="fas fa-edit"></i>
                                    </button>
                                    <!--Delete -->
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{$periodes->id_tahun_periode}}"><i class="fas fa-trash"></i>
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
                                    <h5 class="modal-title" id="exampleModalLabel"> Data prodi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table width="100%" cellspacing="30">
                                        <td>
                                        <input type="hidden" name="id_lab" value="{{$datass->id_tahun_periode}}">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Tahun</label>
                                            <input type="text" class="form-control" id="tahun_periode" name="tahun_periode"
                                                value="{{$datass->tahun_periode}}" readonly>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Delete -->
                    <div class="modal fade" id="delete{{$datass->id_tahun_periode}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Hapus Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin menghapus data Tahun?</b>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                                    <a href="/admin/mastertahun/{{$datass->id_tahun_periode}}/delete"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Ya</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Delete -->

                    <!-- //Update -->
                    <div class="modal fade" id="update{{$datass->id_tahun_periode}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Tahun</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                  <form action="/admin/mastertahun/update" method="POST" enctype="multipart/form-data">
                                  <input type="hidden" name="id_tahun_periode" value="{{$datass->id_tahun_periode}}">
                                    {{ csrf_field() }}
                                        
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Tahun</label>
                                    <input type="text" class="form-control" id="tahun_periode" name="tahun_periode" value="{{$datass->tahun_periode}}" required placeholder="">
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
	                  <h5 class="modal-title" id="exampleModalLabel">Masukkan Tahun</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                      <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <div class="modal-body">
	      	          <form action="/admin/mastertahun/create" method="POST">
                      {{csrf_field()}}
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Tahun</label>
                        <input type="text" class="form-control" id="tahun_periode" name="tahun_periode" placeholder="">
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
