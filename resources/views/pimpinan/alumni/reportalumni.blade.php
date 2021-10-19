@extends('layoutpimpinan.layout')
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
            <!-- <form  method="POST" action="/pimpinan/reportalumni/filter">
                @csrf -->
                <table class="table" style="width: 85%;" id="example" cellspacing="0">
                    <tr id="filter_row">
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
                            <a style="margin-bottom: 10px;" class= "btn btn-info text-white" id="toggles" href="/pimpinan/reportalumni" > <i class="fas fa-sync"></i> Reset</a>
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
                    <th style="text-align:center;">Tahun Lulus</th>
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
                        <td style="width: 7%;" >{{ $details->tahun_lulus }}</td>
                        {{-- <td style="width: 7%;" >{{ $details->relasiDetailkuesionertoPeriode->id_periode }}</td> --}}
                        <td style="width: 2%; text-align: center;" >
                            <a style="margin-right:7px" href="/pimpinan/reportalumni/{{ $details->id_alumni }}">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye">Lihat Data</i></button></a>
                        </td>
                </tr>
                @endforeach 
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <div class="row">
      <!-- Bar Chart -->
      <div class="col-xl-12 col-lg-7">
          <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div
                  class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Lulusan Mahasiswa Fakultas Teknik Universitas Udayana</h6>
                  <div class="dropdown no-arrow">
                      <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                          aria-labelledby="dropdownMenuLink">
                          <div class="dropdown-header">Dropdown Header:</div>
                          <a class="dropdown-item" href="#">Action</a>
                          <a class="dropdown-item" href="#">Another action</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="#">Something else here</a>
                      </div>
                  </div>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                  <div class="chart-bar">
                      <canvas id="myBarChart"></canvas>
                  </div>
              </div>
          </div>
      </div>


  </div>


</div>

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
                url : '/pimpinan/reportalumni/filteralumni',
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
                                <a style="margin-right:7px" href="/pimpinan/reportalumni/${i.id_alumni}">
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


@section('custom_javascript')
<script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';
    
    function number_format(number, decimals, dec_point, thousands_sep) {
      // *     example: number_format(1234.56, 2, ',', ' ');
      // *     return: '1 234,56'
      number = (number + '').replace(',', '').replace(' ', '');
      var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
          var k = Math.pow(10, prec);
          return '' + Math.round(n * k) / k;
        };
      // Fix for IE parseFloat(0.55).toFixed(0) = 0;
      s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }
      if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
      }
      return s.join(dec);
    }
    
    // Bar Chart Example
    var ctx = document.getElementById("myBarChart");
    var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels:{{json_encode($periodecount)}} ,
        datasets: [{
          label: "Total : ",
          backgroundColor: "#4e73df",
          hoverBackgroundColor: "#2e59d9",
          borderColor: "#4e73df",
          data: {{json_encode($jawabtot)}} ,
        }],
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 10,
            right: 10,
            top: 25,
            bottom: 0
          }
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
            maxBarThickness: 25,
          }],
          yAxes: [{
            ticks: {
              min: 0,
              max: {{max($jawabtot)}},
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
        tooltips: {
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFontSize: 14,
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
          callbacks: {
            label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel  + number_format(tooltipItem.yLabel);
            }
          }
        },
      }
    });
    </script>
@endsection