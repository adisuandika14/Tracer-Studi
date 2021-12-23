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
                <h6 class="m-0 font-weight-bold text-primary">Daftar Alumni Periode - {{$tahun_lulus}} - {{$periodealumni}}</h6>
              </div>
            <div class="card-body">
              <div class="table-responsive">
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
                      <th style="text-align:center;">Aksi</th>
                    </tr>
                  </thead>

                  <tbody>
                        @foreach ($alumni as $alumnis)
                            <tr class="success">
                                <td style="width: fit-content;">{{ $loop->iteration }}</td>
                                <td>{{ $alumnis->nama_alumni }}</td>
                                <td>{{ $alumnis->nik }}</td>
                                <td>{{ $alumnis->nim_alumni}}</td>
                                <td>{{ $alumnis->jenis_kelamin}}</td>
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
                                            <input type="email" class="form-control" id="email" name="email"
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
        @endforeach
@endsection