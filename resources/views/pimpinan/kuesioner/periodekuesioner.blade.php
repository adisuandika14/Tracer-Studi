@extends('layoutpimpinan.layout')
@section('title', 'Periode Kuesioner')
@section('active3')
      nav-item active
@endsection

@section('content')


<div class="container">  
  
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

    <!-- {{-- notifikasi form validasi --}} -->
    @if ($errors->has('file'))
    <span class="invalid-feedback" role="alert">
      <strong>{{ $errors->first('file') }}</strong>
    </span>
    @endif
  
    <!-- {{-- notifikasi sukses --}} -->
    @if ($sukses = Session::get('sukses'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button> 
      <strong>{{ $sukses }}</strong>
    </div>
    @endif
  </div>

    <!-- Begin Page Content -->
    <div class="container-fluid">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar Periode Kuesioner</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width: fit-content;">No.</th>
                      <th style="text-align:center;">Tahun </th>
                      <th style="text-align:center;">Periode </th>
                      <th style="text-align:center;">Tanggal Mulai </th>
                      <th style="text-align:center;">Tanggal Selesai </th>
                      <th style="text-align:center;">Status </th>
                      <th style="text-align:center;">Data Kuesioner</th>
                    </tr>
                  </thead>

                  <tbody>
                        @foreach ($periode as $periodes => $status)
                            <tr class="success">
                                <td style="width: fit-content;">{{ $loop->iteration }}</td>
                                <td>{{ $status->relasiPeriodekuesionertoTahun->tahun_periode }}</td>
                                <td>{{ $status->relasiPeriodekuesionertoPeriode->periode }}</td>
                                <td style="width: fit-content;">{{ $status->tanggal_mulai }}</td>
                                <td style="width: fit-content;">{{ $status->tanggal_selesai }}</td>
                                <td style="width: fit-content;" class="text-center">
                                    <label class="switch"  >
                                        @if($status->status == "Aktif")
                                        <button type="button" class="btn btn-primary btn-sm text-center">Aktif</button></a>
                                        @else
                                        <button type="button" class="btn btn-warning btn-sm text-center">Tidak Aktif</button></a>
                                        @endif
                                      <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <a href="/pimpinan/kuesioner/{{$status->id_periode_kuesioner}}">
                                        <button type="button" class="btn btn-primary btn-sm text-center"><i class="fas fa-eye">Lihat Data Kuesioner</i></button></a>
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

        @endforeach
    </div>

@endsection