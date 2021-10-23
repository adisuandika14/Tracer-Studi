@extends('layoutstakeholder.layoutauth')
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tracer Study | Stakeholder</title>

    <link rel="shortcut icon" href="{{asset('assets/admin/img/unud.png')}}" type="image/png">

    <!-- Custom fonts for this template-->
{{--    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">--}}
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom fonts for this template-->
{{--    <link href="{{ asset('assets/admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">--}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/admin/css/sb-admin-2.min.css')}}" rel="stylesheet">

    <link href="{{ asset('assets/admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/admin.css')}}" rel="stylesheet">
    @stack('css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
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

    h1 {
        text-align: center;
    }

    /* Mark input boxes that gets an error on validation: */
    input.invalid {
        background-color: #ffdddd;
    }

    /* Hide all steps by default: */
    .tab {
        display: none;
    }

    button {
        background-color: #24a0ed;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        font-size: 17px;
        cursor: pointer;
    }

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

<body class="bg-gradient-images" >

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-4">
                                <img src="{{asset('assets/admin/img/unud.png')}}" style="width:90%; margin:15px">
                            </div>
                            <div class="col-lg-8">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Informasi Stakeholder</h1>
                                        <hr>
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
                                        @if (session()->has('error'))
                                            <div class="row">
                                                <div class="col-sm-12 alert alert-danger alert-dismissible fade show" name="alert" role="alert">
                                                    {{session()->get('error')}}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <form id="regForm" method="POST" action="{{ route('regisStakeholder') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="tab">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user @error('nama') is-invalid @enderror"
                                                       name="nama" autofocus required
                                                       id="nama" placeholder="Nama">
{{--                                                @error('nama_alumni')--}}
{{--                                                <span class="invalid-feedback" role="alert">--}}
{{--                                                                <strong>{{ $message }}</strong>--}}
{{--                                                            </span>--}}
{{--                                                @enderror--}}
                                            </div>

                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user @error('nama_instansi') is-invalid @enderror"
                                                       name="nama_instansi" autofocus required
                                                       id="nama_instansi" placeholder="Nama Instansi">
                                            </div>

                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user @error('jabatan') is-invalid @enderror"
                                                       name="jabatan" autofocus required
                                                       id="jabatan" placeholder="Jabatan">
                                            </div>

                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                                       name="email" autofocus required
                                                       id="email" placeholder="Email">
                                            </div>

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
                                        </div>
                                        <div style="overflow:auto;">
                                            <div style="float:right;">
                                                <button type="button" class="btn btn-secondary btn-user" id="prevBtn" onclick="nextPrev(-1)">Kembali</button>
                                                <button type="button" class="btn btn-primary btn-user" id="nextBtn" onclick="nextPrev(1)">Selanjutnya</button>
                                            </div>
                                        </div>




                                            <!-- <div class="form-group">
                                                <div class="custom-control custom-checkbox small">

                                                    <input type="checkbox" class="custom-control-input " id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="remember">
                                                            {{ __('Remember Me') }}
                                                        </label>
                                                </div>
                                            </div> -->
{{--                                            <div class="form-group ">--}}
{{--                                                <div >--}}
{{--                                                    <button type="submit" class="btn btn-primary btn-user btn-block">--}}
{{--                                                        {{ __('Registrasi') }}--}}
{{--                                                    </button>--}}

{{--                                                    @if (Route::has('password.request'))--}}
{{--                                                        <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                                                            {{ __('Forgot Your Password?') }}--}}
{{--                                                        </a>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                        <div style="text-align:center;margin-top:40px;">
                                            <span class="step"></span>

                                        </div>
                                        </form>
                                    <hr>

                                    {{-- <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

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
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Selanjutnya";
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
</body>

</html>
