@extends('layoutadmin.layout')
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
              <h6 class="m-0 font-weight-bold text-primary">Data Kuesioner Pengguna Lulusan</h6>
            </div>
            <div class="card-body">
              <div class="form-group" style="width: 250px;">
                <label class=" font-weight-bold text-grey">Periode Kuesioner</label>
                  <select name="periode" class="custom-select " style="width:250px; " id="periode">
                      <option selected value="">-- Pilih Periode Kueisoner --</option>
                      @foreach ($periode as $tahun )
                          <option value="{{$tahun->id_tahun_periode}}" @if($tahun->id_tahun_periode == $id_tahun_periode) selected @endif>{{ $tahun->tahun_periode }}
                          </option>
                      @endforeach
                  </select>
              </div>

              {{-- SPINNER --}}
              <div id="loading" class="text-center mt-5" style="display:none;">
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
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th style="text-align:center;">Program Studi</th>
                        <th style="text-align:center;">Action</th>
                      </tr>
                    </thead>

                    <tbody>
                    @foreach ($prodi as $prodis)
                    <tr class="success">
                      <td style="width: 5%;">{{ $loop->iteration }}</td>
                          <td >{{ $prodis->nama_prodi }}</td>
                          <td style="width: 10%; align:center;">
                              <!-- Show -->
                                <button type="button" id="show_kuesioner_btn" onclick="show_kuesioner({{$prodis->id_prodi}})" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
    @foreach($prodi as $prodis)
        <!-- Modal Delete -->
        <div class="modal fade" id="delete{{$prodis->id_prodi}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Hapus Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin menghapus Program Studi ?</b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                    <a href="/admin/kuesioner/{{$prodis->id_prodi}}/delete"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Ya</button></a>
                </div>
            </div>
        </div>
    </div>


                    <!-- //Update -->
                    <div class="modal fade" id="update{{$prodis->id_prodi}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                  <input type="hidden" name="id_prodi" value="{{$prodis->id_prodi}}">
                                    {{ csrf_field() }}
                                        
                                    <div class="form-group">
                                      <label class="font-weight-bold text-dark">Kuesioner</label>
                                      <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" value="{{$prodis->nama_prodi}}" placeholder="">
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
                        <input type="text" class="form-control" id="create_id_periode" value="{{$id_tahun_periode}}" name="create_id_periode" placeholder="" hidden>
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



@endsection

@section('custom_javascript')
<script>
  function show_kuesioner(id_prodi){
    window.location.href = "/admin/kuesioner/stakeholder/detail/"+id_prodi+"/"+$('#periode').val();
  };
  //Periode
  $('#periode').change(function(){
    $('#ganti').hide();
    $('#loading').show();
    jQuery.ajax({
      url: "{{url('admin/kuesioner/stakeholder/filter/')}}" ,
      method: 'post',
      data: {
          _token: $('#signup-token').val(),
          id_tahun_periode: $(this).val()
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

