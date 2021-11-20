@extends('layoutalumni.layout')
@section('title', 'Detail Kuesioner')
@section('content')
@section('active3')
      nav-item active
@endsection

<!-- Begin Page Content -->
<div class="container-fluid">
<h1 class="h3 mb-4 text-gray-800"></h1>

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
              <h6 class="m-0 font-weight-bold text-primary">Kuesioner</h6>
    </div>
        <div class="card-body">
            <div class="table-responsive">
            <div class="container-fluid" style="align-content: center;">
            <form method="POST" action="{{ route('simpan-kuesioner') }}">
              {{ csrf_field() }}

                        @foreach($kuesioners as $kuesioner)
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <p> {{ $loop->iteration }}. {{$kuesioner->pertanyaan}}</p>
                                <input @if($kuesioner->id_jenis == 4) type="date" @else type="text" @endif" class="form-control"  id="{{$kuesioner->id_detail_kuesioner}}" name= "{{$kuesioner->id_detail_kuesioner}}" value="" placeholder="@if($kuesioner->id_jenis == 4) Masukkan Tanggal @else Text Jawaban Singkat @endif" @if($kuesioner->id_jenis == 1 || $kuesioner->id_jenis == 3) hidden @endif>
                                @if($kuesioner->id_jenis == 1)
                                    @foreach ($opsi as $opsis)
                                    @if($kuesioner->id_detail_kuesioner == $opsis->id_detail_kuesioner)
                                        <div class="form-check">
                                            <input class="form-check-input" name="{{$kuesioner->id_detail_kuesioner}}" type="radio" value="{{$opsis->opsi}}" onchange="jawabRadio({{$kuesioner->id_detail_kuesioner}},{{$opsis->id_opsi}})" id="flexRadioDefault{{$kuesioner->id_detail_kuesioner}}">
                                            <label class="form-check-label" for="flexRadioDefault{{$kuesioner->id_detail_kuesioner}}">
                                                {{$opsis->opsi}}
                                            </label>
                                        </div>
                                    @endif
                                    @endforeach
                                @endif
                                @if($kuesioner->id_jenis == 3)
                                    @foreach ($opsi as $opsis)
                                        @if($kuesioner->id_detail_kuesioner == $opsis->id_detail_kuesioner)
                                            <div class="form-check">
                                                <input class="form-check-input" name="{{$kuesioner->id_detail_kuesioner}}[]" value="{{$opsis->id_opsi}}" type="checkbox" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    {{$opsis->opsi}}
                                                </label>gi
                                            </div>
                                        @endif
                                    @endforeach
                                @endif

                            </div>
                            <div class="modal-footer">

		                        </div>
                        </div>
                        @endforeach

                </div>
                <div>

            </div>
            <button type="submit" class="btn btn-success" style="float:right">Simpan</button>
            </form>
        </div>
    </div>
</div>
</div>



@endsection



@section('custom_javascript')
<script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="../src/jquery.paginate.js"></script>

<script>

    // $('.form-check-input').change(function (){
    //     alert($('[name="87[]"]').val());
    // })

    function jawabRadio(id_detail_kuesioner, id_opsi){

        document.getElementById(id_detail_kuesioner).value=id_opsi;
    }

</script>

<script type="text/javascript">

<script>
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
            if(result.detail_kuesioner['id_jenis'] == 1){
              $("#edit_opsi1").prop('required',true);
              $("#edit_opsi2").prop('required',true);
              opsi=1
              result.opsis.forEach(element => {
                $("#eedit_opsi"+opsi).val(element['opsi']);
                $("#edit_opsi"+opsi).fadeIn();
                opsi = opsi + 1;
                if(opsi<5){
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
                    if(opsi<5){
                      $("#edit_btnTambahOpsi").show();
                    }
                  });
                }else if($('#edit_id_jenis').val() == 2 || $('#edit_id_jenis').val() == ""){
                  $("#edit_opsi1").prop('required',false);
                  $("#edit_opsi2").prop('required',false);
                  for(let i = 1; i<=5; i++){
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
                for(let i = 1; i<=5; i++){
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
                for(let i = 1; i<=5; i++){
                  $('#edit_opsi'+i).fadeOut();
                }
                $('#edit_btnTambahOpsi').fadeOut();
              }
            });
            $('#edit_btnTambahOpsi').click(function(){
              $('#edit_opsi'+opsi).fadeIn();
              opsi = opsi + 1;
              if(opsi == 6){
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
          for(let i = 1; i<=5; i++){
            $('#opsi'+i).fadeOut();
          }
          $('#btnTambahOpsi').fadeOut();
        }
    });

    $('#btnTambahOpsi').click(function(){
      $('#opsi'+id_opsi).fadeIn();
      id_opsi = id_opsi + 1;
      if(id_opsi == 6){
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
          for(let i = 1; i<=5; i++){
            $('#opsi'+i).fadeOut();
          }
          $('#btnTambahOpsi').fadeOut();
        }
    });

  </script>
@endsection
