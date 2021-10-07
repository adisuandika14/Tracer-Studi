@extends('layoutpimpinan.layout')
@section('title', 'Lowongan')
<!-- @section('collapse5')
    collapse-item active
@endsection -->

@section('active5')
      nav-item active
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Lowongan</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <!-- <a class= "btn btn-success text-white" href="{{url('/admin/lowongan/create')}}"><i class="fas fa-plus"></i>  Tambah lowongan</a> -->
                <table class="table table-bordered" id="dataTable" width="100%"  cellspacing="0">
                  <thead>
                    <tr>
                      <th style="text-align:centre;">No.</th>
                      <th style="text-align:center;">Tanggal Posting</th>
                      <th style="text-align:center;">Nama Perusahaan</th>
                      <th style="text-align:center;">Jenis Pekerjaan</th>
                      <!-- <th style="text-align:center;">File</th> -->
                      <th style="text-align:center;">Aksi</th>
                      <!-- <th style="text-align:center;">Share</th> -->
                    </tr>
                  </thead>

                  <tbody>
                        @foreach ($lowongan as $vacancies)
                            <tr class="success">
                                <td style="width: 5%;">{{ $loop->iteration }}</td>
                                <td style="width: 10%" >{{ $vacancies->created_at }}</td>
                                <td>{{ $vacancies->nama_perusahaan }}</td>
                                <td>{{ $vacancies->jenis_pekerjaan }}</td>
                                <td style="width: 10%">
                                    <!-- Show -->
                                    <a  href="/pimpinan/lowongan/showlowongan/{{$vacancies->id_lowongan}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                      class="fas fa-eye fa-sm text-white-50"></i > Lihat Data</a>
                                </td>
                            </tr>
                        @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
    </div>


@endsection
