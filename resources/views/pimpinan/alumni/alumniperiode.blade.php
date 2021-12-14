@extends('layoutpimpinan.layout')
@section('title', 'Periode Lulusan Alumni')
@section('collapse5')
    collapse-item active
@endsection

@section('active2')
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
              <h6 class="m-0 font-weight-bold text-primary">Data Periode Lulusan Alumni</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width: fit-content;">No.</th>
                      <th style="text-align:center;">Tahun Lulus </th>
                      <th style="text-align:center;">Periode</th>
                      <th style="text-align:center;">Data Alumni </th>
                    </tr>
                  </thead>

                  <tbody>
                        @foreach ($periodealumni as $periodes)
                            <tr class="success">
                                <td style="width: 5%;">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $periodes->relasiPeriodealumnitoTahun->tahun_periode }}</td>
                                <td class="text-center">{{ $periodes->relasiPeriodealumnitoPeriode->periode }}</td>
                                <td class="text-center">
                                    <a href="/pimpinan/alumni/{{$periodes->id_periode_alumni}}">
                                        <button type="button" class="btn btn-primary btn-sm text-center"><i class="fas fa-eye">Lihat Data Alumni</i></button></a>
                                </td>
                            </tr>
                        @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          @foreach($periodealumni as $datass)
        <!-- Modal Show -->
        <div class="modal fade"  id="show{{$datass->id_periode_alumni}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                        <div class="modal-dialog"  role="document" >
                            <div class="modal-content" >
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Periode Lulusan Alumni</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table width="100%" cellspacing="30">
                                        <td>
                                        <input type="hidden" name="id_lab" value="{{$datass->id_periode_alumni}}">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Tahun</label>
                                            <input type="text" class="form-control" id="periode" name="periode"
                                                value="{{$datass->relasiPeriodealumnitoTahun->tahun_periode}}" readonly>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label class="font-weight-bold text-dark">Periode</label>
                                            <input type="text" class="form-control" id="periode" name="periode"
                                                value="{{$datass->relasiPeriodealumnitoPeriode->periode}}" readonly>
                                        </div> --}}
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
        @endforeach


    </div>

@endsection
