<head>
  <link href="{{ asset('assets/admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
</head>
  <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>No.</th>
          <th style="text-align:center;">Pertanyaan</th>
          <th style="text-align:center;">Action</th>
        </tr>
      </thead>

      <tbody>
      @foreach ($kuesioner as $quiz)
        <tr class="success">
            <td style="width: 5%;">{{ $loop->iteration }}</td>
                <td >{{ $quiz->type_kuesioner }}</td>
                <!-- <td  >{{ $quiz->pertanyaan }}</td> -->
                {{-- <td style="width: 10%" >{{ $quiz->status }}</td> --}}
                
                <!-- <td>
                <img src="{{asset('storage/app/public/image/post'.$quiz->thumbnail) }}" alt="Image 10"  width="300" height="300" />
                </td> -->
                <!-- <td style="width: 30px;">{{ $quiz->thumbnail }}</td>
                <td style="width: 30px;">{{ $quiz->lampiran }}</td>
                    -->

                <td style="width: 10%">
                    <!-- Show -->
                    <a style="margin-right:7px" href="/admin/kuesioner/showkuesioner/{{$quiz->id_kuesioner}}">
                        <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>
                        
                    <!-- Edit -->
                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#update{{$quiz->id_kuesioner}}"><i class="fas fa-edit"></i>
                    </button>
                    <!--Delete -->
                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#delete{{$quiz->id_kuesioner}}"><i class="fas fa-trash"></i>
                    </button>
                </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

<script src="{{ asset('assets/admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/admin/js/demo/datatables-demo.js')}}"></script>