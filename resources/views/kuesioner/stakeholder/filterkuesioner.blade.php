<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>No.</th>
            <th style="text-align:center;">Program Studi</th>
            <th style="text-align:center;">Action</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($detail as $detailss)
        <tr class="success">
            
                <td style="width: 5%;">{{ $loop->iteration }}</td>
                <td >{{ $detailss->nama_prodi }}</td>
            
              <td style="width: 10%; align:center;">
                  <!-- Show -->
                    <button type="button" id="show_kuesioner_btn" onclick="show_kuesioner({{$detailss->id_prodi}})" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>
              </td>
            </tr>
          @endforeach
          
        </tbody>
      </table>
</div>