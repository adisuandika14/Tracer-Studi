@extends('layoutadmin.layout')
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
            <div class="small mb-1">Filter Data Tracer </div>
            <!-- <a style="margin-bottom: 10px;" class= "btn btn-warning dropdown-toggle text-white" id="toggles" ><i class="fas fa-search"></i> Advanced Search</a> -->
            {{-- <form  method="POST" action="/admin/tracer/filter">
                @csrf
                <table class="table" style="width: 85%;" id="example" cellspacing="0">
                    <tr>
                        <td style="width: 5%;">
                            <div class="form-group" >
                                <select name="prodi" class="custom-select" id="prodi">
                                    <option selected value="">-- Pilih Program Studi --</option>
                                    @foreach ($prodi as $prodis)
                                        <option  value="{{$prodis->id_prodi}}"
                                            @isset($id_prodi)
                                                @if($prodis->id_prodi == $id_prodi)
                                                    selected
                                                @endif
                                            @endisset
                                            >{{$prodis->nama_prodi}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td style="width: 5%;">
                            <div class="form-group">  
                                <select name="angkatan" class="custom-select" id="angkatan" >
                                    <option selected value="">-- Pilih Tahun Angkatan --</option>
                                    @foreach ($angkatan as $angkatans)
                                        <option value="{{ $angkatans->id_angkatan }}"
                                            @isset($id_angkatan)
                                                @if($angkatans->id_angkatan == $id_angkatan)
                                                    selected
                                                @endif
                                            @endisset
                                            >{{$angkatans->tahun_angkatan}}
                                        </option>
                                    @endforeach
                                </select>
                            </div> 
                        </td>
                        <td style="width: 5%;">
                            <button style="margin-bottom: 10px;" class= "btn btn-info text-white" id="toggles" type="submit" > <i class="fas fa-search"></i> Filter</button>
                            <a style="margin-bottom: 10px;" class= "btn btn-info text-white" id="toggles" href="/admin/tracer" > <i class="fas fa-sync"></i> Reset</a>
                        </td>
                    </tr>
                </table>
            </form> --}}
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" >
                <thead>
                <tr>
                    <th>No.</th>
                    <th style="text-align:center;">Nama Alumni</th>
                    <th style="text-align:center;">Program Studi</th>
                    <th style="text-align:center;">Angkatan</th>
                    <th style="text-align:center;">Tahun Lulus</th>
                    {{-- <th style="text-align:center;">Periode Kuesioner</th> --}}
                    <th style="text-align:center;">Action</th> 
                </tr>
                </thead>

                <tbody>
                @foreach($detail as $details)
                <tr class="success">
                    <td style="width: 1%;">{{ $loop->iteration }}</td>
                        <td style="width: 15%;">{{ $details->nama_alumni }}</td>
                        <td style="width: 10%;">{{ $details->relasiAlumnitoProdi->nama_prodi }}</td>
                        <td style="width: 5%;" >{{ $details->relasiAlumnitoAngkatan->tahun_angkatan }}</td>
                        <td style="width: 7%;" >{{ $details->tahun_lulus }}</td>
                        {{-- <td style="width: 7%;" >{{ $details->relasiDetailkuesionertoPeriode->id_periode }}</td> --}}
                        <td style="width: 2%; text-align: center;" >
                            <a style="margin-right:7px" href="/admin/tracer/{{ $details->id_alumni }}">
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
@endsection


@section('custom_javascript')
<script>
    
</script>
@endsection