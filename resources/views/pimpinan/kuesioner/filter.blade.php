<div class="table-responsive">
    <div class="container-fluid mt-4" style="align-content: center;">
        <div class="form-group" >
            <div class="form-group">
                @if($detail->isEmpty())
                <div class="text-center">
                    Tidak ada data
                </div>
                @endif
                @foreach($detail as $detailss => $status)
                  <div class="card shadow mb-4">
                      <!-- <div class="card-header py-3">
                          <h6 class="m-0 font-weight-bold text-primary">{{$status->type_kuesioner}}</h6>
                      </div> -->
                      <div class="card-body">
                        @if($status->id_detail_kuesioner == $status->id_detail_kuesioner)
                          <p> {{ $loop->iteration }}. {{$status->pertanyaan}}</p>
                        @endif
                          <!-- <input type="text" class="form-control"  id="essay" name= "jawaban" value="" placeholder="Text Jawaban Singkat"> -->
                          @foreach ($opsi as $opsis)
                            @if($status->id_detail_kuesioner == $opsis->id_detail_kuesioner)
                              <ul class="list-group mb-1">
                                <li class="list-group-item">{{$opsis->opsi}}</li>
                              </ul>
                            @endif
                          @endforeach
                      </div>
                      <div class="modal-footer">
                          <label class="switch">
                            
                              @if($status->status == "Konfirmasi")
                                <input type="checkbox" id="status_{{$status->id_detail_kuesioner}}" onclick="statusBtn({{$status->id_detail_kuesioner}})" checked>
                              @else
                                <input type="checkbox" id="status_{{$status->id_detail_kuesioner}}" onclick="statusBtn({{$status->id_detail_kuesioner}})">
                              @endif
                            <span class="slider round"></span>
                          </label>
                        </div>
                  </div>
                  @endforeach
            </div>

            </div>
        </div>
    </div>
</div>