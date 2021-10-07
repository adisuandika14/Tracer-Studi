@extends('layoutpimpinan.layout')
@section('title', 'Kuesioner')
@section('active8')
      nav-item active
@endsection



@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Tracer Studi</h6>
        </div>
        <div class="card-body">
        @if (Session::has('error'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <i class="fa fa-times"></i> 
                    {{ Session::get('error') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                @endif
                @if (isset($errors) && $errors->any())
                  <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                      {{$error}}
                    @endforeach
                  </div>
                @endif
                @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check"></i> {{Session::get('success')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                  </div>
                @endif
                @if (!empty($success))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check"></i> {{$success}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                  </div>
                @endif
            <div class="table-responsive">
            <div class="small mb-1">Advanced Search </div>
            <!-- <a style="margin-bottom: 10px;" class= "btn btn-warning dropdown-toggle text-white" id="toggles" ><i class="fas fa-search"></i> Advanced Search</a> -->
            <!-- <form  method="GET"> -->
                <table class="table" style="width: 85%;" id="example" cellspacing="0">
                    <tr>
                        <td style="width: 5%;">
                            <div class="form-group" >
                                <select name="prodi" class="custom-select" id="prodi" required>
                                    <option selected=" ">-- Pilih Program Studi --</option>
                                    @foreach ($prodi as $prodis)
                                    <option  value="{{$prodis->nama_prodi}}">{{$prodis->nama_prodi}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td style="width: 5%;">
                            <div class="form-group">  
                                <select name="angkatan" class="custom-select" id="angkatan" required>
                                    <option selected="selected">-- Pilih Tahun Angkatan --</option>
                                    @foreach ($angkatan as $angkatans)
                                        @if($angkatans->id_angkatan)   
                                            <option value="{{$angkatans->tahun_angkatan}}">{{$angkatans->tahun_angkatan}}</option>
                                        @else
                                            <option value="{{ $angkatans->id_angkatan }}">{{$angkatans->tahun_angkatan}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td style="width: 5%;">
                            <!-- <button id="toggles"  class="btn btn-info btn-icon-split">
                                <span  class="icon text-white-50" type="submit">
                                    <i  class="fas fa-search"></i>
                                </span>
                                <span class="text">Search</span>
                            </button> -->
                            <a style="margin-bottom: 10px;" class= "btn btn-info text-white" id="toggles" > <i class="fas fa-search"></i> Advanced Search</a>
                        </td>
                    </tr>
                </table>
            <!-- </form>  -->
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" >
                <thead>
                <tr>
                    <th>No.</th>
                    <th style="text-align:center;">Nama Alumni</th>
                    <th style="text-align:center;">Program Studi</th>
                    <th style="text-align:center;">Angkatan</th>
                    <th style="text-align:center;">Tahun Lulus</th>
                    <th style="text-align:center;">Pertanyaan</th> 
                    <th style="text-align:center;">Jawaban</th> 
                </tr>
                </thead>

                <tbody>
                @foreach($detailjawaban as $details)
                <tr class="success">
                    <td style="width: 1%;">{{ $loop->iteration }}</td>
                        <td style="width: 15%;">{{ $details->relasiJawabantoAlumni->nama_alumni }}</td>
                        <td style="width: 10%;">{{ $details->relasiJawabantoAlumni->relasiAlumnitoProdi->nama_prodi }}</td>
                        <td style="width: 5%;" >{{ $details->relasiJawabantoAlumni->relasiAlumnitoAngkatan->tahun_angkatan }}</td>
                        <td style="width: 7%;" >{{ $details->relasiJawabantoAlumni->tahun_lulus }}</td>
                        <td style="width: 20%;">{{ $details->relasiJawabantoDetail->pertanyaan}}</td>
                        <td style="width: 10%" >{{ $details->jawaban }}</td>
                </tr>
                @endforeach 
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endsection


@section('custom_javascript')
<script>
    $(document).ready(function() {
    var dta = $('#dataTable').DataTable({
        scrollY:        200,
        scrollCollapse: true,
        paging:         true,
        autoWidth: false,
        searchPanes: {
            clear: false,
            viewTotal: true,
            columns: [3, 4]
        },
        dom: 'Plfrtip',
        columnDefs: [
            {
                orderable: false,
                searchPanes: {
                    show: true,
                    options: [
                        @foreach ($detailjawaban as $prodis)
                        {
                            label: '{{$prodis->nama_prodi}} ',
                            value: function(rowData, rowIdx) {
                                return rowData[3].match('{{$prodis->nama_prodi}}');
                            }
                        },
                        @endforeach
                    ]
                },
                targets: [3]
            },
            {
                searchPanes: {
                    show: true,
                    options: [
                        @foreach ($angkatan as $angkatans)
                        {
                            label: '{{$angkatans->tahun_angkatan}}',
                            value: function(rowData, rowIdx) {
                                return rowData[4].match('{{$angkatans->tahun_angkatan}}');
                            }
                        },
                        @endforeach
                    ]
                },
                targets: [4]
            },
            ,
        order: [[ 1, 'desc' ]]
    });
    dta.searchPanes.container().prependTo(dta.table().container());
    dta.searchPanes.resizePanes();
    dta.searchPanes.container().hide();
    $('#toggles').on('click', function () {
        dta.searchPanes.container().toggle();
    });
    });
</script>
@endsection