@extends('layoutpimpinan.layout')
@section('title', 'Kuesioner')
@section('active3')
      nav-item active
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

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
              <h6 class="m-0 font-weight-bold text-primary">Data Kuesioner</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                    
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    
                  <thead>
                  
                    <tr>
                      <th>No.</th>
                      <th style="text-align:center;">Kuesioner</th>
                      <!-- <th style="text-align:center;">Pertanyaan</th> -->
                      <!-- <th style="text-align:center;">Status</th> -->
                      <th style="text-align:center; width: 10%;">Action</th>
                    </tr>
                  </thead>

                  <tbody>
                  @foreach ($kuesioner as $quiz)
                    <tr class="success">
                        <td style="width: 5%;">{{ $loop->iteration }}</td>
                            <td >{{ $quiz->type_kuesioner }}</td>
                            <!-- <td style="width: 15%" >
                            {{ $quiz->status }}
                            </td> -->
                          
                            <td style="text-align:center;">
                                <!-- Show -->
                                <a  href="/pimpinan/kuesioner/showkuesioner/{{$quiz->id_kuesioner}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                      class="fas fa-eye fa-sm text-white-50"></i > Lihat Data</a>
                                <!-- <a data-toggle="modal" data-target="#update{{$quiz->id_kuesioner}}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i
                                      class="fas fa-edit fa-sm text-black-50"></i> Edit Status</a> -->
                               
                            </td>
                    </tr>
                    
                    @endforeach
                    <!-- <button type="submit" class="btn btn-success btn-icon-split">
                      <span class="icon text-white-50">
                          <i class="fas fa-check"></i>
                      </span>
                      <span class="text">Simpan</span>
                  </button> -->
                  </tbody>
                  
                  
                </table>
                  <!-- <a href="#" class="btn btn-success btn-icon-split">
                      <span class="icon text-white-50">
                          <i class="fas fa-check"></i>
                      </span>
                      <span class="text">Split Button Success</span>
                  </a> -->
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
                    <!-- <div class="modal fade" id="update{{$datas->id_kuesioner}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Status Kuesioner</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                  <form action="/pimpinan/kuesioner/update" method="POST" enctype="multipart/form-data">
                                  <input type="hidden" name="id_kuesioner" value="{{$datas->id_kuesioner}}">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                      <label class="font-weight-bold text-dark">Kuesioner</label>
                                      <input type="text" class="form-control" id="type_kuesioner" name="type_kuesioner" value="{{$datas->type_kuesioner}}" placeholder="">
                                    </div>
                                    <div class="form-group">
                                      <label for="status" class="font-weight-bold text-dark">Edit Status Kuesioner</label>
                                                  <select name="status" id="status" class="custom-select" required>
                                                      <option value="">-- Pilih Status --</option>
                                                      @foreach($status as $st)
                                                      <option value="{{$st}}">{{$st}}</option>
                                                      @endforeach
                                                  </select>
                                    </div>

                                    <div class="form-group">
                                      <label for="status" id="status" class="font-weight-bold text-dark">Jenis Pertanyaan</label>
                                      <select class="custom-select" required>
                                          <option value="" >-- Pilih Status --</option>
                                          @foreach ($status as $st)
                                          <option value="{{$st}}" >{{$st}}</option>
                                          @endforeach
                                      </select>
                                    </div>
                                  
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                      <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                  </form>
                                </div>
                            </div>
                        </div>
                    </div> -->
        @endforeach

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


