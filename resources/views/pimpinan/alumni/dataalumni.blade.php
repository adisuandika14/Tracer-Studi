@extends('layoutpimpinan.layout')
@section('title', 'Data Alumni')
@section('collapse5')
    collapse-item active
@endsection

@section('active2')
      nav-item active
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar Alumni</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width: fit-content;">No.</th>
                      <th style="text-align:center;">Nama</th>
                      <th style="text-align:center;">Alamat</th>
                      <th style="text-align:center;">Program Studi</th>
                      <th style="text-align:center;">Angkatan</th>
                      <th style="text-align:center;">Tahun Lulus</th>
                      <th style="text-align:center;">Tahun Wisuda</th>
                      <th style="text-align:center;">Aksi</th>
                    </tr>
                  </thead>

                  <tbody>
                        @foreach ($alumni as $alumnis)
                            <tr class="success">
                                <td style="width: fit-content;">{{ $loop->iteration }}</td>
                                <td>{{ $alumnis->nama_alumni }}</td>
                                <td>{{ $alumnis->alamat_alumni}}</td>
                                <td>{{ $alumnis->relasiAlumnitoProdi->nama_prodi}}</td>
                                <td>{{ $alumnis->relasiAlumnitoAngkatan->tahun_angkatan}}</td>
                                <td>{{ $alumnis->tahun_lulus }}</td>
                                <td>{{ $alumnis->tahun_wisuda }}</td>
                                <td style="width: 10%;">
                                    <!-- <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#show{{$alumnis->id_alumni}}"><i class="fas fa-eye" ></i>
                                    </button> -->
                                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#show{{$alumnis->id_alumni}}"><i
                                      class="fas fa-eye fa-sm text-white-50"></i> Lihat Detail</a>
                                    <!-- Edit -->
                                    <!-- <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#update{{$alumnis->id_alumni}}"><i class="fas fa-edit"></i>
                                    </button> -->
                                    <!--Delete -->
                                    <!-- <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{$alumnis->id_alumni}}"><i class="fas fa-trash"></i>
                                    </button> -->
                                </td>
                            </tr>
                        @endforeach
                  </tbody>
                </table>
              </div>
            </div>
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
                                    <table width="100%" cellspacing="30">
                                        <td>
                                        <input type="hidden" name="id_lab" value="{{$datass->id_alumni}}">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Nama Alumni</label>
                                            <input type="text" class="form-control" id="nama_alumni" name="nama_alumni"
                                                value="{{$datass->nama_alumni}}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Alamat Alumni</label>
                                            <input type="text" class="form-control" id="alamat_alumni" name="alamat_alumni"
                                                value="{{$datass->alamat_alumni}}" readonly>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label class="font-weight-bold text-dark">Kota</label>
                                            <input type="text" class="form-control" id="nama_kota" name="nama_kota"
                                                value="{{$datass->nama_kota}}" readonly>
                                        </div> -->
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
                                            <label class="font-weight-bold text-dark">Email</label>
                                            <input type="email" class="form-control" id="email_alumni" name="email_alumni"
                                                value="{{$datass->email_alumni}}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Jenis Kelamin</label>
                                            <input type="text" class="form-control" id="gender" name="gender"
                                                value="{{$datass->gender}}" readonly>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label class="font-weight-bold text-dark">Provinsi</label>
                                            <input type="text" class="form-control" id="nama_provinsi" name="nama_provinsi"
                                                value="{{$datass->nama_provinsi}}" readonly>
                                        </div> -->
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
	      	          <form action="/admin/alumni/create" method="POST">
                      {{csrf_field()}}
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Nama Alumni</label>
                        <input type="text" class="form-control" id="nama_alumni" name="nama_alumni" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="id_gender" class="font-weight-bold text-dark">Program Studi</label>
                                    <select name="id_gender" id="gender" class="custom-select" required>
                                        <option>-- Pilih Jenis Kelamin --</option>
                                        @foreach($gender as $genders)
                                        <option value="{{$genders->id_gender}}">{{$genders->gender}}</option>
                                        @endforeach
                                    </select>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Alamat</label>
                        <input type="text" class="form-control" id="alamat_alumni" name= "alamat_alumni" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="province_id" class="font-weight-bold text-dark">Provinsi</label>
                                    <select name="provinsi" class="custom-select" id="provinsi" required>
                                        <option>-- Pilih Provinsi --</option>
                                        @foreach($province as $provinces)
                                        <option value="{{$provinces->province_id}}">{{$provinces->name}}</option>
                                        @endforeach
                                    </select>
                      </div> 
                      <!-- <div class="form-group" >
                        <label for="regencies_id" class="font-weight-bold text-dark">Kabupaten</label>
                                    <select name="kabupaten" id="kabupaten" class="custom-select" required>
                                        <option >--Pilih Kabupaten--</option>
                                         @foreach($regencies as $reggen)
                                        <option id="kabupaten" value="{{$reggen->regencies_id}}">{{$reggen->name}}</option>
                                        @endforeach
                                    </select>
                      </div>  -->

                      <!-- <div class="form-group" >
                        <label for="district_id" class="font-weight-bold text-dark">Kecamatan</label>
                                    <select name="district_id" id="kecamatan" class="custom-select" required>
                                        <option>-- Pilih Kecamatan --</option>
                                       @foreach($districts as $dist)
                                        <option  value="{{$dist->district_id}}">{{$dist->name}}</option>
                                        @endforeach
                                    </select>
                      </div> -->

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
                        <input type="email" class="form-control" id="email_alumni" name= "email_alumni" placeholder="">
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

@endsection

@section('custom_javascript')
<script>
    //Provinsi AJAX
    $(document).ready(function(){

    
        $('#provinsi').on('change', function(){
          let id = $(this).val();
          $('#kabupaten').empty();
          //$('#kabupaten').append(`<option value = "0" disabled selected>--Silahkan Tunggu--</option>`);
          $.ajax({
            type: 'POST',
            url: 'Regency' + province_id, 
            success: function (response){
              var response = JSON.parse(response);
              console.log(response);
              $('#kabupaten').empty();
              $('#kabupaten').append(`<option value = "0" disabled selected>--Plih Kabupaten--</option>`);
              response.foreach(element => {
                $('#kabupaten').append(`<option value="${element['name']}"> ${element['name']}</option>`);
              });
            }
          });
        });

        //Kabupaten AJAX
        $('#kabupaten').on('change', function(){
          let id = $(this).val();
          $('#kecamatan').empty();
          $('#kecamatan').append(`<option value="0" disabled selected> Silahkan Tunggu....</option>`);
          $.ajax({
            type: 'GET',
            url: '/kecamatan/' + id,
            success: function (response){
              var response = JSON.parse(response);
              console.log(response);
              $('#kecamatan').empty();
              $('#kecamatan').append(`<option value = "0" disabled selected> Plih Kecamatan</option>`);
              response.forEach(element => {
                $('#kecamatan').append(`<option value="${element['id']}"> ${element['name']}</option>`);
              });
            }
          });
        });
      })
</script>


@endsection