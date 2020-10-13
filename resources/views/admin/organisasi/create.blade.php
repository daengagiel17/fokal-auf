@extends('layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <x-content-header>
            <x-slot name="title">
                Tambah Organisasi
            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('admin.anggota.index') }}">Anggota</a></li>        
            <li class="breadcrumb-item"><a href="{{ route('admin.anggota.show', ['anggotum' => $anggota->id]) }}">Detail Anggota</a></li>        
            <li class="breadcrumb-item active">Tambah Organisasi</li>        
        </x-content-header>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                @foreach ($errors->all() as $error)
                                    <strong>Error !</strong> {{ $error }} <br>
                                @endforeach
                            </div>
                        @endif
                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Silahkan masukkan data organisasi anggota</div>
                            </div>
                            <form action="{{ route('admin.organisasi.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="nama">Nama</label>
                                        <div class="col-md-9">
                                            <input type="hidden" name="anggota_id" value="{{$anggota->id}}">
                                            <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama') }}" placeholder="Muhammadiyah" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="lingkup">Lingkup</label>
                                        <div class="col-md-9">
                                            <select name="lingkup" id="lingkup" class="form-control" required>
                                                <option value="Kabupaten/Kota" @if(old('lingkup') == 'Kabupaten/Kota') selected @endif>Kabupaten/Kota</option>
                                                <option value="Provinsi" @if(old('lingkup') == 'Provinsi') selected @endif>Provinsi</option>
                                                <option value="Nasional" @if(old('lingkup') == 'Nasional') selected @endif>Nasional</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="jabatan">Jabatan</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="jabatan" id="jabatan" value="{{ old('jabatan') }}" placeholder="Ketua Umum">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="tahun_awal">Mulai</label>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control" name="tahun_awal" id="tahun_awal" value="{{ old('tahun_awal') }}" placeholder="2000">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="tahun_akhir">Sampai</label>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control" name="tahun_akhir" id="tahun_akhir" value="{{ old('tahun_akhir') }}" placeholder="2000">
                                        </div>
                                        <div class="col-md-4">
                                            <p>Kosongkan jika sampai sekarang</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="provinsi_id">Provinsi</label>
                                        <div class="col-md-9">
                                            <select name="provinsi_id" id="provinsi_id" class="form-control">
                                                <option value="">Pilih Provinsi</option>
                                                @foreach ($provinsis as $provinsi)
                                                    <option value="{{ $provinsi->id}}">{{ $provinsi->nama }}</option>                                    
                                                @endforeach
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="kabupaten_id">Kabupaten/Kota</label>
                                        <div class="col-md-9">
                                            <select name="kabupaten_id" id="kabupaten_id" class="form-control">
                                                <option value="">Pilih Kabupaten</option>
                                            </select>    
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('admin.anggota.show', ['anggotum' => $anggota->id]) }}" class="btn btn-default">Batal</a>
                                    <button type="submit" class="btn btn-primary float-right">Simpan</button>                                    
                                </div> 
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('script')
    <script type="text/javascript" language="javascript">
        $(function (){
            // Select provinsi will set kabupaten
            $('#provinsi_id').on('change', function() {
                var provinsi_id = $(this).val();

                // if select provinsi_id, empty kabupaten then create option select kabupaten
                if(provinsi_id)
                {
                    $('#kabupaten_id').empty(); 
                    $('#kabupaten_id').append("<option value=''>Pilih Kabupaten</option>");
                    var kabupaten = {!! json_encode($kabupatens) !!};

                    for (i = 0; i < kabupaten[provinsi_id].length; i++)
                    {
                        $('#kabupaten_id').append("<option value='" + kabupaten[provinsi_id][i].id + "'>" + kabupaten[provinsi_id][i].nama + "</option>");
                    }
                }
                else
                {
                    $('#kabupaten_id').empty();
                    $('#kabupaten_id').append("<option value=''>Pilih Kabupaten</option>");
                }
            });    
        });
    </script>
@endsection