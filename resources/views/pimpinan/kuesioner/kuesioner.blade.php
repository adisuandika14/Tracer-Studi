@extends('layoutpimpinan.layout')
@section('title', 'Kuesioner')
@section('content')
@section('active3')
      nav-item active
@endsection

<!-- Begin Page Content -->
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
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Data Pertanyaan</h6>
            </div>
            <div class="card-body">
              
              <div class="ganti" id="ganti">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th style="text-align:center;">Pertanyaan</th>
                        <th style="text-align:center;">Lihat Data</th>
                      </tr>
                    </thead>

                    <tbody>
                    @foreach ($kuesioner as $quiz)
                      <tr class="success">
                          <td style="width: 5%;">{{ $loop->iteration }}</td>
                              <td >{{ $quiz->type_kuesioner }}</td>
                              <!-- <td  >{{ $quiz->pertanyaan }}</td> -->
                              {{-- <td style="width: 10%" >{{ $quiz->status }}</td> --}}
                              
                              <!-- <td>
                              <img src="{{asset('storage/app/public/image/post'.$quiz->thumbnail) }}" alt="Image 10"  width="300" height="300" />
                              </td> -->
                              <!-- <td style="width: 30px;">{{ $quiz->thumbnail }}</td>
                              <td style="width: 30px;">{{ $quiz->lampiran }}</td>
                                  -->

                              <td style="width: 10%; align:center;">
                                  <!-- Show -->
                                  <a href="/pimpinan/kuesioner/showkuesioner/{{$quiz->id_kuesioner}}">
                                      <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye">Lihat Data</i></button></a>
                                   
                              </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
    
    @foreach($kuesioner as $datas)
        <!-- Modal Delete -->
        <div class="modal fade" id="delete{{$datas->id_kuesioner}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Hapus Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin menghapus Kuesioner ?</b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                    <a href="/admin/kuesioner/{{$datas->id_kuesioner}}/delete"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Ya</button></a>
                </div>
            </div>
        </div>
    </div>
    

                    <!-- //Update -->
                    <div class="modal fade" id="update{{$datas->id_kuesioner}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Kuesioner</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                  <form action="/admin/kuesioner/update" method="POST" enctype="multipart/form-data">
                                  <input type="hidden" name="id_kuesioner" value="{{$datas->id_kuesioner}}">
                                    {{ csrf_field() }}
                                        
                                    <div class="form-group">
                                      <label class="font-weight-bold text-dark">Kuesioner</label>
                                      <input type="text" class="form-control" id="type_kuesioner" name="type_kuesioner" value="{{$datas->type_kuesioner}}" placeholder="">
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                      <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                  </form>
                                </div>
                            </div>
                        </div>
                    </div>
        @endforeach
                    
                    
    

                <!-- Create -->
                <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	          <div class="modal-dialog" role="document">
	             <div class="modal-content">
	                <div class="modal-header">
	                  <h5 class="modal-title" id="exampleModalLabel">Masukkan Kuesioenr</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                      <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <div class="modal-body">
	      	          <form action="/admin/kuesioner/create" method="POST">
                      {{csrf_field()}}
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Pertanyaan</label>
                        <input type="text" class="form-control" id="type_kuesioner" name="type_kuesioner" placeholder="">
                        <input type="text" class="form-control" id="create_id_periode" value="{{$id_periode_kuesioner}}" name="create_id_periode" placeholder="" hidden>
                      </div>
                      <div class="modal-footer">
		                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		                      <button type="submit" class="btn btn-success">Simpan</button>
		                  </div>
                      </form>
                  </div>
	              </div>
	            </div>
	          </div>
    </div>

{{-- PICK FROM BANK SOAL --}}
<div class="modal fade modal-fullscreen" id="pilih_dari_bank_soal_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
     <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pilih Pertanyaan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        {{-- SPINNER --}}
        <div id="loading_bank_soal" class="text-center mt-5" style="display:none;">
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

        <div id="tabel_bank_soal">
          <div class="modal-body">
            <form action="/admin/kuesioner/create" method="POST" id="simpan_bank_soal_form">
              {{csrf_field()}}
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="text-align: center; width:9%;">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="pilih_semua_soal">
                          <label class="form-check-label" for="flexCheckDefault">
                            Pilih semua
                            </label>
                        </div>
                      </th>
                      <th style="text-align:center;">Pertanyaan</th>
                    </tr>
                  </thead>
                  <tbody id="bank_soal_data">
                  @foreach ($kuesioner as $quiz)
                    <tr class="success">
                      <td style="text-align: center;">
                        <div class="form-check">
                          <input class="form-check-input bank_soal_checkbox" type="checkbox" id="soal">
                        </div>
                      </td>
                      <td >{{ $quiz->type_kuesioner }}</td>     
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-success" id="button_submit_bank_soal">Simpan</button>
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>
</div>

@endsection

@section('custom_javascript')
<script>

  //Periode
  $('#periode').change(function(){
    $('#create_id_periode').val($(this).val());
    $('#ganti').hide();
    $('#loading').show();
    jQuery.ajax({
      url: "{{url('pimpinan/kuesioner/filter/')}}" ,
      method: 'post',
      data: {
          _token: $('#signup-token').val(),
          id_periode: $(this).val()
      },
      success: function (result) {
        console.log(result);
        $('#loading').hide();
          $('.ganti').html(result.hasil);
          $('#ganti').show();
      }
  });
  })
</script>
@endsection

