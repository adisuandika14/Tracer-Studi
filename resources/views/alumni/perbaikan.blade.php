@extends('layoutalumni.layout')
@section('title', 'Perbaikan Data Alumni')
@section('active4')
    nav-item active
@endsection

@section('content')
<style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #f1f1f1;
        }

        /*#regForm {*/
        /*    background-color: #ffffff;*/
        /*    margin: 100px auto;*/
        /*    font-family: Raleway;*/
        /*    padding: 40px;*/
        /*    width: 70%;*/
        /*    min-width: 300px;*/
        /*}*/

        /*h1 {*/
        /*    text-align: center;*/
        /*}*/

        /* Mark input boxes that gets an error on validation: */
        input.invalid {
            background-color: #ffdddd;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
        }

        /*button {*/
        /*    background-color: #24a0ed;*/
        /*    color: #ffffff;*/
        /*    border: none;*/
        /*    padding: 10px 20px;*/
        /*    font-size: 17px;*/
        /*    cursor: pointer;*/
        /*}*/

        button:hover {
            opacity: 0.8;
        }

        #prevBtn {
            background-color: #bbbbbb;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #04AA6D;
        }
    </style>

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Perbaikan Data Alumni</h1>
    <p class="mb-1">Profile Alumni Fakultas Teknik Universitas Udayana</p>

    <div class="container-fluid">
{{--        <div class="col-xl-4">--}}
{{--            <!-- Profile picture card-->--}}
{{--            <div class="card">--}}
{{--                <div class="card-header py-3">--}}
{{--                    <h6 class="m-0 font-weight-bold text-primary">Foto Profile</h6>--}}
{{--                  </div>--}}
{{--                <div class="card-body text-center">--}}
{{--                    <!-- Profile picture image-->--}}
{{--                    <img class="img-profile rounded-circle mb-2" id="propic" style="height: 250px;"--}}
{{--                        @if(auth()->guard()->user()->foto == NULL) src="{{asset('assets/admin/img/profile.png')}}"--}}
{{--                        @else src="{{auth()->guard()->user()->foto}}"--}}
{{--                        @endif alt="" />--}}
{{--                    <!-- Profile picture help block-->--}}
{{--                    <div class="small font-italic text-muted mb-2">JPG atau PNG maksimal 1 MB</div>--}}
{{--                    <!-- Profile picture upload button-->--}}
{{--                    <button type="button" class="btn btn-primary btn-icon-split mt-1" data-target="#crop-image" data-toggle="modal">--}}
{{--                        <span class="icon text-white-50">--}}
{{--                            <i class="fas fa-images"></i>--}}
{{--                        </span>--}}
{{--                        <span class="text">Ganti foto profil</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="col-xl my-auto">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Alumni</h6>
                  </div>
                <div class="card-body">
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

                    @if (session()->has('error'))
                        <div class="row">
                            <div class="col-sm-12 alert alert-danger alert-dismissible fade show" role="alert">
                                {{session()->get('error')}}
                                <button type="button" class="close" data-dismiss="alert"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    @endif
                    <form method="post" id="regForm" action="{{route('alumni-perbaikan-update')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="tab">
                            <div class="form-group">
                                <label class="small mb-1" for="inputUsername">Nama</label>
                                <input type="text" class="form-control form-control-user @error('nama_alumni') is-invalid @enderror"
                                       name="nama_alumni" autofocus required value="{{auth()->guard()->user()->nama_alumni}}"
                                       id="nama_alumni" placeholder="Nama">
                                {{--                                                @error('nama_alumni')--}}
                                {{--                                                <span class="invalid-feedback" role="alert">--}}
                                {{--                                                                <strong>{{ $message }}</strong>--}}
                                {{--                                                            </span>--}}
                                {{--                                                @enderror--}}
                            </div>

                            <div class="form-group" >
                                <label class="small mb-1" for="inputUsername">Program Studi</label>
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

                            <div class="form-group">
                                <label class="small mb-1" for="inputUsername">Nomor Induk Mahasiswa</label>
                                <input type="text" class="form-control form-control-user @error('nim_alumni') is-invalid @enderror"
                                       name="nim_alumni" autofocus required value="{{auth()->guard()->user()->nim_alumni}}"
                                       id="nim_alumni" placeholder="NIM" maxlength="10">
                                {{--                                                @error('nim_alumni')--}}
                                {{--                                                <span class="invalid-feedback" role="alert">--}}
                                {{--                                                                <strong>{{ $message }}</strong>--}}
                                {{--                                                            </span>--}}
                                {{--                                                @enderror--}}
                            </div>

                            <div class="form-group" >
                                <label class="small mb-1" for="inputUsername">Jenis Kelamin</label>
                                <select name="gender" class="custom-select" id="gender">
                                    <option selected value="">-- Jenis Kelamin --</option>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="tab">
                            <div class="form-group">
                                <label class="small mb-1" for="inputUsername">Angkatan</label>
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

                            <div class="form-group">
                                <label>Tahun Lulus</label>
                                <input type="date" class="form-control form-control-user  @error('tahun_lulus') is-invalid @enderror"
                                       id="tahun_lulus"  name="tahun_lulus" onfocus="(this.type='date')" required value="{{auth()->guard()->user()->tahun_lulus}}"
                                       placeholder="Tahun Lulus">
                            </div>

                            <div class="form-group">
                                <label>Tahun Wisuda</label>
                                <input type="date" class="form-control form-control-user  @error('tahun_wisuda') is-invalid @enderror"
                                       id="tahun_wisuda"  name="tahun_wisuda" onfocus="(this.type='date')" required value="{{auth()->guard()->user()->tahun_wisuda}}"
                                       placeholder="Tahun Wisuda">
                            </div>

                            <div class="form-group">
                                <label for="transkrip">Transkrip Nilai (Maks: 500kb)</label>
                                <input type="file" class="form-control-file" accept="application/pdf" id="transkrip" name="transkrip" >
                            </div>

                        </div>
                        <div class="tab">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control form-control-user  @error('email') is-invalid @enderror"
                                       id="email"  name="email" required autocomplete="email"
                                       placeholder="Email" required value="{{auth()->guard()->user()->email}}">
                                {{--                                                @error('email')--}}
                                {{--                                                <span class="invalid-feedback" role="alert">--}}
                                {{--                                                                <strong>{{ $message }}</strong>--}}
                                {{--                                                            </span>--}}
                                {{--                                                @enderror--}}
                            </div>

{{--                            <div class="form-group">--}}
{{--                                <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"--}}
{{--                                       id="password" placeholder="Password" maxlength="20">--}}
{{--                                --}}{{--                                                    @error('password')--}}
{{--                                --}}{{--                                                        <span class="invalid-feedback" role="alert">--}}
{{--                                --}}{{--                                                            <strong>{{ $message }}</strong>--}}
{{--                                --}}{{--                                                        </span>--}}
{{--                                --}}{{--                                                    @enderror--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="repeat_password" required autocomplete="current-password"--}}
{{--                                       id="repeat_password" placeholder="Ulangi Password" minlength="8" maxlength="20">--}}
{{--                                --}}{{--                                                @error('repeat_password')--}}
{{--                                --}}{{--                                                <span class="invalid-feedback" role="alert">--}}
{{--                                --}}{{--                                                        <strong>{{ $message }}</strong>--}}
{{--                                --}}{{--                                                    </span>--}}
{{--                                --}}{{--                                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="tab">--}}
                            <div class="form-group">
                                <label>Nomor Induk Kependudukan (NIK)</label>
                                <input type="number" class="form-control form-control-user @error('nik') is-invalid @enderror" name="nik" required
                                       id="nik" placeholder="Nomor Induk Kependudukan (NIK)" required value="{{auth()->guard()->user()->nik}}">
                            </div>
                            <div class="form-group">
                                <label>ID Telegram</label>
                                <input type="text" class="form-control form-control-user @error('id_telegram') is-invalid @enderror" name="id_telegram" required
                                       id="id_telegram" placeholder="ID Telegram" required value="{{auth()->guard()->user()->id_telegram}}">
                                {{--                                                @error('id_telegram')--}}
                                {{--                                                <span class="invalid-feedback" role="alert">--}}
                                {{--                                                                <strong>{{ $message }}</strong>--}}
                                {{--                                                            </span>--}}
                                {{--                                                @enderror--}}
                            </div>

                            <div class="form-group">
                                <label>ID Line</label>
                                <input type="text" class="form-control form-control-user @error('id_line') is-invalid @enderror" name="id_line" required
                                       id="id_line" placeholder="ID Line" required value="{{auth()->guard()->user()->id_line}}">
                                {{--                                                @error('id_line')--}}
                                {{--                                                <span class="invalid-feedback" role="alert">--}}
                                {{--                                                                <strong>{{ $message }}</strong>--}}
                                {{--                                                            </span>--}}
                                {{--                                                @enderror--}}
                            </div>

                            <div class="form-group">
                                <label>Nomor Handphone</label>
                                <input type="number" class="form-control form-control-user  @error('no_hp') is-invalid @enderror"
                                       id="no_hp" name="no_hp" aria-describedby="emailHelp"
                                       placeholder="No Handphone (Gunakan 62)" required value="{{auth()->guard()->user()->no_hp}}">
                                {{--                                                @error('no_hp')--}}
                                {{--                                                <span class="invalid-feedback" role="alert">--}}
                                {{--                                                                    <strong>{{ $message }}</strong>--}}
                                {{--                                                                </span>--}}
                                {{--                                                @enderror--}}
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control form-control-user @error('alamat_alumni') is-invalid @enderror" name="alamat_alumni" required
                                       id="alamat_alumni" placeholder="Alamat" required value="{{auth()->guard()->user()->alamat_alumni}}">
                                {{--                                                @error('id_line')--}}
                                {{--                                                <span class="invalid-feedback" role="alert">--}}
                                {{--                                                            <strong>{{ $message }}</strong>--}}
                                {{--                                                        </span>--}}
                                {{--                                                @enderror--}}
                            </div>
                        </div>
                        <div style="overflow:auto;">
                            <div style="float:right;">
                                <div class="form-group mt-4">
                                    <button type="button" id="prevBtn" onclick="nextPrev(-1)" class="btn btn-secondary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-times"></i>
                                        </span>
                                        <span class="text">Kembali</span>
                                    </button>
                                    <button type="button" id="nextBtn" onclick="nextPrev(1)" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-save"></i>
                                        </span>
                                        <span class="text">Simpan</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div style="text-align:center;margin-top:40px;">
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- {{-- CROPPER --}} -->
<div class="modal fade" id="crop-image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Pilih Foto Profil</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row" style="margin: 20px">
                <img  src="{{asset('assets/admin/img/Profile.png')}}" id="image-preview"  width="100%" height="100%" alt="">
                <div class="custom-file" style="margin-top: 20px">
                    <input type="file" class="custom-file-input" id="profile-image" name="thumbnail" accept="images/*" required>
                    <label for="thumbnail_label" id="thumbnail_labell" class="custom-file-label">Pilih Foto</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="modal-close" class="btn btn-danger" data-dismiss="modal">Kembali</button>
            <button type="button" id="update-foto-profile" class="btn btn-primary" data-dismiss="modal">Pilih</button>
        </div>
        </div>
    </div>
</div>
@endsection

@section('custom_javascript')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").style.display = "inline";
            } else {
                document.getElementById("nextBtn").style.display = "inline";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("regForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>
@endsection

