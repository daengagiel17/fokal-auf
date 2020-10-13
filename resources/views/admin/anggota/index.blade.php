@extends('layouts.master')

@section('css')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">    
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap4.css') }}">    
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <x-content-header>
            <x-slot name="title">
                Anggota
            </x-slot>
            <li class="breadcrumb-item active">Anggota</li>        
        </x-content-header>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="angkatan" id="angkatan" class="form-control mt-1 mb-1">
                                            <option value="">Pilih tahun dad</option> 
                                            @foreach ($angkatans as $angkatan)
                                                <option value="{{$angkatan}}">{{$angkatan}}</option>                                    
                                            @endforeach
                                        </select>    
                                    </div>
                                    <div class="col-md-3">
                                        <select name="rayon" id="rayon" class="form-control mt-1 mb-1">
                                            <option value="">Pilih rayon</option> 
                                            @foreach ($rayons as $rayon)
                                                <option value="{{$rayon->id}}">{{$rayon->nama}}</option>                                    
                                            @endforeach
                                        </select>    
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" id="reset-filter" name="reset-filter" class="btn btn-sm btn-block btn-danger mt-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {{-- Daftar Anggota --}}
                        <x-data-table>
                            <x-slot name="title">Daftar Anggota</x-slot>
                            <x-slot name="tools">
                                <a href="{{ route('admin.anggota.create') }}" class="btn btn-sm btn-primary">Tambah</a>
                            </x-slot>
                            <x-slot name="id">data-anggota</x-slot>
                            <x-slot name="column">
                                <th style="width:30px">#</th>
                                <th>Nama</th>
                                <th>Rayon</th>
                                <th>Tahun DAD</th>
                                <th style="width:90px">Action</th>        
                            </x-slot>
                        </x-data-table>
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
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
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

        load_data();

        function load_data( angkatan = '', rayon = '')
        {
            $("#data-anggota").DataTable({
                // "processing": true,
                "serverSide": true,
                "ajax": {
                    url : "{{ route('admin.anggota.index') }}",
                    data : {
                        angkatan: angkatan,
                        rayon: rayon,
                    }
                },
                "columns": [
                    { data: 'DT_RowIndex', name: 'id' },
                    { data: "nama", name: "nama" },
                    { data: "rayon.nama", name: "rayon.nama" },
                    { data: "tahun_dad", name: "tahun_dad" },
                    { data: "action", name: "action" }
                ],
                "order": [[ 0, 'desc' ]]
            });
        }
        
        // Reset Filter
        $('#reset-filter').click(function() {
            console.log('click');
            // Hapus data filter
            $('#angkatan').empty();
            $('#rayon').empty();       

            // Create filter default
            $('#angkatan').append("<option value=''>Pilih tahun dad</option>")
            $('#rayon').append("<option value=''>Pilih rayon</option>")

            // Fill data filter
            var angkatans = {!! json_encode($angkatans) !!};
            for (i = 0; i < angkatans.length; i++)
            {
                $('#angkatan').append("<option value='" + angkatans[i] + "'>" + angkatans[i] + "</option>");
            }

            var rayons = {!! json_encode($rayons) !!};
            for (i = 0; i < rayons.length; i++)
            {
                $('#rayon').append("<option value='" + rayons[i].id + "'>" + rayons[i].nama + "</option>");
            }

            $('#data-anggota').DataTable().destroy();
            load_data();
        });

        // Filter angkatan
        $('#angkatan').on('change', function() {
            var angkatan = $('#angkatan').val();
            var rayon = $('#rayon').val();
            $('#data-anggota').DataTable().destroy();
            load_data(angkatan, rayon);
        }); 

        // Filter rayon
        $('#rayon').on('change', function() {
            var angkatan = $('#angkatan').val();
            var rayon = $('#rayon').val();
            $('#data-anggota').DataTable().destroy();
            load_data(angkatan, rayon);
        }); 

        // verify
        $(document).on("click", ".btn-verify", function(){
            var id = $(this).data("id");
            console.log(id);
            $confirm = confirm("Verifikasi sebagai kader");
            if($confirm)
            {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.anggota.store') }}"+'/'+id+'/verify',
                    dataType: 'JSON',
                    success: function (data) {
                        $('#crud-form').trigger("reset");
                        $('#crud-modal').modal('hide');
                        $('#data-anggota').DataTable().destroy();
                        load_data();                
                        toastr.success('Data telah diverifikasi')
                    },
                    error: function (data) {
                        toastr.error('Something error')
                    }
                });      
            }
            else
            {
                $confirm = confirm("Hapus data ini kader");
                if($confirm)
                {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('admin.anggota.store') }}"+'/'+id,
                        dataType: 'JSON',
                        success: function (data) {
                            $('#crud-form').trigger("reset");
                            $('#crud-modal').modal('hide');
                            $('#data-anggota').DataTable().destroy();
                            load_data();                
                            toastr.success('Data dihapus')
                        },
                        error: function (data) {
                            toastr.error('Something error')
                        }
                    });      
                }                
            }
        }); 
    });
    </script>
@endsection