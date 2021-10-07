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
              <h6 class="m-0 font-weight-bold text-primary">Tambah Pengumuman</h6>
            </div>
            
            <div class="card-body">
            <form id="form-product" method="post" action="{{url('/admin/pengumuman/store')}}" enctype="multipart/form-data">
                @csrf
                <!-- <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <label for="title">Tanggal Publish</label>
                        <input type="date" class="form-control" name="tgl_post" placeholder="tgl_post" required>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <label for="title">Sumber Pengumuman</label>
                        <input type="text" class="form-control" name="jenis" placeholder="Jenis Pengumuman" required>
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
                <!-- <div class="form-group form-group mt-4">
                    <label for="description">Konten</label>
                    <textarea id="pengumuman" class="summernote" name="pengumuman" required></textarea>
                </div> -->
                <div class="form-group mt-4">
                    <label for="thumbnail">Thumbnail</label>
                    <input type="file" class="form-control-file" id="thumbnail" name="thumbnail">
                </div>
                <div class="form-group mt-4">
                    <label for="lampiran">File Lampiran</label>
                    <input type="file" class="form-control-file" id="lampiran" name="lampiran" >
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