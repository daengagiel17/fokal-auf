@extends('layouts.master-user')

@section('css')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">    
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap4.css') }}">    
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container">
                <div class="row">
                    @if ($message = Session::get('success'))
                        <div class="col-md-12">
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                            </div>
                        </div>
                    @endif
                    @if(!$anggota->is_verify)
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-block">
                                <span><i class="fa fa-exclamation-triangle mr-2"></i></span><strong>Data belum terverifikasi</strong>
                            </div>
                        </div>
                    @endif
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
                                <a href="{{ route('profil.anggota.edit') }}" class="btn btn-sm btn-warning btn-block mt-1 mb-1">Edit</a>
                            </div>
                        </div>                        
                    </div>   
                    <div class="col-md-8">
                        {{-- PEKERJAAN --}}
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Pekerjaan</h3>
                                <div class="card-tools">
                                    <a href="{{ route('profil.pekerjaan.create') }}" class="btn btn-primary btn-sm">Tambah</a>
                                </div>
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
                                            <th>Action</th>
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
                                                <td>
                                                    <a href="{{ route('profil.pekerjaan.edit', ['pekerjaan' => $pekerjaan->id]) }}" class="btn btn-sm btn-warning mb-1"><i class="fa fa-edit"></i></a>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-delete-pekerjaan mb-1" data-id="{{$pekerjaan->id}}"><i class="fa fa-trash"></i></a>
                                                </td>
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
                                <h3 class="card-title">Organisasi</h3>
                                <div class="card-tools">
                                    <a href="{{ route('profil.organisasi.create') }}" class="btn btn-primary btn-sm">Tambah</a>
                                </div>
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
                                            <th>Action</th>
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
                                                <td>
                                                    <a href="{{ route('profil.organisasi.edit', ['organisasi' => $organisasi->id]) }}" class="btn btn-sm btn-warning mb-1"><i class="fa fa-edit"></i></a>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-delete-organisasi mb-1" data-id="{{$organisasi->id}}"><i class="fa fa-trash"></i></a>
                                                </td>
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
        </section>
    </div>
@endsection

@section('script')
    <!-- SweetAlert2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <!-- page script -->
    <script type="text/javascript" language="javascript">
    $(function (){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

        // DELETE PEKERJAAN
        $(document).on("click", ".btn-delete-pekerjaan", function(){
            var id = $(this).data("id");
            console.log(id);
            $confirm = confirm("Are you sure want to delete !");
            if($confirm)
            {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('profil.pekerjaan.store') }}"+'/'+id,
                    dataType: 'JSON',
                    success: function (data) {
                        location.reload();
                    },
                    error: function (data) {
                        toastr.error('Something error')
                    }
                });      
            }
        });  

        // DELETE ORGANISASIs
        $(document).on("click", ".btn-delete-organisasi", function(){
            var id = $(this).data("id");
            console.log(id);
            $confirm = confirm("Are you sure want to delete !");
            if($confirm)
            {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('profil.organisasi.store') }}"+'/'+id,
                    dataType: 'JSON',
                    success: function (data) {
                        location.reload();
                    },
                    error: function (data) {
                        toastr.error('Something error')
                    }
                });      
            }
        });  
    });
    </script>
@endsection