@extends('layoutpimpinan.layout')
@section('title', 'Report Stakeholder')
@section('active11')
      nav-item active
@endsection
@section('collapse5')
      nav-item active
@endsection



@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Survey Pengguna Lulusan Fakultas Tekniik</h6>
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
            <form  method="POST" action="/pimpinan/reportstakeholder/filterreport">
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
                                <select name="periode" class="custom-select" id="periode" >
                                    <option selected value="">-- Pilih Periode Kuesioner --</option>
                                    @foreach ($periode as $periodes)
                                    <option  value="{{$periodes->id_tahun_periode}}"
                                        @isset($id_tahun_periode)
                                            @if($periodes->id_tahun_periode == $id_tahun_periode)
                                                selected
                                            @endif
                                        @endisset
                                        >{{ $periodes->tahun_periode }}
                                    </option>
                                    @endforeach
                                </select>
                            </div> 
                        </td>
                        <td style="width: 5%;">
                            <button style="margin-bottom: 10px;" class= "btn btn-info text-white" id="toggles" type="submit" > <i class="fas fa-search"></i> Filter</button>
                            <a style="margin-bottom: 10px;" class= "btn btn-info text-white" id="toggles" href="/pimpinan/reportstakeholder" > <i class="fas fa-sync"></i> Reset</a>
                        </td>
                    </tr>
                </table>
            </form>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" >
                <thead>
                <tr>
                    <th>No.</th>
                    <th style="text-align:center;">Nama Pengisi</th>
                    <th style="text-align:center;">Instansi</th>
                    <th style="text-align:center;">jabatan</th>
                    <th style="text-align:center;">Email</th>
                    <th style="text-align:center;">Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach($stakeholder as $report)
                <tr class="success">
                    <td style="width: 1%;">{{ $loop->iteration }}</td>
                        <td style="width: 15%;">{{ $report->nama }}</td>
                        <td style="width: 10%;">{{ $report->nama_instansi }}</td>
                        <td style="width: 5%;" >{{ $report->jabatan }}</td>
                        <td style="width: 7%;" >{{ $report->email }}</td>
                        <td style="width: 2%; text-align: center;" >
                            <a style="margin-right:7px" href="/pimpinan/reportstakeholder/{{ $report->id_stakeholder }}">
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
    $(document).ready(function(){
        $('#filter').on('click',function(e){
            e.preventDefault();
            const prodi = $('#prodi').val()
            const angkatan = $('#angkatan').val()
            const kategori_1 = $('#kategori_1').val()
            // var ctx3 = document.getElementById('pertambahanAnggota');

            $.ajax({
                method : 'POST',
                url : '/pimpinan/reportstakeholder/filterreport',
                data : {
                "_token" : "{{ csrf_token() }}",
                prodi : prodi,
                angkatan : angkatan,
                kategori_1 : kategori_1,
                },
                beforeSend : function() {
                          $("#filter").attr('disabled', true);
                },
                success : (res) => {
                    let httpval = '';
                    let i = 0;
                    let z = 1;
                    res.tracers.map(i => {
                        httpval +=`
                        <tr class="success" >
                            <td style="width: 1%;">${z}</td>
                            <td style="width: 15%;">${i.nama_alumni}</td>
                            <td style="width: 10%;">${i.relasi_alumnito_prodi.nama_prodi}</td>
                            <td style="width: 5%;" >${i.relasi_alumnito_angkatan.tahun_angkatan}</td>
                            <td style="width: 7%;" >${i.tahun_lulus}</td>
                            <td style="width: 2%; text-align: center;" >
                                <a style="margin-right:7px" href="/admin/reportalumni/${i.id_alumni}">
                                    <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye">Lihat Data</i></button></a>
                            </td>
                        </tr>`;
                        i += 1;
                        z += 1;
                    })
                    alert('Data Berhasil di Filter');
                    $("#filter").removeAttr('disabled');
                    $("#datacell").empty();
                    $("#datacell").html(`
                        ${httpval} 
                    `);
                },
            }).done(()=>{})
        })
    })
</script>
@endsection