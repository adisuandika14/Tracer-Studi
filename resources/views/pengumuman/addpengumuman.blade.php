@extends('layoutadmin.layout')
@section('title', 'Add Pengumuman')
@section('content')

@section('active4')
      nav-item active
@endsection
<!-- <meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">

<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>


<div style="height: 600px;">
    <div id="fm"></div>
</div> -->

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


        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Tambah Pengumuman</h6>
            </div>
            
            <div class="card-body">
            <form id="form-product" method="post" action="{{url('/admin/pengumuman/store')}}" enctype="multipart/form-data">
                @csrf              
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <label for="title">Jenis Pengumuman</label>
                        <input type="text" class="form-control" name="jenis" placeholder="Jenis Pengumuman" required>
                        {{-- <textarea class="form-control" name="jenis" id="summernote"></textarea> --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <label for="title">Judul Pengumuman</label>
                        <input type="text" class="form-control" name="judul" placeholder="Judul Pengumuman" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <label for="title">Perihal Pengumuman</label>
                        <input type="text" class="form-control" name="perihal" placeholder="Perihal Pengumuman" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <label for="title">Sifat Surat</label>
                        <input type="text" class="form-control" name="sifat_surat" placeholder="Sifat Surat" required>
                    </div>
                </div>
                
                <div class="form-group mt-4" style="width: 50%">
                    <label for="transkrip">Thumbnail (Maks: 500kb)</label>
                    <div class="custom-file">
                        <input  type="file" class="custom-file-input" accept="application/pdf" id="transkrip" name="transkrip">
                        <label id="thumbnail" name="thumbnail" class="custom-file-label">
                                Pilih Thumbnail
                        </label>
                    </div>
                </div>
                <div class="form-group mt-4" style="width: 50%">
                    <label for="transkrip">Lampiran (Maks: 500kb)</label>
                    <div class="custom-file">
                        <input  type="file" class="custom-file-input" accept="application/pdf" id="transkrip" name="transkrip">
                        <label id="lampiran" name="lampiran" class="custom-file-label">
                                Pilih Lampiran
                        </label>
                    </div>
                </div>
                <div class="form-group mt-4">
                    <a href="/admin/pengumuman" class="btn btn-danger"><i class="fa fa-times"></i> Batal</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Tambah</button>
                </div>
            </form>
            </div>
        </div>

                
@endsection
<!-- 
@section('custom_javascript')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function(e){
        var status;
        $('.summernote').summernote({
            height: 350, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });

        $(function(){
            $(".tanggal").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
            });
        });

        // $('#blog_category-name').selectpicker();

        // jQuery('#submitBlogCategory').click(function(e){
        //     jQuery.ajax({
        //         url: "{{url('admin/kategori')}}",
        //         type: "POST",
        //         data: {
        //             _token: $('#signup-token').val(),
        //             name: jQuery('#blogCategoryName').val(),
        //         },
        //         success: function(result){
        //             $('.ganti').html(result.view);
        //             $('#blog_category_name').selectpicker('refresh');
        //             $('#addBlogCategory').modal('hide');
        //             console.log(result.view);
        //         }
        //     });
        // });
    });
</script>
@endsection -->