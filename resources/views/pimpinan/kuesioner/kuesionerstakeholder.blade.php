@extends('layoutpimpinan.layout')
@section('title', 'Kuesioner Stakeholder')
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
</div>


@endsection

@section('custom_javascript')
<script>
  function show_kuesioner(id_prodi){
    window.location.href = "/pimpinan/kuesioner/stakeholder/detail/"+id_prodi+"/"+$('#periode').val();
  };
  //Periode
  $('#periode').change(function(){
    $('#ganti').hide();
    $('#loading').show();
    jQuery.ajax({
      url: "{{url('pimpinan/kuesioner/stakeholder/filter/')}}" ,
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

