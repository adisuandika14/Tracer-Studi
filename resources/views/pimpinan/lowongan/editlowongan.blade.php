@extends('layoutadmin.layout')
@section('title', 'Add Lowongan')
@section('content')

@section('active5')
      nav-item active
@endsection

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


        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Tambah Lowongan</h6>
            </div>
            <div class="card-body">
            <form id="form-product" method="post" action="/admin/lowongan/{{$post->id_lowongan}}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <label for="title">Nama Perusahaan</label>
                        <input type="text" class="form-control" name="nama_perusahaan" placeholder="nama_perusahaan" value="{{$post->nama_perusahaan}}" required >
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <label for="title">Jenis Pekerjaan</label>
                        <input type="text" class="form-control" name="jenis_pekerjaan" placeholder="jenis_pekerjaan" value="{{$post->jenis_pekerjaan}}" required >
                    </div>
                </div>
                <!-- <div class="form-group form-group mt-4">
                    <label for="description">Konten</label>
                    <textarea id="lowongan" class="summernote" name="lowongan" placeholder="lowongan" value="{{$post->lowongan}}" required>{{$post->lowongan}}></textarea>
                </div> -->
                <div class="form-group mt-4">
                    <label for="thumbnail">Thumbnail</label>
                    <input type="file" class="form-control-file" id="thumbnail" name="thumbnail" value="{{$post->thumbnail}}" placeholder="thumbnail">
                </div>
                <div class="form-group mt-4">
                    <label for="lampiran">File Lampiran</label>
                    <input type="file" class="form-control-file" id="lampiran" name="lampiran" value="{{$post->lampiran}}" placeholder="lampiran">
                </div>
                <div class="form-group mt-4">
                    <a href="/admin/lowongan" class="btn btn-danger"><i class="fa fa-times"></i> Batal</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
            </div>
        </div>

                
@endsection