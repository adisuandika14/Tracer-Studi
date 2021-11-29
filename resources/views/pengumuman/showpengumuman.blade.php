@extends('layoutadmin.layout')
@section('title', 'Detail Pengumuman')
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

<div class="container-fluid">

  <h1 class="h3 mb-4 text-gray-800"></h1>
    @if (session()->has('statusInput'))
      <div class="row">
        <div class="col-sm-12 alert alert-success alert-dismissible fade show" role="alert">
            {{session()->get('statusInput')}}
            <button type="button" class="close" data-dismiss="alert"
                aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
      </div>
    @endif

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
</div>


<div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Detail Pengumuman</h6>
            </div>
            <div class="card-body">
                <div class="col px-5 mb-3">
                    <div class="card border-0 bg-grey hover">
                        <table class="table table">
                            <td style="width: 50%;">
                            <form id="form-product" method="post" action="/admin/pengumuman/showpengumuman/send-message/{{$post->id_pengumuman}}" enctype="multipart/form-data">
                              @csrf
                                <div class="form-group">
                                <label class="font-weight-bold text-dark">Jenis Pengumuman</label>
                                    <input type="text" class="form-control" style="width: 50%;" placeholder="" value="{{$post->jenis}}" disabled></input>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Judul Pengumuman</label>
                                    <input type="text" class="form-control" style="width: 50%;" placeholder="" disabled value="{{$post->judul}}"></input>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Perihal Pengumuman</label>
                                    <input type="text" class="form-control" style="width: 50%;" placeholder="" disabled value="{{$post->perihal}}"></input>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Sifat Surat</label>
                                    <input type="text" class="form-control" style="width: 50%;" placeholder="" disabled value="{{$post->sifat_surat}}"></input>
                                </div>
                                <div class="form-group">                                       
                                    <img id="myImg" src="{{$post->thumbnail}}" alt="{{$post->thumbnail_name}}" style="width:100%; max-width:100px">
                                </div>
                                <div class="form-group" >                                 
                                  <a href="{{$post->lampiran}}" id="myFile"  rel="noopener noreferrer" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"  ><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download Document</a>                                
                                </div>
                                <div class="form-group mt-4 my-2">
                                    <a href="/admin/pengumuman" class="btn btn-secondary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-arrow-left"></i>
                                        </span>
                                        <span class="text">Kembali</span>
                                    </a>   
                                   
                                                                  

                                  {{-- <button class="btn btn-primary btn-icon-split" data-toggle="modal" id="#pilih_periode_alumni">
                                    <span class="icon text-white-50">
                                        <i class="fa fa-telegram"></i>
                                    </span>
                                    <span class="text" >Kirim Telegram</span>
                                </button> --}}
                                </div>
                            </td>

                            <td>
                              <label class="font-weight-bold text-dark">Pilih Periode untuk mengirim ke Telegram</label>
                              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                  <tr>
                                    <th style="width: fit-content;">No.</th>
                                    <th style="text-align:center;">Tahun Lulus </th>
                                    <th style="text-align:center;">Periode </th>                      
                                    <th style="text-align:center;">Aksi</th>
                                    
                                  </tr>
                                </thead>
              
                                <tbody>
                                      @foreach ($alumniperiode as $periodes)
                                          <tr class="success" name="periode">
                                              <td style="width: fit-content;">{{ $loop->iteration }}</td>
                                              <td>{{ $periodes->relasiPeriodealumnitoTahun->tahun_periode }}</td>
                                              <td>{{ $periodes->relasiPeriodealumnitoPeriode->periode }}</td>
                                              <td class="text-center">
                                                <button type="button" id="show_kuesioner_btn" onclick="send_message({{$periodes->id_alumni}})" class="btn btn-primary btn-sm">
                                                  <i class="fas fa-eye"></i> Lihat Kuesioner</button>
                                              </td>
                                              {{-- <td class="text-center">
                                                <button type="submit" class="btn btn-primary btn-icon-split">
                                                  <span class="icon text-white-50">
                                                      <i class="fa fa-telegram"></i>
                                                  </span>
                                                  <span class="text">Kirim Telegram</span>
                                              </button>
                                              </td> --}}
              
                                          </tr>
                                      @endforeach
                                </tbody>
                              </table>
                            </td>
                            </form> 
                        </table>
                    </div>
                </div>
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
    function send_message(id_alumni){
    window.location.href = "/admin/pengumuman/showpengumuman/send-message/"+id_alumni+"/"+$('#periode').val();
  };
</script>



<script>
// Get the modal
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
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('#btn1').on("click",function(e){
   $('#myImg').toggle('slow');
  });
});
</script>

<!-- Image Show & Hide -->
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
<script type="text/javascript">
$('#myImg').each(function(){
  if ($(this).attr("src") == "") 
       $(this).hide();
  else
      $(this).show();
});
</script>
<style>
.hide {display:none !important;}
.show {display:block !important;}
</style>


<!-- FIle SHow & Hide -->
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
<script type="text/javascript">

$('#myFile').each(function(){
  if ($(this).attr("href") == "") 
       $(this).hide();
  else
      $(this).show();
});
</script>
<style>
.hide {display:none !important;}
.show {display:block !important;}
</style>

@endsection