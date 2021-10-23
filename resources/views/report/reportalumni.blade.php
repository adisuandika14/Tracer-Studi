@extends('layoutadmin.layout')
@section('title', 'Report Alumni')
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
            <h6 class="m-0 font-weight-bold text-primary">Data Survey Alumni Fakultas Teknik</h6>
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
            <!-- <form  method="POST" action="/admin/reportalumni/filter">
                @csrf -->
                <table class="table"  id="example" cellspacing="0">
                    <tr id="filter_row">
                        <td>
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
                        <td >
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
                        <td >
                            <div class="form-group">
                                <select name="tahun_wisuda" class="custom-select" id="tahun_wisuda" >
                                    <option selected value="">-- Pilih Tahun Wisuda --</option>
                                    @foreach ($tahun_wisuda as $tw)
                                        <option value="{{ $tw->tahun_wisuda }}"
                                            @isset($pertanyaan)
                                                @if($tw->tahun_wisuda == $tahun_wisuda)
                                                    selected
                                                @endif
                                            @endisset
                                            >{{$tw->tahun_wisuda}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td >
                            <div class="form-group">
                                <select name="tahun_periode" class="custom-select" id="tahun_periode" >
                                    <option selected value="">-- Pilih Tahun Periode Kuisioner --</option>
                                    @foreach ($tahun_periode as $tp)
                                        <option value="{{ $tp->tahun_periode }}"
                                            @isset($pertanyaan)
                                                @if($tp->tahun_periode == $tahun_periode)
                                                    selected
                                                @endif
                                            @endisset
                                            >{{$tp->tahun_periode}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td >
                            <div class="form-group">
                                <select name="periode" class="custom-select" id="periode" >
                                    <option selected value="">-- Pilih Periode Kuisioner --</option>
                                    @foreach ($periode as $p)
                                        <option value="{{ $p->id_periode }}"
                                            @isset($pertanyaan)
                                                @if($p->periode == $periode)
                                                    selected
                                                @endif
                                            @endisset
                                            >{{$p->periode}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td >
                            <div class="form-group">
                                <select name="kategori_1" class="custom-select" id="kategori_1" >
                                    <option selected value="">-- Pilih Kategori Lulusan --</option>
                                    @foreach ($kategori_1 as $k)
                                        <option value="{{ $k->id_soal_alumni }}"
                                            @isset($pertanyaan)
                                                @if($k->id_soal_alumni == $id_soal_alumni)
                                                    selected
                                                @endif
                                            @endisset
                                            >{{$k->pertanyaan}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td style="width: 5%;">
                            <a  style="margin-bottom: 10px;" class= "btn btn-info text-white" id="filter"> <i class="fas fa-search"></i> Filter </a>
                            <!-- <button style="margin-bottom: 10px;" class= "btn btn-info text-white" id="toggles" type="" id="filter" > <i class="fas fa-search"></i> Filter</button> -->
                            <a style="margin-bottom: 10px;" class= "btn btn-info text-white" id="toggles" href="/admin/reportalumni" > <i class="fas fa-sync"></i> Reset</a>
                        </td>
                    </tr>
                </table>
            <!-- </form> -->
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" >
                <thead>
                <tr id="header">
                    <th>No.</th>
                    <th style="text-align:center;">Nama Alumni</th>
                    <th style="text-align:center;">Program Studi</th>
                    <th style="text-align:center;">Angkatan</th>
                    <th style="text-align:center;">Tahun Wisuda</th>
                    {{-- <th style="text-align:center;">Periode Kuesioner</th> --}}
                    <th style="text-align:center;">Action</th>
                </tr>
                </thead>
                <tbody id="datacell">
                @foreach($tracers as $details)
                <tr class="success" >
                    <td style="width: 1%;">{{ $loop->iteration }}</td>
                        <td style="width: 15%;">{{ $details->nama_alumni }}</td>
                        <td style="width: 10%;">{{ $details->relasiAlumnitoProdi->nama_prodi }}</td>
                        <td style="width: 5%;" >{{ $details->relasiAlumnitoAngkatan->tahun_angkatan }}</td>
                        <td style="width: 7%;" >{{ $details->tahun_wisuda }}</td>
                        {{-- <td style="width: 7%;" >{{ $details->relasiDetailkuesionertoPeriode->id_periode }}</td> --}}
                        <td style="width: 2%; text-align: center;" >
                            <a style="margin-right:7px" href="/admin/reportalumni/{{ $details->id_alumni }}">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye">Lihat Data</i></button></a>
                        </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chart Data Angkatan Alumni Fakultas Teknik</h6>
        </div>
        <div class="card-body">
            <div class="card card-body">
                <div class="chart-bar pt-4 pb-2" id="graph_container_1">
                    <canvas id="myBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chart Data Prodi Alumni Fakultas Teknik</h6>
        </div>
        <div class="card-body">
            <div class="card card-body">
                <div class="chart-bar pt-4 pb-2" id="graph_container_2">
                    <canvas id="myBarChart2"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        chart_1({!! json_encode($tahunAngkatan) !!}, {!! json_encode($dataAngkatan) !!});
        chart_2({!! json_encode($namaProdi) !!}, {!! json_encode($dataProdi) !!});
        $('#filter').on('click',function(e){
            e.preventDefault();
            const prodi = $('#prodi').val()
            const angkatan = $('#angkatan').val()
            const kategori_1 = $('#kategori_1').val()
            // var ctx3 = document.getElementById('pertambahanAnggota');

            $.ajax({
                method : 'POST',
                url : '/admin/reportalumni/filter',
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
                    const data = '';
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
                    $("#filter").removeAttr('disabled');
                    $("#datacell").empty();
                    $("#datacell").html(`
                        ${httpval}
                    `);
                    chart_1(res.label_angkatan, res.label_data_angkatan);
                    chart_2(res.label_prodi, res.label_data_prodi);
                },
            }).done(()=>{})
        })
        function chart_1(label, label_data){
            $('#myBarChart').remove();
            $('#graph_container_1').append('<canvas id="myBarChart"></canvas>');
            var ctx = document.getElementById("myBarChart");
            const config = {
                type: 'bar',
                data: {
                    labels: label,
                    datasets: [{
                        label: "Total : ",
                        backgroundColor: "#4e73df",
                        hoverBackgroundColor: "#2e59d9",
                        borderColor: "#4e73df",
                        data: label_data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    dataset:{
                        maxBarThickness: 150,
                    },
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'year'
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 6
                            },
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                max: label_data.length,
                                maxTicksLimit: 5,
                                padding: 10,
                                // Include a dollar sign in the ticks
                                callback: function(value, index, values) {
                                    return number_format(value);
                                }
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }],
                    },
                    legend: {
                        display: false
                    },
                }
            };
            var myBarChart = new Chart(ctx, config);
        }
        function chart_2(label, label_data){
            $('#myBarChart2').remove();
            $('#graph_container_2').append('<canvas id="myBarChart2"></canvas>');
            var ctx = document.getElementById("myBarChart2");
            const config = {
                type: 'bar',
                data: {
                    labels: label,
                    datasets: [{
                        label: "Total : ",
                        backgroundColor: "#4e73df",
                        hoverBackgroundColor: "#2e59d9",
                        borderColor: "#4e73df",
                        data: label_data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    dataset:{
                        maxBarThickness: 150,
                    },
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'year'
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 6
                            },
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                max: label_data.length,
                                maxTicksLimit: 5,
                                padding: 10,
                                // Include a dollar sign in the ticks
                                callback: function(value, index, values) {
                                    return number_format(value);
                                }
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }],
                    },
                    legend: {
                        display: false
                    },
                }
            };
            var myBarChart = new Chart(ctx, config);
        }
    })
</script>
@endsection


@section('custom_javascript')
<script>

</script>
@endsection
