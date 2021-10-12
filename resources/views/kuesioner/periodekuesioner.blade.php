@extends('layoutadmin.layout')
@section('title', 'Master Periode')



@section('active9')
      nav-item active
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar Tahun</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#create"><i
                            class="fas fa-plus"></i> Tambah Tahun Periode
                    </button>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width: fit-content;">No.</th>
                      <th style="text-align:center;">Tahun </th>
                      <th style="text-align:center;">Periode </th>
                      <th style="text-align:center;">Aksi</th>
                    </tr>
                  </thead>

                  <tbody>
                        @foreach ($periode as $periodes)
                            <tr class="success">
                                <td style="width: fit-content;">{{ $loop->iteration }}</td>
                                <td>{{ $periodes->relasiPeriodekuesionertoTahun->tahun_periode }}</td>
                                <td>{{ $periodes->relasiPeriodekuesionertoPeriode->periode }}</td>

                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#show{{$periodes->id_tahun_periode}}"><i class="fas fa-eye"></i>
                                    </button>
                                    <!-- Edit -->
                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#update{{$periodes->id_tahun_periode}}"><i class="fas fa-edit"></i>
                                    </button>
                                    <!--Delete -->
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{$periodes->id_tahun_periode}}"><i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          @foreach($periode as $datass)
        <!-- Modal Show -->
        <div class="modal fade"  id="show{{$datass->id_tahun_periode}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                        <div class="modal-dialog"  role="document" >
                            <div class="modal-content" >
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"> Data periode</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table width="100%" cellspacing="30">
                                        <td>
                                        <input type="hidden" name="id_lab" value="{{$datass->id_tahun_periode}}">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Tahun periode</label>
                                            <input type="text" class="form-control" id="periode" name="periode"
                                                value="{{$datass->periode}}" readonly>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Delete -->
                    <div class="modal fade" id="delete{{$datass->id_tahun_periode}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Hapus Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin menghapus data Periode?</b>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                                    <a href="/admin/mastertahun/{{$datass->id_tahun_periode}}/delete"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Ya</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Delete -->

                    <!-- //Update -->
                    <div class="modal fade" id="update{{$datass->id_tahun_periode}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Tahun Periode</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                  <form action="/admin/mastertahun/update" method="POST" enctype="multipart/form-data">
                                  <input type="hidden" name="id_tahun_periode" value="{{$datass->id_tahun_periode}}">
                                    {{ csrf_field() }}
                                        
                                    

                                    <div class="form-group">
                                        <label for="id_tahun_periode" class="font-weight-bold text-dark">Tahun</label>
                                            <select name="id_tahun_periode" id="id_tahun_periode" class="custom-select" required>
                                                <option>-- Pilih Tahun --</option>
                                                @foreach($tahun as $tahuns)
                                                <option value="{{$tahuns->id_tahun_periode}}" @if($tahuns->id_tahun_periode==$tahuns->id_tahun_periode) selected @endif>{{$tahuns->tahun_periode}}</option>
                                                @endforeach
                                            </select>
                                      </div>
                
                                      <div class="form-group">
                                        <label for="id_periode" class="font-weight-bold text-dark">Periode</label>
                                            <select name="id_periode" id="id_periode" class="custom-select" required>
                                                <option>-- Pilih Periode --</option>
                                                @foreach($periodekuesioner as $periode)
                                                <option value="{{$periode->id_periode}}" @if($periode->id_periode==$periode->id_periode) selected @endif>{{$periode->periode}}</option>
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
                    </div>
        @endforeach

    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Periode Kuesioner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/admin/periodekuesioner/create" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                    <label class="font-weight-bold text-dark">Pilih Periode Kuesioner</label>
                    
                    <div class="form-group">
                        <label for="id_tahun_periode" class="font-weight-bold text-dark">Tahun</label>
                            <select name="id_tahun_periode" id="id_tahun_periode" class="custom-select" required>
                                <option>-- Pilih Tahun --</option>
                                @foreach($tahun as $tahuns)
                                <option value="{{$tahuns->id_tahun_periode}}">{{$tahuns->tahun_periode}}</option>
                                @endforeach
                            </select>
                      </div>

                      <div class="form-group">
                        <label for="id_periode" class="font-weight-bold text-dark">Periode</label>
                            <select name="id_periode" id="id_periode" class="custom-select" required>
                                <option>-- Pilih Periode --</option>
                                @foreach($periodekuesioner as $periode)
                                <option value="{{$periode->id_periode}}">{{$periode->periode}}</option>
                                @endforeach
                            </select>
                      </div>

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

@endsection
