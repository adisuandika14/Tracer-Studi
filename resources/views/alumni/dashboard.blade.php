@extends('layoutalumni.layout')
@section('title', 'Dashboard')

@section('active1')
      nav-item active
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Notifikasi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="container-fluid" style="align-content: center;">
                        @forelse ($notifs as $notif)
                            @if($notif->status =='Diterima')
                                <div class="alert alert-success alert-block">
                                    <a href="/alumni/read-notif/{{$notif->notifikasi_unique}}"><button type="button" class="close" >×</button></a>
                                    <strong>{{$notif->notifikasi}}</strong>
                                </div>
                            @endif
                            @if($notif->status == 'Menunggu Konfirmasi')
                                <div class="alert alert-warning alert-block">
                                    <a href="/alumni/read-notif/{{$notif->notifikasi_unique}}"><button type="button" class="close" >×</button></a>
                                    <strong>{{$notif->notifikasi}}</strong>
                                </div>
                            @endif
                            @if($notif->status == 'Ditolak')
                                <div class="alert alert-danger alert-block">
                                    <a href="/alumni/read-notif/{{$notif->notifikasi_unique}}"><button type="button" class="close" >×</button></a>
                                    <strong>{{$notif->notifikasi}}</strong><hr>
                                    <a>Perbaikan dapat dilakukan </a>
                                    <a href="{{ url('/alumni/perbaikan') }}">disini</a>
                                </div>
                            @endif
                        @empty
                                <div class="alert alert-secondary alert-block">
                                    <strong>Tidak ada notifikasi</strong>
                                </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Begin Page Content -->

@endsection


