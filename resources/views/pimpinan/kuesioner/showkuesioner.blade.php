@extends('layoutpimpinan.layout')
@section('title', 'Detail Kuesioner')
@section('content')
@section('active3')
      nav-item active
@endsection

<style>
 /* The switch - the box around the slider */
 .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
} 
</style>


<!-- Begin Page Content -->
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">{{$judul_kuesioner}}</h1>
        @if (session()->has('success'))
          <div class="row">
            <div class="col-sm-12 alert alert-success alert-dismissible fade show" role="alert">
                {{session()->get('success')}}
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
    <div class="card shadow mb-4">
        <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Data Pertanyaan</h6>
        </div>
            <div class="card-body">
                <div class="table-responsive">
                
                    <div class="ganti" id="ganti">
                      <div class="table-responsive">
                        <div class="container-fluid mt-4" style="align-content: center;">
                            <div class="form-group" >
                                <div class="form-group">
                                  @if($detail->isEmpty())
                                  <div class="text-center">
                                      Tidak ada data
                                  </div>
                                  @endif
                                    @foreach($detail as $detailss => $status)
                                    <div class="card shadow mb-4">
                                        <!-- <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">{{$status->type_kuesioner}}</h6>
                                        </div> -->
                                        <div class="card-body">
                                          @if($status->id_detail_kuesioner == $status->id_detail_kuesioner)
                                            <p> {{ $loop->iteration }}. {{$status->pertanyaan}}</p>
                                          @endif
                                            <!-- <input type="text" class="form-control"  id="essay" name= "jawaban" value="" placeholder="Text Jawaban Singkat"> -->
                                            @foreach ($opsi as $opsis)
                                              @if($status->id_detail_kuesioner == $opsis->id_detail_kuesioner)
                                                <ul class="list-group mb-1">
                                                  <li class="list-group-item">{{$opsis->opsi}}</li>
                                                </ul>
                                              @endif
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                            <label class="switch">
                                                @if($status->status == "Konfirmasi")
                                                  <input type="checkbox" id="status_{{$status->id_detail_kuesioner}}" onclick="statusBtn({{$status->id_detail_kuesioner}})" checked>
                                                @else
                                                  <input type="checkbox" id="status_{{$status->id_detail_kuesioner}}" onclick="statusBtn({{$status->id_detail_kuesioner}})">
                                                @endif
                                              <span class="slider round"></span>
                                            </label>
                                          </div>
                                    </div>
                                    @endforeach
                              </div>
                          </div>
                      </div>
                  </div>
                 </div>
                </div>
            </div>
        </div>
      </div>


@endsection


@section('custom_javascript')
<script>
//Switch Status Pengumuman
  function statusBtn(id) {
    var checkBox = document.getElementById("status_"+id);
    // If the checkbox is checked, display the output text
    if (checkBox.checked == true){
      swal({
          title: 'Anda yakin ingin menerima kuesioner ini?',
          icon: 'warning',
          buttons: ["Tidak", "Ya"],
      }).then(function(value) { 
          if (value) {
            jQuery.ajax({  
              url: "/pimpinan/kuesioner/showkuesioner/"+id+"/Konfirmasi",
              type: "GET",
              success: function(result){
              }
          });
        }else{
          document.getElementById("status_"+id).checked = false;
        }
      });
    } else {
      swal({
          title: 'Anda yakin ingin menolak kuesioner ini?',
          icon: 'warning',
          buttons: ["Tidak", "Ya"],
      }).then(function(value) {
          if (value) {
            jQuery.ajax({
              url: "/pimpinan/kuesioner/showkuesioner/"+id+"/Ditolak",
              type: "GET",
              success: function(result){
              }
          });
        }else{  
          document.getElementById("status_"+id_detail_kuesioner).checked = true;
        }
      });
    }
  }
  $('#sidebarPengumuman').addClass("active");
</script>


@endsection