@extends('layoutadmin.layout')
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
              <a class= "btn btn-success text-white" href="{{url('/admin/lowongan/create')}}"><i class="fas fa-plus"></i>  Tambah lowongan</a>
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
                                <!-- <td >{{ $vacancies->judul }}</td> -->
                                <!-- <td>
                                <img src="{{asset('storage/app/public/image/post'.$vacancies->thumbnail) }}" alt="Image 10"  width="300" height="300" />
                                </td> -->
                                <!-- <td style="width: 30px;">{{ $vacancies->thumbnail }}</td>
                                <td style="width: 30px;">{{ $vacancies->lampiran }}</td>
                                 -->

                                <td style="width: 10%">
                                    <!-- Show -->
                                    <a style="margin-right:7px" href="/admin/lowongan/showlowongan/{{$vacancies->id_lowongan}}">
                                    <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>

                                    <!-- <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#show{{$vacancies->id_lowongan}}"><i class="fas fa-eye"></i>
                                    </button> -->
                                    <!-- Edit -->
                                    <a style="margin-right:7px" href="/admin/lowongan/{{$vacancies->id_lowongan}}/edit">
                                    <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>
                                    <!--Delete -->
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{$vacancies->id_lowongan}}"><i class="fas fa-trash"></i>
                                    </button>
                                </td>
                                
                                <!-- <td style="width: 10%">
                                    
                                    <button type="button" class="btn btn-primary btn-sm">
                                            <i class="fas fa-share"></i>
                                    </button>

                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="telegram">
                                            <i class="fas fa-share"></i>
                                    </button>
                                </td> -->
                            </tr>
                        @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
    </div>

          @foreach($lowongan as $vacancies)
        <!-- Modal Show -->
                <!-- Modal Delete -->
                    <div class="modal fade" id="delete{{$vacancies->id_lowongan}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Hapus Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin menghapus data lowongan?</b>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                                    <a href="/admin/lowongan/{{$vacancies->id_lowongan}}/delete"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Ya</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Delete -->
                    
        @endforeach


@endsection
