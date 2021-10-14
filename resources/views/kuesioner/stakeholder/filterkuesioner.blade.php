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
                      @if($detailss->id_prodi == $detailss->id_prodi)
                        <p> {{ $loop->iteration }}. {{$detailss->nama_prodi}}</p>
                      @endif
                    </div>
                    <div class="modal-footer">
                        <!-- Edit -->
                        <button class="btn btn-primary btn-sm" onclick="edit({{$detailss->id_prodi}})"><i class="fas fa-edit"></i>
                        </button> 
                        <!--Delete -->
                        <button class="btn btn-danger btn-sm" onclick="deletebc({{$detailss->id_prodi}})"><i class="fas fa-trash"></i>
                        </button>
                        </div>
                </div>
                @endforeach
            </div>

            </div>
        </div>
    </div>
</div>