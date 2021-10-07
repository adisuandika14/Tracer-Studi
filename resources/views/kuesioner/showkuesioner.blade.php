@extends('layoutadmin.layout')
@section('title', 'Detail Kuesioner')
@section('content')
@section('active3')
      nav-item active
@endsection
<!-- Begin Page Content -->
<div class="container-fluid">
<h1 class="h3 mb-4 text-gray-800">{{$judul_kuesioner}}</h1>
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
              <h6 class="m-0 font-weight-bold text-primary">Data Sub Pertanyaan</h6>
    </div>
        <div class="card-body">
          <div class="form-group" style="width: 250px;">
          <label class=" font-weight-bold text-grey">Periode Kuesioner</label>
            <select name="prodi" class="custom-select text-center" style="width:150px; " id="periode">
                <option selected value="">-- Pilih Periode Kuesioner --</option>
                @foreach ($periodes as $periode)
                    <option  value="{{$periode->id_periode}}" @if($periode->id_periode == $id_periode) selected @endif>{{ $periode->periode }}
                    </option>
                @endforeach
            </select>
            <button class="btn btn-success btn-sm mt-3" data-toggle="modal" data-target="#create"><i
              class="fas fa-plus"></i> Tambah Sub Pertanyaaan
            </button>
        </div>
        <div id="loading" class="text-center" style="display:none;">
          <input id="signup-token" name="_token" type="hidden" value="{{csrf_token()}}">
          {{-- SPINNER --}}
          <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
          </div>
          <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
        {{-- SPINNER --}}
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
                        @foreach($detail as $detailss)
                        <div class="card shadow mb-4">
                            <!-- <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">{{$detailss->type_kuesioner}}</h6>
                            </div> -->
                            <div class="card-body">
                              @if($detailss->id_detail_kuesioner == $detailss->id_detail_kuesioner)
                                <p> {{ $loop->iteration }}. {{$detailss->pertanyaan}}</p>
                              @endif
                                <!-- <input type="text" class="form-control"  id="essay" name= "jawaban" value="" placeholder="Text Jawaban Singkat"> -->
                                @foreach ($opsi as $opsis)
                                  @if($detailss->id_detail_kuesioner == $opsis->id_detail_kuesioner)
                                    @if($detailss->id_jenis == 3)
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                        {{$opsis->opsi}}
                                        </label>
                                      </div>
                                      @elseif($detailss->id_jenis == 1)
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                        {{$opsis->opsi}}
                                        </label>
                                      </div>
                                      @else
                                      <div class="form-group" style="display: none;">
                                        <input type="text" class="form-control"  placeholder="Text Jawaban Singkat">
                                      </div>
                                    @endif
                                  @endif
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <!-- Edit -->
                                <button class="btn btn-primary btn-sm" onclick="edit({{$detailss->id_detail_kuesioner}})"><i class="fas fa-edit"></i>
                                </button> 
                                <!--Delete -->
                                <button class="btn btn-danger btn-sm" onclick="deletebc({{$detailss->id_detail_kuesioner}})"><i class="fas fa-trash"></i>
                                </button>
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

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Hapus Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Apakah Anda yakin menghapus Pertanyaan  ?</b>
            <form id="form-delete-kuesioner" method="post" action="">
              @method('delete')
              @csrf
              <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-danger">Hapus</button>
              </div>
            </form>  
        </div>
        <div class="modal-footer">
        </div>
    </div>
  </div>
</div>
                  

               <!-- Create -->
          <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	          <div class="modal-dialog" role="document">
	             <div class="modal-content">
	                <div class="modal-header">
	                  <h5 class="modal-title" id="exampleModalLabel">Masukkan Kuesioner</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                      <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>


	                <div class="modal-body">
	      	          <form action="/admin/kuesioner/soal/create" method="POST">
                      {{csrf_field()}}
                      <input type="text" class="form-control" id="id_kuesioner" name="id_kuesioner" value="{{$id_kuesioner}}" hidden>
                      <input type="text" class="form-control" id="id_periode" name="id_periode" value="{{$id_periode}}" hidden>
                      <div class="form-group">
                        <label for="id_jenis" class="font-weight-bold text-dark">Jenis Pertanyaan</label>
                                    <select name="id_jenis" id="kuesioner" class="custom-select" required>
                                        <option value="">-- Pilih Jenis Kuesioner --</option>
                                        @foreach($kuesioner as $kuesioners)
                                        <option value="{{$kuesioners->id_jenis}}">{{$kuesioners->jenis}}</option>
                                        @endforeach
                                    </select>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Pertanyaan</label>
                        <input type="text" class="form-control" id="pertanyaan" name="pertanyaan" placeholder="">
                      </div>
                      <div class="form-group" id="opsi1" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 1</label>
                        <input type="text" class="form-control" id="oopsi1" name="opsi1" placeholder="">
                      </div>
                      <div class="form-group" id="opsi2" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 2</label>
                        <input type="text" class="form-control" id="oopsi2" name="opsi2" placeholder="">
                      </div>
                      <div class="form-group" id="opsi3" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 3</label>
                        <div class="d-flex">
                          <input type="text" class="form-control mr-1" id="oopsi3" name="opsi3" placeholder="">
                          <button class="btn btn-sm" type="button" onclick="deleteOpsi('opsi3')"><i class="fas fa-trash text-danger"></i></button>
                          </div>
                      </div>
                      <div class="form-group" id="opsi4" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 4</label>
                        <div class="d-flex">
                          <input type="text" class="form-control mr-1" id="oopsi4" name="opsi4" placeholder="">
                          <button class="btn btn-sm" type="button" onclick="deleteOpsi('opsi4')"><i class="fas fa-trash text-danger"></i></button>
                          </div>
                      </div>
                      <div class="form-group" id="opsi5" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 5</label>
                        <div class="d-flex">
                          <input type="text" class="form-control mr-1" id="oopsi5" name="opsi5" placeholder="">
                          <button class="btn btn-sm" type="button" onclick="deleteOpsi('opsi5')"><i class="fas fa-trash text-danger"></i></button>
                          </div>
                      </div>
                      <div class="form-group" id="opsi6" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 6</label>
                        <div class="d-flex">
                          <input type="text" class="form-control mr-1" id="oopsi6" name="opsi6" placeholder="">
                          <button class="btn btn-sm" type="button" onclick="deleteOpsi('opsi6')"><i class="fas fa-trash text-danger"></i></button>
                          </div>
                      </div>
                      <div class="form-group" id="opsi7" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 7</label>
                        <div class="d-flex">
                          <input type="text" class="form-control mr-1" id="oopsi7" name="opsi7" placeholder="">
                          <button class="btn btn-sm" type="button" onclick="deleteOpsi('opsi7')"><i class="fas fa-trash text-danger"></i></button>
                          </div>
                      </div>
                      <div class="form-group" id="opsi8" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 8</label>
                        <div class="d-flex">
                          <input type="text" class="form-control mr-1" id="oopsi8" name="opsi8" placeholder="">
                          <button class="btn btn-sm" type="button" onclick="deleteOpsi('opsi8')"><i class="fas fa-trash text-danger"></i></button>
                          </div>
                      </div>
                      <div class="form-group" id="opsi9" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 9</label>
                        <div class="d-flex">
                          <input type="text" class="form-control mr-1" id="oopsi9" name="opsi9" placeholder="">
                          <button class="btn btn-sm" type="button" onclick="deleteOpsi('opsi9')"><i class="fas fa-trash text-danger"></i></button>
                          </div>
                      </div>
                      <div class="form-group" id="opsi10" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 10</label>
                        <div class="d-flex">
                          <input type="text" class="form-control mr-1" id="oopsi10" name="opsi10" placeholder="">
                          <button class="btn btn-sm" type="button" onclick="deleteOpsi('opsi10')"><i class="fas fa-trash text-danger"></i></button>
                          </div>
                      </div>
                      <button type="button" id="btnTambahOpsi" class="btn btn-primary" style="display: none;">Tambah Opsi</button>
                      <div class="modal-footer">
		                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		                      <button type="submit" class="btn btn-success">Simpan</button>
		                  </div>
                      </form>
                  </div>
	              </div>
	            </div>
          </div>

  <!-- Update -->
    <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	          <div class="modal-dialog" role="document">
	             <div class="modal-content">
	                <div class="modal-header">
	                  <h5 class="modal-title" id="exampleModalLabel">Masukkan Kuesioner</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                      <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
                  <div class="modal-body" id="loadingEdit">
                    <div class="d-flex justify-content-center">
                      <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                    </div>
                  </div>
	                <div class="modal-body" id="bodyEdit">
	      	          <form action="/admin/kuesioner/soal/update/" method="POST" id="edit-pertanyaan-form">
                      {{csrf_field()}}
                      <input type="text" class="form-control" id="edit_id_kuesioner" name="id_kuesioner" value="{{$id_kuesioner}}" hidden>
                      <div class="form-group">
                        <label for="id_jenis" class="font-weight-bold text-dark">Jenis Pertanyaan</label>
                                    <select name="edit_id_jenis" id="edit_id_jenis" class="custom-select" required>
                                        <option value="">-- Pilih Jenis Kuesioner --</option>
                                        @foreach($kuesioner as $kuesioners)
                                        <option value="{{$kuesioners->id_jenis}}">{{$kuesioners->jenis}}</option>
                                        @endforeach
                                    </select>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Pertanyaan</label>
                        <input type="text" class="form-control" id="edit_pertanyaan" name="edit_pertanyaan" placeholder="">
                      </div>
                      <div class="form-group" id="edit_opsi1" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 1</label>
                        <input type="text" class="form-control" id="eedit_opsi1" name="edit_opsi1" placeholder="">
                      </div>
                      <div class="form-group" id="edit_opsi2" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 2</label>
                        <input type="text" class="form-control" id="eedit_opsi2" name="edit_opsi2" placeholder="">
                      </div>
                      <div class="form-group" id="edit_opsi3" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 3</label>
                        <div class="d-flex">
                          <input type="text" class="form-control mr-1" id="eedit_opsi3" name="edit_opsi3" placeholder="">
                          <button class="btn btn-sm" type="button" onclick="deleteOpsi('edit_opsi3')"><i class="fas fa-trash text-danger"></i></button>
                          </div>
                      </div>
                      <div class="form-group" id="edit_opsi4" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 4</label>
                        <div class="d-flex">
                          <input type="text" class="form-control mr-1" id="eedit_opsi4" name="edit_opsi4" placeholder="">
                          <button class="btn btn-sm" type="button" onclick="deleteOpsi('edit_opsi4')"><i class="fas fa-trash text-danger"></i></button>
                          </div>
                      </div>
                      <div class="form-group" id="edit_opsi5" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 5</label>
                        <div class="d-flex">
                          <input type="text" class="form-control mr-1" id="eedit_opsi5" name="edit_opsi5" placeholder="">
                          <button class="btn btn-sm" type="button" onclick="deleteOpsi('edit_opsi5')"><i class="fas fa-trash text-danger"></i></button>
                          </div>
                      </div>
                      <div class="form-group" id="edit_opsi6" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 6</label>
                        <div class="d-flex">
                          <input type="text" class="form-control mr-1" id="eedit_opsi6" name="edit_opsi6" placeholder="">
                          <button class="btn btn-sm" type="button" onclick="deleteOpsi('edit_opsi6')"><i class="fas fa-trash text-danger"></i></button>
                          </div>
                      </div>
                      <div class="form-group" id="edit_opsi7" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 7</label>
                        <div class="d-flex">
                          <input type="text" class="form-control mr-1" id="eedit_opsi7" name="edit_opsi7" placeholder="">
                          <button class="btn btn-sm" type="button" onclick="deleteOpsi('edit_opsi7')"><i class="fas fa-trash text-danger"></i></button>
                          </div>
                      </div>
                      <div class="form-group" id="edit_opsi8" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 8</label>
                        <div class="d-flex">
                          <input type="text" class="form-control mr-1" id="eedit_opsi8" name="edit_opsi8" placeholder="">
                          <button class="btn btn-sm" type="button" onclick="deleteOpsi('edit_opsi8')"><i class="fas fa-trash text-danger"></i></button>
                          </div>
                      </div>
                      <div class="form-group" id="edit_opsi9" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 9</label>
                        <div class="d-flex">
                          <input type="text" class="form-control mr-1" id="eedit_opsi9" name="edit_opsi9" placeholder="">
                          <button class="btn btn-sm" type="button" onclick="deleteOpsi('edit_opsi9')"><i class="fas fa-trash text-danger"></i></button>
                          </div>
                      </div>
                      <div class="form-group" id="edit_opsi10" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 10</label>
                        <div class="d-flex">
                          <input type="text" class="form-control mr-1" id="eedit_opsi10" name="edit_opsi10" placeholder="">
                          <button class="btn btn-sm" type="button" onclick="deleteOpsi('edit_opsi10')"><i class="fas fa-trash text-danger"></i></button>
                          </div>
                      </div>
                      <button type="button" id="edit_btnTambahOpsi" class="btn btn-primary" style="display: none;">Tambah Opsi</button>
                      <div class="modal-footer">
		                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		                      <button type="submit" class="btn btn-success">Simpan</button>
		                  </div>
                      </form>
                  </div>
	              </div>
	            </div>
    </div>
@endsection

@section('custom_javascript')
<script>
  //DeleteOpsi
  function deleteOpsi(opsi){
    $('#'+opsi).hide();
  }
  //Periode
$('#periode').change(function(){
  $('#id_periode').val($(this).val());
  $('#ganti').hide();
  $('#loading').show();
  jQuery.ajax({
    url: "{{url('admin/kuesioner/showkuesioner/filter/')}}" ,
    method: 'post',
    data: {
        _token: $('#signup-token').val(),
        id_periode: $(this).val(),
        id_kuesioner: {{ $id_kuesioner }}
    },
    success: function (result) {
      console.log(result);
      $('#loading').hide();
        $('.ganti').html(result.hasil);
        $('#ganti').show();
    }
});
})

    function deletebc(id){
        $("#form-delete-kuesioner").attr("action", "/admin/kuesioner/soal/"+id+"/delete");
        $('#deleteModal').modal('show');
    }

    function edit(id){
    $("#bodyEdit").hide();
    $("#loadingEdit").show();
    $('#update').modal('show');
    jQuery.ajax({
      url: "/admin/kuesioner/soal/"+id+"/edit",
      method: 'get',
      success: function(result){
        let opsi = 1;
        let count = 1;
        console.log(result);
            $("#edit_id_jenis").val(result.detail_kuesioner['id_jenis']);
            $("#edit_pertanyaan").val(result.detail_kuesioner['pertanyaan']);
            $("#edit-pertanyaan-form").attr("action", "/admin/kuesioner/soal/"+result.detail_kuesioner['id_detail_kuesioner']+"/update");
            if(result.detail_kuesioner['id_jenis'] == 1 || result.detail_kuesioner['id_jenis'] == 3){
              $("#edit_opsi1").prop('required',true);
              $("#edit_opsi2").prop('required',true);
              opsi=1
              result.opsis.forEach(element => {
                $("#eedit_opsi"+opsi).val(element['opsi']);
                $("#edit_opsi"+opsi).fadeIn();
                opsi = opsi + 1;
                if(opsi<11){
                  $("#edit_btnTambahOpsi").show();
                }
              });
              console.log(result.opsis);
              $('#edit_id_jenis').change(function() {
                if($('#edit_id_jenis').val() == 1 || $('#edit_id_jenis').val() == 3){
                  $("#edit_opsi1").prop('required',true);
                  $("#edit_opsi2").prop('required',true);
                  opsi=1;
                  result.opsis.forEach(element => {
                    $("#eedit_opsi"+opsi).val(element['opsi']);
                    $("#edit_opsi"+opsi).fadeIn();
                    opsi = opsi + 1;
                    if(opsi<11  ){
                      $("#edit_btnTambahOpsi").show();
                    }
                  });
                }else if($('#edit_id_jenis').val() == 2 || $('#edit_id_jenis').val() == ""){
                  $("#edit_opsi1").prop('required',false);
                  $("#edit_opsi2").prop('required',false);
                  for(let i = 1; i<=11; i++){
                    $('#edit_opsi'+i).fadeOut();
                  }
                  $('#edit_btnTambahOpsi').fadeOut();
                }
              });
            }else if(result.detail_kuesioner['id_jenis'] == 2){
              $('#edit_id_jenis').change(function() {
              if($('#edit_id_jenis').val() == 1){
                $("#edit_opsi1").prop('required',true);
                $("#edit_opsi2").prop('required',true);
                opsi=1;
                  $('#edit_opsi1').fadeIn();
                  $('#edit_opsi2').fadeIn();
                  $("#eedit_opsi1").prop('required',true);
                  $("#eedit_opsi2").prop('required',true);
                  $('#edit_btnTambahOpsi').fadeIn();
              }else if($('#edit_id_jenis').val() == 2 || $('#edit_id_jenis').val() == ""){
                $("#edit_opsi1").prop('required',false);
                $("#edit_opsi2").prop('required',false);
                for(let i = 1; i<=11; i++){
                  $('#edit_opsi'+i).fadeOut();
                }
                $('#edit_btnTambahOpsi').fadeOut();
              }
            });
            }
            $('#edit_id_jenis').change(function() {
              if($('#edit_id_jenis').val() == 1 ||$('#edit_id_jenis').val() == 3){
                $("#edit_opsi1").prop('required',true);
                $("#edit_opsi2").prop('required',true);
                opsi=1;
                result.opsis.forEach(element => {
                  $("#eedit_opsi"+opsi).val(element['opsi']);
                  $("#edit_opsi"+opsi).fadeIn();
                  opsi = opsi + 1;
                  if(opsi<5){
                    $("#edit_btnTambahOpsi").show();
                  }
                });
              }else if($('#edit_id_jenis').val() == 2 || $('#edit_id_jenis').val() == ""){
                $("#edit_opsi1").prop('required',false);
                $("#edit_opsi2").prop('required',false);
                for(let i = 1; i<=11; i++){
                  $('#edit_opsi'+i).fadeOut();
                }
                $('#edit_btnTambahOpsi').fadeOut();
              }
            });
            $('#edit_btnTambahOpsi').click(function(){
              $('#edit_opsi'+opsi).fadeIn();
              opsi = opsi + 1;
              if(opsi == 11){
                $('#edit_btnTambahOpsi').fadeOut();
              }
            });
            $("#loadingEdit").hide();
            $("#bodyEdit").show();                    
      }
    });
  }

//Jenis Kuesioner Onclick Listener
    let id_opsi;
    $('#kuesioner').change(function() {
        if($('#kuesioner').val() == 1 || $('#kuesioner').val() == 3){
          id_opsi = 3;
          $('#opsi1').fadeIn();
          $('#opsi2').fadeIn();
          $("#oopsi1").prop('required',true);
          $("#oopsi2").prop('required',true);
          $('#btnTambahOpsi').fadeIn();
        }else if($('#kuesioner').val() == 2 || $('#kuesioner').val() == ""){
          $("#oopsi1").prop('required',false);
          $("#oopsi2").prop('required',false);
          for(let i = 1; i<=11; i++){
            $('#opsi'+i).fadeOut();
          }
          $('#btnTambahOpsi').fadeOut();
        }
    });

    $('#btnTambahOpsi').click(function(){
      $('#opsi'+id_opsi).fadeIn();
      id_opsi = id_opsi + 1;
      if(id_opsi == 11){
        $('#btnTambahOpsi').fadeOut();
      }
    });
  </script>
@endsection
@section('custom_javascript')
<script>

//Opsi 
    let id_jawab;
    $('#essay').change(function() {
        if($('#essay').val() == 1 || $('#essay').val() == 3){
          id_jawab = 2;
          $('#opsi1').fadeIn();
          $('#btnTambahOpsi').fadeIn();
        }else if($('#essay').val() == "" || $('#essay').val() == ""){
          for(let i = 1; i<=10; i++){
            $('#opsi'+i).fadeOut();
          }
          $('#btnTambahOpsi').fadeOut();
        }
    });

  </script>
@endsection