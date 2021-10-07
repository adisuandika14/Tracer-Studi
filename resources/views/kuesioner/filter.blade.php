<div class="table-responsive">
    <div class="container-fluid mt-4" style="align-content: center;">
        <div class="form-group" >
            <div class="form-group">
                @if($detail->isEmpty())
                <div class="text-center">
                    Tidak ada data
                </div>
                @endif
                @foreach($detail as $detailss)
                <div class="card shadow mb-4">
                    <!-- <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{$detailss->type_kuesioner}}</h6>
                    </div> -->
                    <div class="card-body">
                      @if($detailss->id_detail_kuesioner == $detailss->id_detail_kuesioner)
                        <p> {{ $loop->iteration }}. {{$detailss->pertanyaan}}</p>
                      @endif
                        <!-- <input type="text" class="form-control"  id="essay" name= "jawaban" value="" placeholder="Text Jawaban Singkat"> -->
                        @foreach ($opsi as $opsis)
                          @if($detailss->id_detail_kuesioner == $opsis->id_detail_kuesioner)
                            <ul class="list-group mb-1">
                              <li class="list-group-item">{{$opsis->opsi}}</li>
                            </ul>
                          @endif
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <!-- Edit -->
                        <button class="btn btn-primary btn-sm" onclick="edit({{$detailss->id_detail_kuesioner}})"><i class="fas fa-edit"></i>
                        </button> 
                        <!--Delete -->
                        <button class="btn btn-danger btn-sm" onclick="deletebc({{$detailss->id_detail_kuesioner}})"><i class="fas fa-trash"></i>
                        </button>
                        </div>
                </div>
                @endforeach
            </div>

            </div>
        </div>
    </div>
</div>