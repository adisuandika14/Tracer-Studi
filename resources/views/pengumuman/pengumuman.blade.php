@extends('layoutadmin.layout')
@section('title', 'Pengumuman')
<!-- @section('collapse5')
    collapse-item active
@endsection -->

@section('active4')
      nav-item active
@endsection

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
</div>

    <!-- Begin Page Content -->
    <div class="container-fluid">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Pengumuman</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <a class= "btn btn-success text-white" href="{{url('/admin/pengumuman/create')}}"><i class="fas fa-plus"></i>  Tambah Pengumuman</a>
                <table class="table table-bordered" id="dataTable" width="100%" align="center" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="text-align:centre;">No.</th>
                      <th style="text-align:center;">Tanggal Dibuat</th>
                      <th style="text-align:center;">Judul Pengumuman</th>
                      <th style="text-align:center;">Jenis Pengumuman</th>
                      <!-- <th style="text-align:center;">File</th> -->
                      <th style="text-align:center;">Aksi</th>
                      <!-- <th style="text-align:center;">Share</th> -->
                    </tr>
                  </thead>

                  <tbody> 
                        @foreach ($pengumuman as $announce)
                            <tr class="success">
                                <td style="width: 5%;">{{ $loop->iteration }}</td>
                                <td style="width: 10%" >{{ $announce->created_at }}</td>
                                <td >{{ $announce->judul }}</td>
                                <td >{{ $announce->jenis }}</td>
                                <!-- <td>
                                <img src="{{asset('storage/app/public/image/post'.$announce->thumbnail) }}" alt="Image 10"  width="300" height="300" />
                                </td> -->
                                <!-- <td style="width: 30px;">{{ $announce->thumbnail }}</td>
                                <td style="width: 30px;">{{ $announce->lampiran }}</td>
                                 -->

                                <td style="width: 13%">
                                    <!-- Show -->
                                    <a style="margin-right:7px" href="/admin/pengumuman/showpengumuman/{{$announce->id_pengumuman}}">
                                    <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>

                                    <!-- <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#show{{$announce->id_pengumuman}}"><i class="fas fa-eye"></i>
                                    </button> -->
                                    <!-- Edit -->
                                    <a style="margin-right:7px" href="/admin/pengumuman/{{$announce->id_pengumuman}}/edit">
                                    <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>
                                    <!--Delete -->
                                    <button style="margin-right:7px" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{$announce->id_pengumuman}}"><i class="fas fa-trash"></i>
                                    </button>

                                    <!-- <a  href="{'url(send-message)'}">
                                    <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-telegram"></i></button></a> -->

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

          @foreach($pengumuman as $announc)
        <!-- Modal Show --> 
                <!-- Modal Delete -->
                    <div class="modal fade" id="delete{{$announc->id_pengumuman}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Hapus Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin menghapus data Pengumuman?</b>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                                    <a href="/admin/pengumuman/{{$announc->id_pengumuman}}/delete"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Ya</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Delete -->
                    
        @endforeach


@endsection
