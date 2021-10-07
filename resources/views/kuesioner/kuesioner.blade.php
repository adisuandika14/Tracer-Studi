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
        <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Admin Profile</h1>
        </div>
        <hr style="margin-top: 20px" class="sidebar-divider my-0"> -->

        <!-- <h1 class="h3 mb-2 text-gray-800">Tables</h1>
          <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p> -->

          <!-- DataTales Example -->
          <!-- Copy drisini -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Data Pertanyaan</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#create"><i
                            class="fas fa-plus"></i> Tambah Kuesioner
                    </button>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th style="text-align:center;">Pertanyaan</th>
                      <!-- <th style="text-align:center;">Pertanyaan</th> -->
                      {{-- <th style="text-align:center;">Status</th> --}}
                      <th style="text-align:center;">Action</th>
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

                            <td style="width: 10%">
                                <!-- Show -->
                                <a style="margin-right:7px" href="/admin/kuesioner/showkuesioner/{{$quiz->id_kuesioner}}">
                                    <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>
                                    
                                <!-- Edit -->
                                <button class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#update{{$quiz->id_kuesioner}}"><i class="fas fa-edit"></i>
                                </button>
                                <!--Delete -->
                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#delete{{$quiz->id_kuesioner}}"><i class="fas fa-trash"></i>
                                </button>
                            </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
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

                      <!-- <div class="form-group">
                        <label for="id_kuesioner" class="font-weight-bold text-dark">Program Studi</label>
                                    <select name="id_kuesioner" id="kuesioner" class="custom-select" required>
                                        <option value="">-- Pilih Jenis Kuesioener --</option>
                                        @foreach($kuesioner as $kuesioners)
                                        <option value="{{$kuesioners->id_kuesioner}}">{{$kuesioners->type_kuesioner}}</option>
                                        @endforeach
                                    </select>
                      </div> -->

                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Pertanyaan</label>
                        <input type="text" class="form-control" id="type_kuesioner" name="type_kuesioner" placeholder="">
                      </div>
                      <!-- <div class="form-group" id="opsi1" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 1</label>
                        <input type="text" class="form-control" id="opsi1" name="opsi1" placeholder="">
                      </div>
                      <div class="form-group" id="opsi2" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 2</label>
                        <input type="text" class="form-control" id="opsi2" name="opsi2" placeholder="">
                      </div>
                      <div class="form-group" id="opsi3" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 3</label>
                        <input type="text" class="form-control" id="opsi3" name="opsi3" placeholder="">
                      </div>
                      <div class="form-group" id="opsi4" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 4</label>
                        <input type="text" class="form-control" id="opsi4" name="opsi4" placeholder="">
                      </div>
                      <div class="form-group" id="opsi5" style="display: none;">
                        <label class="font-weight-bold text-dark">Opsi 5</label>
                        <input type="text" class="form-control" id="opsi5" name="opsi5" placeholder="">
                      </div>
                      <button type="button" id="btnTambahOpsi" class="btn btn-primary" style="display: none;">Tambah Opsi</button>-->
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

<!-- @section('custom_javascript')
<script>
//Jabatan Onclick Listener
    let id_opsi;
    $('#kuesioner').change(function() {
        if($('#kuesioner').val() == 11){
          id_opsi = 2;
          $('#opsi1').fadeIn();
          $('#btnTambahOpsi').fadeIn();
        }else if($('#kuesioner').val() == 12 || $('#kuesioner').val() == ""){
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
@endsection -->


