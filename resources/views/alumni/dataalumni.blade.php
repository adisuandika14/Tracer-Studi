@extends('layoutadmin.layout')
@section('title', 'Data Alumni')
@section('content')
@section('collapse5')
    collapse-item active
@endsection

@section('active2')
      nav-item active
@endsection

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
</div>



    <!-- Begin Page Content -->
    <div class="container-fluid">
          <div class="card shadow mb-4">
            
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar Alumni Periode - {{$tahun_lulus}}</h6>
            </div>
         
            <div class="card-body">
              <div class="table-responsive">
                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#create"><i
                            class="fas fa-plus"></i> Tambah Data Alumni
                </button>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importExcel">
                <i
                  class="fas fa-upload fa-sm text-white-50"></i>Import Excel
                </button>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width: fit-content;">No.</th>
                      <th style="text-align:center;">Nama Dengan Gelar</th>
                      <th style="text-align:center;">Nik</th>
                      <th style="text-align:center;">Nim</th>
                      <th style="text-align:center;">Jenis Kelamin</th>
                      <th style="text-align:center;">Alamat</th>
                      <th style="text-align:center;">Program Studi</th>
                      <th style="text-align:center;">Angkatan</th>
                      <th style="text-align:center;">Tahun Lulus</th>
                      <th style="text-align:center;">Tahun Wisuda</th>
                      <th style="text-align:center;">Status</th>
                      <th style="text-align:center;">Aksi</th>
                    </tr>
                  </thead>

                  <tbody>
                        @foreach ($alumni as $i => $status)
                            <tr class="success">
                                <td style="width: fit-content;">{{ $loop->iteration }}</td>
                                <td>{{ $status->nama_alumni }}</td>
                                <td>{{ $status->nik }}</td>
                                <td>{{ $status->nim_alumni}}</td>
                                <td>{{ $status->jenis_kelamin}}</td>
                                <td>{{ $status->alamat_alumni}}</td>
                                <td>{{ $status->relasiAlumnitoProdi->nama_prodi}}</td>
                                <td>{{ $status->relasiAlumnitoAngkatan->tahun_angkatan}}</td>
                                <td>{{ $status->tahun_lulus }}</td>
                                <td>{{ $status->tahun_wisuda }}</td>
                                <td>
                                      @if($status->status == "Menunggu Konfirmasi")
                                      <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#validasi{{$status->id_alumni}}"> Menunggu Konfirmasi
                                      </button>
                                      @endif
                                      @if($status->status == "Konfirmasi")
                                      <button class="btn btn-success btn-sm" data-toggle="modal"
                                            data-target="#validasi{{$status->id_alumni}}"> Dikonfirmasi
                                      </button>
                                      @endif
                                      @if($status->status == "Ditolak")
                                      <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#validasi{{$status->id_alumni}}"> Ditolak
                                      </button>
                                      @endif
                                      @if($status->status == "Mengajukan Perbaikan")
                                      <button class="btn btn-secondary btn-sm" data-toggle="modal"
                                            data-target="#validasi{{$status->id_alumni}}"> Mengajukan Perbaikan
                                      </button>
                                      @endif
                                </td>
                                  
                                <td style="width: 10%;">
                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#show{{$status->id_alumni}}"><i class="fas fa-eye"></i>
                                    </button>
                                    <!-- Edit -->
                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#update{{$status->id_alumni}}"><i class="fas fa-edit"></i>
                                    </button>
                                    <!--Delete -->
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{$status->id_alumni}}"><i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
    </div>


		<!-- Import Excel -->
		<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form method="post" action="/admin/alumni/import_excel" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
						</div>
						<div class="modal-body">
							{{ csrf_field() }}
              <input type="text" class="form-control" id="" value="{{$id_periode_alumni}}" name="id_periode" placeholder="" hidden>
							<label>Pilih file excel</label>
							<div class="form-group">
								<input type="file" name="file" required="required">
							</div>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Import</button>
						</div>
					</div>
				</form>
			</div>
		</div>


          @foreach($alumni as $datass)
        <!-- Modal Show -->
        <div class="modal fade"  id="show{{$datass->id_alumni}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                        <div class="modal-dialog"  role="document" >
                            <div class="modal-content" >
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"> Data Alumni</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                
                                  
                                    {{ csrf_field() }}
                                    <table width="100%" cellspacing="30">
                                        <td>
                                        <input type="hidden" name="id_lab" value="{{$datass->id_alumni}}">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Nama Dengan Gelar</label>
                                            <input type="text" class="form-control" id="nama_alumni" name="nama_alumni"
                                                value="{{$datass->nama_alumni}}" readonly>
                                        </div>
                                        <div class="form-group">
                                          <label class="font-weight-bold text-dark">NIK</label>
                                          <input type="text" class="form-control" id="nik" name="nik"
                                              value="{{$datass->nik}}" readonly>
                                      </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Alamat Alumni</label>
                                            <input type="text" class="form-control" id="alamat_alumni" name="alamat_alumni"
                                                value="{{$datass->alamat_alumni}}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Program Studi</label>
                                            <input type="text" class="form-control" id="nama_prodi" name="nama_prodi"
                                                value="{{$datass->relasiAlumnitoProdi->nama_prodi}}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Tahun Lulus</label>
                                            <input type="text" class="form-control" id="tahun_lulus" name="tahun_lulus"
                                                value="{{$datass->tahun_lulus}}" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">ID Line</label>
                                            <input type="text" class="form-control" id="id_line" name="id_line"
                                                value="{{$datass->id_line}}" readonly>
                                        </div>
                                    </td> 

                                    <td>
                                      <div class="form-group">
                                        <label class="font-weight-bold text-dark">Nim Alumni</label>
                                        <input type="text" class="form-control" id="nim_alumni" name="nim_alumni"
                                            value="{{$datass->nim_alumni}}" readonly>
                                      </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Email</label>
                                            <input type="email" class="form-control" id="email_alumni" name="email_alumni"
                                                value="{{$datass->email}}" readonly>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Jenis Kelamin</label>
                                            <input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin"
                                                value="{{$datass->jenis_kelamin}}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Handphone</label>
                                            <input type="text" class="form-control" id="no_hp" name="no_hp"
                                                value="+62 {{$datass->no_hp}}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Tahun Wisuda</label>
                                            <input type="text" class="form-control" id="tahun_wisuda" name="tahun_wisuda"
                                                value="{{$datass->tahun_wisuda}}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">ID Telegram</label>
                                            <input type="text" class="form-control" id="id_telegram" name="id_telegram"
                                                value="{{$datass->id_telegram}}" readonly>
                                        </div>
                                    </td>
                                </table>
                             
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <!-- Modal Delete -->
                    <div class="modal fade" id="delete{{$datass->id_alumni}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Hapus Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <input type="text" class="form-control" id="" value="{{$id_periode_alumni}}" name="id_periode" placeholder="" hidden>

                                    Apakah Anda yakin menghapus data Alumni?</b>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                                    <a href="/admin/alumni/{{$datass->id_alumni}}/delete"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Ya</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Delete -->
                    @endforeach
                    
        @foreach($alumni as $datass)
        <!-- Modal Update -->
        <div class="modal fade" id="update{{$datass->id_alumni}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Alumni</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <form action="/admin/alumni/update" method="POST" enctype="multipart/form-data">
                      <input type="hidden" name="id_alumni" value="{{$datass->id_alumni}}">
                      {{ csrf_field() }}
                      <input type="text" class="form-control" id="" value="{{$id_periode_alumni}}" name="id_periode" placeholder="" hidden>

                                        
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Nama Dengan Gelar</label>
                        <input type="text" class="form-control" id="nama_alumni" name="nama_alumni" value="{{$datass->nama_alumni}}" placeholder="">
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">NIK</label>
                        <input type="text" class="form-control" id="nik" name= "nik" value="{{$datass->nik}}" placeholder="">
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Nim Alumni</label>
                        <input type="text" class="form-control" id="nim_alumni" name= "nim_alumni" value="{{$datass->nik}}" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="jenis_kelamin" class="font-weight-bold text-dark">Jenis Kelamin</label>
                          <select name="jenis_kelamin" class="custom-select" id="jenis_kelamin" required>
                            <option value="Unspecified" <?php if($datass->jenis_kelamin == "Unspecified") { echo "SELECTED"; } ?>>Jenis Kelamin Tidak Dipilih</option>
                            <option value="Laki-Laki" <?php if($datass->jenis_kelamin == "Laki-Laki") { echo "SELECTED"; } ?>>Laki-Laki</option>
                            <option value="Perempuan" <?php if($datass->jenis_kelamin == "Perempuan") { echo "SELECTED"; } ?>>Perempuan</option>
                          </select>
                      </div>
                      
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Alamat</label>
                        <input type="text" class="form-control" id="alamat_alumni" name= "alamat_alumni" value="{{$datass->alamat_alumni}}" placeholder="">
                      </div>
                      <div class="form-group">
                          <label for="id_prodi" class="font-weight-bold text-dark">Program Studi</label>
                          <select name="id_prodi" id="prodi" class="custom-select" required>
                              <option>- Pilih prodi -</option>
                              @foreach($prodi as $prodis)
                              <option value="{{$prodis->id_prodi}}" @if($datass->id_prodi==$prodis->id_prodi) selected @endif>{{$prodis->nama_prodi}}</option>
                              @endforeach
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="id_angkatan" class="font-weight-bold text-dark">Angkatan</label>
                          <select name="id_angkatan" id="angkatan" class="custom-select" required>
                              <option>- Pilih angkstan -</option>
                              @foreach($angkatan as $angktans)
                              <option value="{{$angktans->id_angkatan}}" @if($datass->id_angkatan==$angktans->id_angkatan) selected @endif>{{$angktans->tahun_angkatan}}</option>
                              @endforeach
                          </select>
                        </div>

                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Email</label>
                        <input type="email" class="form-control" id="email" name= "email" value="{{$datass->email}}" placeholder="">
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Handphone</label>
                        <input type="text" class="form-control" id="no_hp" name= "no_hp"  value="{{$datass->no_hp}}" placeholder="">
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">ID Line</label>
                        <input type="text" class="form-control" id="id_line" name= "id_line" value="{{$datass->id_line}}"  placeholder="">
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">ID Telegram</label>
                        <input type="text" class="form-control" id="id_telegram" name= "id_telegram" value="{{$datass->id_telegram}}" placeholder="">
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Tahun Lulus</label>
                        <input type="date" class="form-control" id="tahun_lulus" name= "tahun_lulus"  value="{{$datass->tahun_lulus}}" placeholder="">
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Tahun Wisuda</label>
                        <input type="date" class="form-control" id="tahun_wisuda" name= "tahun_wisuda" value="{{$datass->tahun_wisuda}}" placeholder="">
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

        <!-- Modal Create -->
        <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	          <div class="modal-dialog" role="document">
	             <div class="modal-content">
	                <div class="modal-header">
	                  <h5 class="modal-title" id="exampleModalLabel">Masukkan Data Alumni</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                      <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <div class="modal-body">
                      
                      <form action="/admin/alumni/create" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      
                      <input type="text" class="form-control" id="" value="{{$id_periode_alumni}}" name="id_periode" placeholder="" hidden>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Nama Dengan Gelar</label>
                        <input type="text" class="form-control" id="nama_alumni" name="nama_alumni" placeholder="">
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" placeholder="">
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Nim Alumni</label>
                        <input type="text" class="form-control" id="nim_alumni" name="nim_alumni" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="province_id" class="font-weight-bold text-dark">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="custom-select" id="jenis_kelamin" required>
                                <option>-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-Laki" >Laki Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                      </div> 
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Alamat</label>
                        <input type="text" class="form-control" id="alamat_alumni" name= "alamat_alumni" placeholder="">
                      </div>

                      <div class="form-group">
                        <label for="id_prodi" class="font-weight-bold text-dark">Program Studi</label>
                            <select name="id_prodi" id="prodi" class="custom-select" required>
                                <option>-- Pilih Prodi --</option>
                                @foreach($prodi as $prodis)
                                <option value="{{$prodis->id_prodi}}">{{$prodis->nama_prodi}}</option>
                                @endforeach
                            </select>
                      </div> 

                      <div class="form-group">
                        <label for="id_angkatan" class="font-weight-bold text-dark">Angkatan</label>
                            <select name="id_angkatan" id="angkatan" class="custom-select" required>
                                <option>-- Pilih Angkatan --</option>
                                @foreach($angkatan as $angkatans)
                                <option value="{{$angkatans->id_angkatan}}">{{$angkatans->tahun_angkatan}}</option>
                                @endforeach
                            </select>
                      </div>

                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Email</label>
                        <input type="email" class="form-control" id="email" name= "email" placeholder="">
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Handphone</label>
                        <input type="text" class="form-control" id="no_hp" name= "no_hp" placeholder="">
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">ID Line</label>
                        <input type="text" class="form-control" id="id_line" name= "id_line" placeholder="">
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">ID Telegram</label>
                        <input type="text" class="form-control" id="id_telegram" name= "id_telegram" placeholder="">
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Tahun Lulus</label>
                        <input type="date" class="form-control" id="tahun_lulus" name= "tahun_lulus" placeholder="">
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Tahun Wisuda</label>
                        <input type="date" class="form-control" id="tahun_wisuda" name= "tahun_wisuda" placeholder="">
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

    <!-- Modal Validasi -->
    @foreach($alumni as $i => $status)
    <div class="modal fade" id="validasi{{$status->id_alumni}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Validasi Data Alumni</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="/admin/alumni/status" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_alumni" value="{{$status->id_alumni}}">
                {{ csrf_field() }}                    
                <table width="100%" cellspacing="30">
                  <td>
                  
                  <div class="form-group">
                      <label class="font-weight-bold text-dark">Nama Dengan Gelar</label>
                      <input type="text" class="form-control" id="nama_alumni" name="nama_alumni"
                          value="{{$status->nama_alumni}}" readonly>
                  </div>
                  <div class="form-group">
                    <label class="font-weight-bold text-dark">Angkatan</label>
                    <input type="text" class="form-control" id="angkatan" name="angkatan"
                        value=" @if($status->id_angkatan==$angkatans->id_angkatan) selected @endif {{$angkatans->tahun_angkatan}}" readonly>
                </div>
                  {{-- <div class="form-group">
                    <label for="id_angkatan" class="font-weight-bold text-dark">Angkatan</label>
                    <select name="id_angkatan" id="angkatan" class="custom-select" required readonly>
                        @foreach($angkatan as $angktans)
                        <option value="{{$angktans->id_angkatan}}" readonly @if($status->id_angkatan==$angktans->id_angkatan) selected @endif>{{$angktans->tahun_angkatan}}</option>
                        @endforeach
                    </select>
                  </div> --}}
                  <div class="form-group">
                      <label class="font-weight-bold text-dark">Alamat Alumni</label>
                      <input type="text" class="form-control" id="prodi" name="prodi"
                          value="{{$status->alamat_alumni}}" readonly>
                  </div>
                  <div class="form-group">
                    <label class="font-weight-bold text-dark">Program Studi</label>
                    <input type="text" class="form-control" id="prodi" name="prodi"
                        value="@if($status->id_prodi==$prodis->id_prodi) selected @endif {{$prodis->nama_prodi}}" readonly>
                </div>
                  {{-- <div class="form-group">
                    <label for="id_prodi" class="font-weight-bold text-dark">Program Studi</label>
                    <select name="id_prodi" id="prodi" class="custom-select" required readonly>
                        @foreach($prodi as $prodis)
                        <option value="{{$prodis->id_prodi}}"  @if($status->id_prodi==$prodis->id_prodi) selected @endif>{{$prodis->nama_prodi}}</option>
                        @endforeach
                    </select>
                  </div> --}}
                  <div class="form-group">
                      <label class="font-weight-bold text-dark">Tahun Lulus</label>
                      <input type="text" class="form-control" id="tahun_lulus" name="tahun_lulus"
                          value="{{$status->tahun_lulus}}" readonly>
                  </div>

                  <div class="form-group">
                      <label class="font-weight-bold text-dark">ID Line</label>
                      <input type="text" class="form-control" id="id_line" name="id_line"
                          value="{{$status->id_line}}" readonly>
                  </div>
                  
              </td> 
              

              <td>
                  <div class="form-group">
                      <label class="font-weight-bold text-dark">NIK</label>
                      <input type="nik" class="form-control" id="nik" name="nik"
                          value="{{$status->nik}}" readonly>
                  </div>
                  <div class="form-group">
                      <label class="font-weight-bold text-dark">Email</label>
                      <input type="email" class="form-control" id="email_alumni" name="email_alumni"
                          value="{{$status->email}}" readonly>
                  </div>
                  <div class="form-group">
                      <label class="font-weight-bold text-dark">Jenis Kelamin</label>
                      <input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin"
                          value="{{$status->jenis_kelamin}}" readonly>
                  </div>
                  <div class="form-group">
                      <label class="font-weight-bold text-dark">Handphone</label>
                      <input type="text" class="form-control" id="no_hp" name="no_hp"
                          value="+62 {{$status->no_hp}}" readonly>
                  </div>
                  <div class="form-group">
                      <label class="font-weight-bold text-dark">Tahun Wisuda</label>
                      <input type="text" class="form-control" id="tahun_wisuda" name="tahun_wisuda"
                          value="{{$status->tahun_wisuda}}" readonly>
                  </div>
                  <div class="form-group">
                      <label class="font-weight-bold text-dark">ID Telegram</label>
                      <input type="text" class="form-control" id="id_telegram" name="id_telegram"
                          value="{{$status->id_telegram}}" readonly>
                  </div>
              </td>
              
          </table>
              <table>
                <td>
                  <div class="form-group" >                                 
                    <a href="{{$status->file}} or '' " id="myFile"  rel="noopener noreferrer" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"  ><i
                      class="fas fa-download fa-sm text-white-50"></i> Download Document</a>                                
                  </div>
                </td>
              </table>
                <div class="form-group">
                  <label class="font-weight-bold text-dark">Status</label>
                    <select name="status" id="status" class="custom-select" required>
                      <option  value="Menunggu Konfirmasi" <?php if($status->status == "Menunggu Konfirmasi") { echo "SELECTED"; } ?>>Menunggu Konfirmasi</option>
                      <option value="Konfirmasi" <?php if($status->status == "Konfirmasi") { echo "SELECTED"; } ?>>Konfirmasi</option>
                      <option value="Ditolak"  <?php if($status->status == "Ditolak") { echo "SELECTED"; } ?>>Tolak</option>
                    </select>
                </div>
                <div class="tolak" id="tolak">
                    <label class="font-weight-bold text-dark">Masukkan Pesan Untuk Alumni</label>
                    <input type="text" class="form-control" class="form-control" name="notifikasi" id="notifikasi" >
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


@endsection


@section('custom_javascript')
<script>
    $(document).ready(function()
{
    $("#status").change(function() {
        if($(this).val() == "Ditolak") {
            $("#tolak").show();
        }
        else {
            $("#tolak").hide();
        }
    });
});
  </script>
@endsection