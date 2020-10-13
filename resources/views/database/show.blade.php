@extends('layouts.master-user')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Detail Anggota</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('database.index') }}">Anggota</a></li>
                            <li class="breadcrumb-item active">Detail Anggota</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container">                
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-info card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="{{asset($anggota->foto)}}" alt="User profile picture">
                                </div>
                                <h3 class="profile-username text-center">{{$anggota->nama}}</h3>                
                                <p class="text-muted text-center">{{$anggota->rayon->nama}} - {{$anggota->tahun_dad ?? 'Belum diisi' }}</p>
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Nomor HP</b> <a class="float-right">{{$anggota->no_hp ?? 'Belum diisi' }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Tempat Lahir</b> <a class="float-right">{{$anggota->tempat_lahir ?? 'Belum diisi' }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Tanggal Lahir</b> <a class="float-right">{{ isset($anggota->tanggal_lahir) ? $anggota->tanggal_lahir->format('d/m/Y') : 'Belum diisi' }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Jenis Kelamin</b> <a class="float-right">{{ $anggota->jenis_kelamin ?? 'Belum diisi' }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Alamat</b> <a class="float-right">{{$anggota->alamat ?? 'Belum diisi' }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Kabupaten</b> <a class="float-right">{{$anggota->kabupaten->nama }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Provinsi</b> <a class="float-right">{{$anggota->provinsi->nama }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>                        
                    </div>      
                    <div class="col-md-8">
                        {{-- PEKERJAAN --}}
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Riwayat Pekerjaan</h3>
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Pekerjaan</th>
                                            <th>Perusahaan</th>
                                            <th>Departemen</th>
                                            <th>Jabatan</th>
                                            <th>Lokasi</th>
                                            <th>Tahun</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($anggota->pekerjaan as $key => $pekerjaan)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $pekerjaan->jenis }}</td>
                                                <td>{{ $pekerjaan->perusahaan ?? '-' }}</td>
                                                <td>{{ $pekerjaan->departemen ?? '-' }}</td>
                                                <td>{{ $pekerjaan->jabatan ?? '-' }}</td>
                                                <td>{{ $pekerjaan->kabupaten->nama }}</td>
                                                <td>{{ $pekerjaan->tahun_awal }} - {{ isset($pekerjaan->tahun_awal) && is_null($pekerjaan->tahun_akhir) ? 'sekarang' : $pekerjaan->tahun_akhir }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                        {{-- ORGANISASI --}}
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Riwayat Organisasi</h3>
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Nama</th>
                                            <th>Lingkup</th>
                                            <th>Jabatan</th>
                                            <th>Kabupaten/Provinsi</th>
                                            <th>Tahun</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($anggota->organisasi as $key => $organisasi)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $organisasi->nama }}</td>
                                                <td>{{ $organisasi->lingkup }}</td>
                                                <td>{{ $organisasi->jabatan ?? "-" }}</td>
                                                @if ($organisasi->lingkup == 'Nasional')
                                                    <td>-</td>
                                                @elseif ($organisasi->lingkup == 'Provinsi')
                                                    <td>{{ $organisasi->provinsi->nama }}</td>
                                                @elseif ($organisasi->lingkup == 'Kabupaten/Kota')
                                                    <td>{{ $organisasi->kabupaten->nama }}</td>
                                                @endif
                                                <td>{{ $organisasi->tahun_awal . "-". $organisasi->tahun_akhir }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection