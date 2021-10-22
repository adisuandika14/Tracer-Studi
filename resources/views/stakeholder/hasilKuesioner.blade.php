@extends('layoutstakeholder.layout')
@section('title', 'Kuesioner')
@section('active3')
    nav-item active
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Hasil Kuesioner</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th style="text-align:center;">Pertanyaan</th>
                            <th style="text-align:center;">Jawaban</th>
                            <th style="text-align:center; width:20px;">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($detail as $details)
                            <tr class="success">
                                <td style="width: 1%;">{{ $loop->iteration }}</td>
                                <td style="width: 20%;" >{{ $details->relasijawabantoKuesioner->pertanyaan ?? '-' }}</td>
                                <td style="width: 10%" >
                                    @if($details->jawaban == "")
                                        @foreach($detail_jawaban as $jawaban)
                                            {{$jawaban->relasiJawabantoOpsi->opsi}},
                                        @endforeach
                                    @else
                                        {{ $details->jawaban }}
                                    @endif
                                </td>
                                <td style="text-align:center; width: 1%;">
                                    <!-- Edit -->
                                    <button class="btn btn-primary btn-sm" onclick="update({{$details->id_jawaban_stakeholder}},{{$details->relasijawabantoKuesioner->id_jenis}},'{{$details->relasijawabantoKuesioner->pertanyaan}}','{{$details->jawaban}}',{{$details->relasijawabantoKuesioner->id_kuesioner_stakeholder}})"><i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- //Update -->
    <div class="modal fade" id="updateJawabanGanda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Jawaban</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="form_jawaban_ganda" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_kuesioner_stakeholder" value="">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Kuesioner</label>
                            <input type="text" class="form-control" id="edit_pertanyaan_ganda" name="edit_pertanyaan_ganda" value="" placeholder="" disabled>
                        </div>
                        <input type="text" class="form-control"  id="save_jawaban_ganda" name="save_jawaban_ganda"   required>
                        <div id="edit_jawaban_ganda">

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- //Update -->
    <div class="modal fade" id="updateJawabanCheckbox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Jawaban</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="form_jawaban_checkbox" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_kuesioner_stakeholder" value="">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Kuesioner</label>
                            <input type="text" class="form-control" id="edit_pertanyaan_form_jawaban_checkbox" name="edit_pertanyaan_form_jawaban_checkbox" value="" placeholder="" disabled>
                        </div>
                        <input type="text" class="form-control"  id="save_jawaban_form_jawaban_checkbox" name="save_jawaban_form_jawaban_checkbox"  hidden required>
                        <div id="edit_jawaban_checkbox">

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- //Update -->
    <div class="modal fade" id="updateJawabanSingkat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Jawaban</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/admin/kuesioner/update" id="form_jawaban_singkat" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_kuesioner_stakeholder" value="">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Kuesioner</label>
                            <input type="text" class="form-control" id="edit_pertanyaan_singkat" name="type_kuesioner" value="" placeholder="" disabled>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Jawaban</label>
                            <input type="text" class="form-control" id="edit_jawaban_singkat" name="edit_jawaban_singkat" value="" placeholder="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_javascript')
    <script>

        function jawabRadio(id_soal_pengguna, id_opsi_stakeholder){
            document.getElementById("save_jawaban_ganda").value=id_opsi_stakeholder;
        }
        function update(id, id_jenis, pertanyaan, jawaban, id_soal_pengguna){
            if(id_jenis == 1){
                $('#form_jawaban_ganda').attr("action", "/stakeholder/hasilKuesioner/update/"+id);
                $('#edit_pertanyaan_ganda').val(pertanyaan);
                var opsi = {!! json_encode($opsis->toArray()) !!}
                $('#edit_jawaban_ganda').empty();
                opsi.forEach(element => {
                    if(element.id_soal_pengguna ==  id_soal_pengguna){
                        $('#edit_jawaban_ganda').append('<div class="form-check">' +
                            '<input class="form-check-input" name="'+ id_soal_pengguna +'" type="radio" value="'
                            + element['id_opsi_stakeholder'] +'" onchange="jawabRadio('+id_soal_pengguna+','
                            +element['id_opsi_stakeholder']+')" id="flexRadioDefault'+id_soal_pengguna+'">'
                            + '<label class="form-check-label" for="flexRadioDefault'+id_soal_pengguna+'">'
                            + element['opsi'] + '</label>'+'</div>');
                    }
                })
                $('#updateJawabanGanda').modal('show');
            }else if(id_jenis == 2){
                $('#form_jawaban_singkat').attr("action", "/stakeholder/hasilKuesioner/update/"+id);
                $('#edit_pertanyaan_singkat').val(pertanyaan);
                $('#edit_jawaban_singkat').val(jawaban);
                $('#updateJawabanSingkat').modal('show');

                // <div class="form-check">
                //     <input class="form-check-input" name="'+ id_kuesioner_stakeholder +'" type="radio" value="'+ element['opsi'] +'" onchange="jawabRadio('+id_kuesioner_stakeholder+')" id="flexRadioDefault'+id_kuesioner_stakeholder+'">
                //     <label class="form-check-label" for="flexRadioDefault'+id_kuesioner_stakeholder+'">
                //         'element['opsi']'
                //     </label>
                // </div>

            }
        }

        // var jawaban;
        // var jawabans = {!! json_encode($detail->toArray()) !!}
        // jawabans.forEach(element => {
        //     if(element.id_jawaban_kuesioner ==  id){

        //     }
        // })
    </script>
@endsection
