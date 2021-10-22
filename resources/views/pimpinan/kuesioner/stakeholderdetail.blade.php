@extends('layoutpimpinan.layout')
@section('title', 'Detail Kuesioner Stakeholder')
@section('content')
@section('active3')
      nav-item active
@endsection

<!-- Begin Page Content -->
<div class="container-fluid">
  <h1 class="h4 mb-3 text-gray-800">Periode - {{$tahun}}</h1>
  <h1 class="h5 mb-4 text-gray-800">Program Studi - {{$prodi}}</h1>
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


  <div class="card shadow mb-4">
    <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Data Pertanyaan Stakeholder</h6>
    </div>
        <div class="card-body">
          <div class="form-group" style="width: 250px;">
            <div class="dropdown mt-4">
            </div>
        </div>
        
        <div class="switch" id="switch">
            <div class="table-responsive">
            <div class="container-fluid mt-4" style="align-content: center;">
                <div class="form-group" >
                    <div class="form-group">
                      @if($detail->isEmpty())
                      <div class="text-center">
                          Tidak ada data
                      </div>
                      @endif
                        @foreach($detail as $detailss =>$status)
                        <div class="card shadow mb-4">
                            <div class="card-body" name="card" id="card">
                              @if($status->id_kuesioner_stakeholder == $status->id_kuesioner_stakeholder)
                                <p> {{ $loop->iteration }}. {{$status->pertanyaan}}</p>
                              @endif
                                <!-- <input type="text" class="form-control"  id="essay" name= "jawaban" value="" placeholder="Text Jawaban Singkat"> -->
                                @foreach ($opsi as $opsis)
                                  @if($status->id_kuesioner_stakeholder == $opsis->id_soal_pengguna)
                                    @if($status->id_jenis == 3)
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                        {{$opsis->opsi}}
                                        </label>
                                      </div>
                                      @endif
                                      @if($status->id_jenis == 1)
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                        {{$opsis->opsi}}
                                        </label>
                                      </div>
                                      @endif
                                      @if($status->id_jenis == 2 || $status->id_jenis == 4)
                                      <div class="form-group" style="display: none;">
                                        <input type="text" class="form-control"  placeholder="Text Jawaban Singkat">
                                      </div>
                                    @endif
                                  @endif
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                {{-- Switch Status --}}
                                <label class="switch">
                                    @if($status->status == "Konfirmasi")
                                      <input type="checkbox" id="status_{{$status->id_kuesioner_stakeholder}}" onclick="statusBtn({{$status->id_kuesioner_stakeholder}})" checked>
                                    @else
                                      <input type="checkbox" id="status_{{$status->id_kuesioner_stakeholder}}" onclick="statusBtn({{$status->id_kuesioner_stakeholder}})">
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

@endsection

@section('custom_javascript')
<script>
  //Switch Status Kuesioner
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
              url: "/pimpinan/kuesioner/stakeholder/showkuesioner/"+id+"/Konfirmasi",
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
              url: "/pimpinan/kuesioner/stakeholder/showkuesioner/"+id+"/Ditolak",
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