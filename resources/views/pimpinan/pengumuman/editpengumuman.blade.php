@extends('layoutadmin.layout')
@section('title', 'Edit Pengumuman')
@section('content')

@section('active4')
      nav-item active
@endsection


<style>
body {font-family: Arial, Helvetica, sans-serif;}

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 100%;
  max-width: 800px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 100%;
  max-width: 900px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 550px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}

/* img {
  width: 400px;
  height: 600px;
  object-fit: contain;
} */


</style>






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
              <h6 class="m-0 font-weight-bold text-primary">Edit Pengumuman</h6>
            </div>
            <div class="card-body">
            <form id="form-product" method="post" action="/admin/pengumuman/{{$post->id_pengumuman}}" enctype="multipart/form-data">
                @csrf

            <table class="table table">
            <td style="width: 50%;">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <label for="title">Jenis Pengumuman</label>
                        <input type="text" class="form-control" name="jenis" placeholder="jenis" value="{{$post->jenis}}" required >
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <label for="title">Judul Pengumuman</label>
                        <input type="text" class="form-control" name="judul" placeholder="judul" value="{{$post->judul}}" required >
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <label for="title">Sifat Surat</label>
                        <input type="text" class="form-control" name="sifat_surat" placeholder="sifat_surat" value="{{$post->sifat_surat}}" required >
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <label for="title">Perihal</label>
                        <input type="text" class="form-control" name="perihal" placeholder="perihal" value="{{$post->perihal}}" required >
                    </div>
                </div>
                <!-- <div class="form-group form-group mt-4">
                    <label for="description">Konten</label>
                    <textarea id="pengumuman" class="summernote" name="pengumuman" placeholder="pengumuman" value="{{$post->pengumuman}}" required>{{$post->pengumuman}}></textarea>
                </div> -->
                <!-- <div class="form-group mt-4">
                    <label for="thumbnail">Thumbnail</label>
                    <input type="file" id="blah" class="form-control-file" name="thumbnail" value="{{$post->thumbnail}}" placeholder="thumbnail">
                </div> -->

                <div class="form-group mt-4">
                    <!-- <img id="myImg" src="{{$post->thumbnail}}" /></br> -->
                    <!-- <div id="image_preview" style="width:300%; max-width:500px"></div> -->
                    <label for="thumbnail">Thumbnail</label>
                    <input type="file" id="upload_file" class="form-control-file" name="thumbnail" value="{{$post->thumbnail}}" placeholder="thumbnail" onchange="preview_image();" multiple style="width:300%; max-width:500px">
                    
                </div>
                <div class="form-group mt-4">
                    <label for="lampiran">File Lampiran</label>
                    <input type="file" class="form-control-file" id="lampiran" name="lampiran" value="{{$post->lampiran}}" placeholder="lampiran">
                </div>
                <div class="form-group mt-4">
                    <a href="/admin/pengumuman" class="btn btn-danger"><i class="fa fa-times"></i> Batal</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                </div>
                </td>
                <td>
                    <div class="form-group">                                       
                            <img id="myImg" src="{{$post->thumbnail}}" alt="{{$post->thumbnail_name}}" style="width:300%; max-width:500px">
                    </div>
                </td>


            </table>
            </form>
            
            </div>
        </div>

                
@endsection
<!-- Modal Show Image -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  
  <div id="caption"></div>
</div>

@section('custom_javascript')


<script>

//Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}









$(function () {
    $(":file").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
        }
    });
});

function imageIsLoaded(e) {
    $('#myImg').attr('src', e.target.result);
};

$(document).ready(function() 
{ 
 $('form').ajaxForm(function() 
 {
  alert("Uploaded SuccessFully");
 }); 
});

function preview_image() 
{
 var total_file=document.getElementById("upload_file").files.length;
 for(var i=0;i<total_file;i++)
 {
  $('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'><br>");
 }
}
</script>


@endsection


