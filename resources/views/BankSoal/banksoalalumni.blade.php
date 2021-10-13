@extends('layoutadmin.layout')
@section('title', 'Kuesioner')
@section('content')
@section('active10')
      nav-item active
@endsection
@section('collapse3')
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
          <!-- Copy drisini -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Data Bank Soal</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#create"><i
                            class="fas fa-plus"></i> Tambah Bank Soal
                    </button>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th style="text-align:center;">Pertanyaan</th>
                      <th style="text-align:center;">Action</th>
                    </tr>
                  </thead>

                  <tbody>
                  @foreach ($bank_soal as $quiz)
                    <tr class="success">
                        <td style="width: 5%;">{{ $loop->iteration }}</td>
                            <td >{{ $quiz->pertanyaan }}</td>

                            <td style="width: 10%">
                                <!-- Show -->
                                <a style="margin-right:7px" href="/admin/banksoal/showkuesioner/{{$quiz->id_soal_alumni}}">
                                    <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>
                                    
                                <!-- Edit -->
                                <button class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#update{{$quiz->id_soal_alumni}}"><i class="fas fa-edit"></i>
                                </button>
                                <!--Delete -->
                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#delete{{$quiz->id_soal_alumni}}"><i class="fas fa-trash"></i>
                                </button>
                            </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
    
    @foreach($bank_soal as $datas)
      <!-- Modal Delete -->
      <div class="modal fade" id="delete{{$datas->id_soal_alumni}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  <a href="/admin/banksoal/alumni/{{$datas->id_soal_alumni}}/delete"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Ya</button></a>
              </div>
          </div>
      </div>
  </div>


  <!-- //Update -->
  <div class="modal fade" id="update{{$datas->id_soal_alumni}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Bank Soal</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <form action="/admin/banksoal/alumni/update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_soal_alumni" value="{{$datas->id_soal_alumni}}">
                  {{ csrf_field() }}
                  <div class="form-group">
                    <label class="font-weight-bold text-dark">Edit Bank Soal</label>
                    <input type="text" class="form-control" id="pertanyaan" name="pertanyaan" value="{{$datas->pertanyaan}}" placeholder="">
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
	                  <h5 class="modal-title" id="exampleModalLabel">Masukkan Data Bank Soal</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                      <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <div class="modal-body">
	      	          <form action="/admin/banksoal/alumni/create" method="POST">
                      {{csrf_field()}}
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Pertanyaan</label>
                        <input type="text" class="form-control" id="pertanyaan" name="pertanyaan" placeholder="">
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



