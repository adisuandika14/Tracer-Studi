@extends('layoutalumni.layout')
@section('title', 'Profile Alumni')
@section('active2')
    nav-item active
@endsection
@section('content')


<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Profile Alumni</h1>
    <p class="mb-1">Profile Alumni Fakultas Teknik Universitas Udayana</p>

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

    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Foto Profile</h6>
                  </div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img class="img-profile rounded-circle mb-2" id="propic" style="height: 250px;"
                        @if(auth()->guard()->user()->foto == NULL) src="{{asset('assets/admin/img/profile.png')}}"
                        @else src="{{auth()->guard()->user()->foto}}"
                        @endif alt="" />
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-2">JPG atau PNG maksimal 1 MB</div>
                    <!-- Profile picture upload button-->
                    <button type="button" class="btn btn-primary btn-icon-split mt-1" data-target="#crop-image" data-toggle="modal">
                        <span class="icon text-white-50">
                            <i class="fas fa-images"></i>
                        </span>
                        <span class="text">Ganti foto profil</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-xl-8 my-auto">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Profile</h6>
                  </div>
                <div class="card-body">
                    <form method="post" action="{{route('alumni-profile-update')}}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <input type="text" class="form-control @error ('foto') is-invalid @enderror" name="foto" id="foto" placeholder="url" hidden>
                        <div class="form-group">
                            <label class="small mb-1" for="inputUsername">Nama</label>
                            <input class="form-control @error ('nama_alumni') is-invalid @enderror" id="inputUsername" type="text" name="nama_alumni" placeholder="Masukkan Nama" value="{{auth()->guard()->user()->nama_alumni}}" required/>
                            @error('name')
                                <div class="invalid-feedback text-start">
                                    {{ $message }}
                                </div>
                            @else
                                <div class="invalid-feedback">
                                    Nama wajib diisi
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="inputEmailAddress">Email</label>
                            <input class="form-control @error ('email') is-invalid @enderror" id="inputEmailAddress" type="text" name="email" placeholder="Masukkan Email" value="{{auth()->guard()->user()->email}}" required/>
                            @error('email')
                                <div class="invalid-feedback text-start">
                                    {{ $message }}
                                </div>
                            @else
                                <div class="invalid-feedback">
                                    Email wajib diisi
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="inputEmailAddress">Nomor HP</label>
                            <input class="form-control @error ('no_hp') is-invalid @enderror" id="inputEmailAddress" type="text" name="no_hp" placeholder="Masukkan Nomor HP (Gunakan 62)" @if(auth()->guard()->user()->no_hp==NULL) value="62" @else value="{{auth()->guard()->user()->no_hp}}" @endif required/>
                            @error('no_hp')
                                <div class="invalid-feedback text-start">
                                    {{ $message }}
                                </div>
                            @else
                                <div class="invalid-feedback">
                                    Nomor handphone wajib diisi
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="inputEmailAddress">Alamat</label>
                            <input class="form-control @error ('alamat_alumni') is-invalid @enderror" id="inputEmailAddress" type="text" name="alamat_alumni" placeholder="Masukkan Alamat" value="{{auth()->guard()->user()->alamat_alumni}}" required/>
                            @error('alamat_alumni')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                            @else
                                <div class="invalid-feedback">
                                    Alamat wajib diisi
                                </div>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="inputEmailAddress">ID Telegram</label>
                            <input class="form-control @error ('id_telegram') is-invalid @enderror" id="inputEmailAddress" type="text" name="id_telegram" placeholder="Masukkan ID Telegram" value="{{auth()->guard()->user()->id_telegram}}" required/>
                            @error('id_telegram')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                            @else
                                <div class="invalid-feedback">
                                    ID Telegram wajib diisi
                                </div>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="inputEmailAddress">ID Line</label>
                            <input class="form-control @error ('id_line') is-invalid @enderror" id="inputEmailAddress" type="text" name="id_line" placeholder="Masukkan ID Line" value="{{auth()->guard()->user()->id_line}}" required/>
                            @error('id_line')
                            <div class="invalid-feedback text-start">
                                {{ $message }}
                            </div>
                            @else
                                <div class="invalid-feedback">
                                    ID Line handphone wajib diisi
                                </div>
                                @enderror
                        </div>
                        <div class="form-group mt-4">
                            <a href="{{route('dashboard')}}" class="btn btn-danger btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-times"></i>
                                </span>
                                <span class="text">Batal</span>
                            </a>
                            <button  type="submit" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-save"></i>
                                </span>
                                <span class="text">Simpan</span>
                            </button>
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
                    <input type="file" class="custom-file-input" id="profile-image" name="thumbnail" accept="image/*" required>
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
    $(document).ready(function(e){
        var status;
        $('.summernote').summernote({
            height: 350, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });
        $(function(){
            $(".tanggal").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
            });
        });
    });

    //CROPPER
    function changeProfile(){
		$('#profile-image').trigger('click');
	}
	var cropper;
	var image = document.getElementById('image-preview');
	$(document).ready(function(){
	    $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
	            'Accept-Encoding' : 'gzip',
	        }
	    });
		$('#profile-image').on('change', function(){
			var filedata = this.files[0];
			var imgtype = filedata.type;
			var match = ['image/jpg', 'image/jpeg', 'image/png'];
			if (!(filedata.type==match[0]||filedata.type==match[1]||filedata.type==match[2])) {
	            alert("Format gambar Salah");
	        }else{
	        	var reader=new FileReader();
	            reader.onload=function(ev){
	                $('#image-preview').attr('src', ev.target.result);
					cropper.destroy();
   					cropper = null;
					cropper = new Cropper(image, {
						aspectRatio: 1/1,
						viewMode: 3,
						preview: '.preview'
					});
	            }
	            reader.readAsDataURL(this.files[0]);
	            var postData=new FormData();
	            postData.append('file', this.files[0]);
	        }
		});
		$('#crop-image').on('shown.bs.modal', function(){
			cropper = new Cropper(image, {
				aspectRatio: 1/1,
				viewMode: 3,
				preview: '.preview'
			});
		}).on('hidden.bs.modal', function(){
			cropper.destroy();
   			cropper = null;
		});
		$('#update-foto-profile').on('click', function(){
			canvas = cropper.getCroppedCanvas({
				width: 1080,
				height: 1920,
			});
			canvas.toBlob(function(blob){
				url = URL.createObjectURL(blob);
				var reader = new FileReader();
				reader.readAsDataURL(blob);

				reader.onloadend = function() {
                    $('#propic').attr('src', reader.result);
					var base64data = reader.result;
                    $('#foto').val(reader.result);
                    console.log(reader.result);
				}
			});
		});
	});
    // Validasi Form
    (function () {
        'use strict'
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
@endsection

