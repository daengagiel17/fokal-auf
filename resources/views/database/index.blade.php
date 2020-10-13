@extends('layouts.master-user')

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap4.css') }}">    
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Anggota</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                            <li class="breadcrumb-item active">Anggota</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-danger card-outline">
                            <div class="card-header ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="angkatan" id="angkatan" class="form-control mt-1 mb-1">
                                            <option value="">Filter berdasarkan angkatan</option> 
                                            @foreach ($angkatans as $angkatan)
                                                <option value="{{$angkatan}}">{{$angkatan}}</option>                                    
                                            @endforeach
                                        </select>    
                                    </div>
                                    <div class="col-md-3">
                                        <select name="rayon" id="rayon" class="form-control mt-1 mb-1">
                                            <option value="">Filter berdasarkan rayon</option> 
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
                            <div class="card-body pl-2 pr-2  table-responsive">
                                <table id="data-anggota" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width:30px">#</th>
                                            <th>Nama</th>
                                            <th>Rayon</th>
                                            <th>Angkatan</th>
                                            <th style="width:90px">Action</th>        
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width:30px">#</th>
                                            <th>Nama</th>
                                            <th>Rayon</th>
                                            <th>Angkatan</th>
                                            <th style="width:90px">Action</th>        
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- page script -->
    <script type="text/javascript" language="javascript">
    $(function (){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        load_data();

        function load_data( angkatan = '', rayon = '')
        {
            $("#data-anggota").DataTable({
                "lengthChange": false,
                "ordering": false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url : "{{ route('database.index') }}",
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
            $('#angkatan').append("<option value=''>Filter berdasarkan angkatan</option>")
            $('#rayon').append("<option value=''>Filter berdasarkan rayon</option>")

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
    });
    </script>
@endsection