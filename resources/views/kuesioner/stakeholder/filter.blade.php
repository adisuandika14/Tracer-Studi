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
                            <div class="card-body">
                            @if($detailss->id_kuesioner_stackholder == $detailss->id_kuesioner_stackholder)
                                <p> {{ $loop->iteration }}. {{$detailss->pertanyaan}}</p>
                              @endif
                              
                                <!-- <input type="text" class="form-control"  id="essay" name= "jawaban" value="" placeholder="Text Jawaban Singkat"> -->
                                @foreach ($opsi as $opsis)
                                  @if($detailss->id_kuesioner_stackholder == $opsis->id_kuesioner_stackholder)
                                    @if($detailss->id_jenis == 3)
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                        {{$opsis->opsi}}
                                        </label>
                                      </div>
                                      @endif
                                      @if($detailss->id_jenis == 1)
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                        {{$opsis->opsi}}
                                        </label>
                                      </div>
                                      @endif
                                      @if($detailss->id_jenis == 2 || $detailss->id_jenis == 4)
                                      <div class="form-group" style="display: none;">
                                        <input type="text" class="form-control"  placeholder="Text Jawaban Singkat">
                                      </div>
                                    @endif
                                  @endif
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <!-- Edit -->
                                <button class="btn btn-primary btn-sm" onclick="edit({{$detailss->id_kuesioner_stackholder}})"><i class="fas fa-edit"></i>
                                </button> 
                                <!--Delete -->
                                <button class="btn btn-danger btn-sm" onclick="deletebc({{$detailss->id_kuesioner_stackholder}})"><i class="fas fa-trash"></i>
                                </button>
		                        </div>
                        </div>
                        @endforeach
            </div>

            </div>
        </div>
    </div>
</div>