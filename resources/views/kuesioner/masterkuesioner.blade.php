@extends('layoutadmin.layout')
@section('title', 'Master Pertanyaan')
@section('collapse3')
    collapse-item active
@endsection

@section('active6')
      nav-item active
@endsection




@section('content')
    <!-- Begin Page Content -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Sub Pertanyaan</h6>
      </div>
          <div class="card-body">
              <div class="table-responsive">
                      <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#create"><i
                              class="fas fa-plus"></i> Tambah Sub Pertanyaaan
                      </button>
              <div class="container-fluid" style="align-content: center;">
                  <div class="row" >
                      <div class="col-lg-6">
                          @foreach($pertanyaan as $master)
                          <div class="card shadow mb-4">
                              <!-- <div class="card-header py-3">
                                  <h6 class="m-0 font-weight-bold text-primary">{{$master->type_kuesioner}}</h6>
                              </div> -->
                              <div class="card-body">
                                  <p> {{ $loop->iteration }}. {{$master->pertanyaan}}</p>
                                  <!-- <input type="text" class="form-control"  id="essay" name= "jawaban" value="" placeholder="Text Jawaban Singkat"> -->
                                  @foreach ($opsi as $opsis)
                                    @if($master->id_master_kuesioner == $opsis->id_master_kuesioner)
                                      <ul class="list-group mb-1">
                                        <li class="list-group-item">{{$opsis->opsi}}</li>
                                      </ul>
                                    @endif
                                  @endforeach
                              </div>
                              <div class="modal-footer">
                                  <!-- Edit -->
                                  <button class="btn btn-primary btn-sm" onclick="edit({{$master->id_master_kuesioner}})"><i class="fas fa-edit"></i>
                                  </button> 
                                  <!--Delete -->
                                  <button class="btn btn-danger btn-sm" onclick="deletebc({{$master->id_master_kuesioner}})"><i class="fas fa-trash"></i>
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

          @foreach($pertanyaan as $quiz)
        <!-- Modal Show -->
        <div class="modal fade"  id="show{{$quiz->id_kuesioner}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                        <div class="modal-dialog"  role="document" >
                            <div class="modal-content" >
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"> Data Pertanyaan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table width="100%" cellspacing="30">
                                        <td>
                                        <input type="hidden" name="id_lab" value="{{$quiz->id_kuesioner}}">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Data Pertanyaan</label>
                                            <input type="text" class="form-control" id="nama_prodi" name="nama_prodi"
                                                value="{{$quiz->type_kuesioner}}" readonly>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Delete -->
                    {{-- <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Hapus Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin menghapus data pertanyaan?</b>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                                    <a href="/admin/masterpertanyaan/{{$quiz->id_detail_kuesioner}}/delete"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Ya</button></a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- End Modal Delete -->

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

                    <!-- //Update -->
                    {{-- <div class="modal fade" id="update{{$quiz->id_kuesioner}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Pertanyaan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                  <form action="/admin/masterpertanyaan/update" method="POST" enctype="multipart/form-data">
                                  <input type="hidden" name="id_kuesioner" value="{{$quiz->id_kuesioner}}">
                                    {{ csrf_field() }}
                                        
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Data Pertanyaan</label>
                                    <input type="text" class="form-control" id="type_kuesioner" name="type_kuesioner" value="{{$quiz->type_kuesioner}}" placeholder="">
                                </div>

                    
	      	            <div class="modal-footer">
		                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		                      <button type="submit" class="btn btn-success">Simpan</button>
		                  </div>
                      </form>
                                </div>
                            </div>
                        </div>
                    </div> --}}
        @endforeach

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
                  <form action="/admin/pertanyaan/soal/create" method="POST">
                {{csrf_field()}}
                {{-- <input type="text" class="form-control" id="id_detail_kuesioner" name="id_detail_kuesioner" value="{{$id_detail_kuesioner}}" hidden> --}}
                <div class="form-group">
                  <label for="id_jenis" class="font-weight-bold text-dark">Jenis Pertanyaan</label>
                              <select name="id_jenis" id="kuesioner" class="custom-select" required>
                                  <option value="">-- Pilih Jenis Kuesioner --</option>
                                  @foreach($jenis as $jeniss)
                                  <option value="{{$jeniss->id_jenis}}">{{$jeniss->jenis}}</option>
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
                  <input type="text" class="form-control" id="oopsi3" name="opsi3" placeholder="">
                </div>
                <div class="form-group" id="opsi4" style="display: none;">
                  <label class="font-weight-bold text-dark">Opsi 4</label>
                  <input type="text" class="form-control" id="oopsi4" name="opsi4" placeholder="">
                </div>
                <div class="form-group" id="opsi5" style="display: none;">
                  <label class="font-weight-bold text-dark">Opsi 5</label>
                  <input type="text" class="form-control" id="oopsi5" name="opsi5" placeholder="">
                </div>
                <div class="form-group" id="opsi6" style="display: none;">
                  <label class="font-weight-bold text-dark">Opsi 6</label>
                  <input type="text" class="form-control" id="opsi6" name="opsi6" placeholder="">
                </div>
                <div class="form-group" id="opsi7" style="display: none;">
                  <label class="font-weight-bold text-dark">Opsi 7</label>
                  <input type="text" class="form-control" id="opsi7" name="opsi7" placeholder="">
                </div>
                <div class="form-group" id="opsi8" style="display: none;">
                  <label class="font-weight-bold text-dark">Opsi 8</label>
                  <input type="text" class="form-control" id="opsi8" name="opsi8" placeholder="">
                </div>
                <div class="form-group" id="opsi9" style="display: none;">
                  <label class="font-weight-bold text-dark">Opsi 9</label>
                  <input type="text" class="form-control" id="opsi9" name="opsi9" placeholder="">
                </div>
                <div class="form-group" id="opsi10" style="display: none;">
                  <label class="font-weight-bold text-dark">Opsi 10</label>
                  <input type="text" class="form-control" id="opsi10" name="opsi10" placeholder="">
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
          <form action="/admin/pertanyaan/soal/update/" method="POST" id="edit-pertanyaan-form">
            {{csrf_field()}}
            {{-- <input type="text" class="form-control" id="edit_id_kuesioner" name="id_kuesioner" value="{{$id_kuesioner}}" hidden> --}}
            <div class="form-group">
              <label for="id_jenis" class="font-weight-bold text-dark">Jenis Pertanyaan</label>
                          <select name="edit_id_jenis" id="edit_id_jenis" class="custom-select" required>
                              <option value="">-- Pilih Jenis Kuesioner --</option>
                              @foreach($jenis as $opsi)
                              <option value="{{$opsi->id_jenis}}">{{$opsi->jenis}}</option>
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
              <input type="text" class="form-control" id="eedit_opsi3" name="edit_opsi3" placeholder="">
            </div>
            <div class="form-group" id="edit_opsi4" style="display: none;">
              <label class="font-weight-bold text-dark">Opsi 4</label>
              <input type="text" class="form-control" id="eedit_opsi4" name="edit_opsi4" placeholder="">
            </div>
            <div class="form-group" id="edit_opsi5" style="display: none;">
              <label class="font-weight-bold text-dark">Opsi 5</label>
              <input type="text" class="form-control" id="eedit_opsi5" name="edit_opsi5" placeholder="">
            </div>
            <div class="form-group" id="edit_opsi6" style="display: none;">
              <label class="font-weight-bold text-dark">Opsi 6</label>
              <input type="text" class="form-control" id="eedit_opsi6" name="edit_opsi6" placeholder="">
            </div>
            <div class="form-group" id="edit_opsi7" style="display: none;">
              <label class="font-weight-bold text-dark">Opsi 7</label>
              <input type="text" class="form-control" id="eedit_opsi7" name="edit_opsi7" placeholder="">
            </div>
            <div class="form-group" id="edit_opsi8" style="display: none;">
              <label class="font-weight-bold text-dark">Opsi 8</label>
              <input type="text" class="form-control" id="eedit_opsi8" name="edit_opsi8" placeholder="">
            </div>
            <div class="form-group" id="edit_opsi9" style="display: none;">
              <label class="font-weight-bold text-dark">Opsi 9</label>
              <input type="text" class="form-control" id="eedit_opsi9" name="edit_opsi9" placeholder="">
            </div>
            <div class="form-group" id="edit_opsi10" style="display: none;">
              <label class="font-weight-bold text-dark">Opsi 10</label>
              <input type="text" class="form-control" id="eedit_opsi10" name="edit_opsi10" placeholder="">
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
    function deletebc(id){
        $("#form-delete-kuesioner").attr("action", "/admin/pertanyaan/soal/"+id+"/delete");
        $('#deleteModal').modal('show');
    }

    function edit(id){
    $("#bodyEdit").hide();
    $("#loadingEdit").show();
    $('#update').modal('show');
    jQuery.ajax({
      url: "/admin/pertanyaan/soal/"+id+"/edit",
      method: 'get',
      success: function(result){
        let opsi = 1;
        let count = 1;
        console.log(result);
            $("#edit_id_jenis").val(result.detail_kuesioner['id_jenis']);
            $("#edit_pertanyaan").val(result.detail_kuesioner['pertanyaan']);
            $("#edit-pertanyaan-form").attr("action", "/admin/pertanyaan/soal/"+result.detail_kuesioner['id_detail_kuesioner']+"/update");
            if(result.detail_kuesioner['id_jenis'] == 1){
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

              $('#edit_id_jenis').change(function() {
                if($('#edit_id_jenis').val() == 1){
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
              if($('#edit_id_jenis').val() == 1){
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
        if($('#kuesioner').val() == 1){
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
        if($('#essay').val() == 1){
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