@extends('layouts.master-user')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Tambah Organisasi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('profil.anggota.show') }}">Detail Anggota</a></li>
                            <li class="breadcrumb-item active">Tambah Organisasi</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container">
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
                                <div class="card-title">Silahkan update data organisasi anggota</div>
                            </div>
                            <form action="{{ route('profil.organisasi.update', ['organisasi' => $organisasi->id]) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="nama">Nama</label>
                                        <div class="col-md-9">
                                            <input type="hidden" name="anggota_id" value="{{$organisasi->anggota_id}}">
                                            <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama', $organisasi->nama) }}" placeholder="Muhammadiyah" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="lingkup">Lingkup</label>
                                        <div class="col-md-9">
                                            <select name="lingkup" id="lingkup" class="form-control" required>
                                                <option value="Kabupaten/Kota" @if(old('lingkup', $organisasi->lingkup) == 'Kabupaten/Kota') selected @endif>Kabupaten/Kota</option>
                                                <option value="Provinsi" @if(old('lingkup', $organisasi->lingkup) == 'Provinsi') selected @endif>Provinsi</option>
                                                <option value="Nasional" @if(old('lingkup', $organisasi->lingkup) == 'Nasional') selected @endif>Nasional</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="jabatan">Jabatan</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="jabatan" id="jabatan" value="{{ old('jabatan', $organisasi->jabatan) }}" placeholder="Ketua Umum">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="tahun_awal">Mulai</label>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control" name="tahun_awal" id="tahun_awal" value="{{ old('tahun_awal', $organisasi->tahun_awal) }}" placeholder="2000">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="tahun_akhir">Sampai</label>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control" name="tahun_akhir" id="tahun_akhir" value="{{ old('tahun_akhir', $organisasi->tahun_akhir) }}" placeholder="2000">
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
                                                    <option value="{{ $provinsi->id}}" @if(old('provinsi_id', $organisasi->provinsi_id) == $provinsi->id) selected @endif>{{ $provinsi->nama }}</option>                                    
                                                @endforeach
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="kabupaten_id">Kabupaten/Kota</label>
                                        <div class="col-md-9">
                                            <select name="kabupaten_id" id="kabupaten_id" class="form-control">
                                                <option value="">Pilih Kabupaten</option>
                                                @isset($organisasi->provinsi_id)
                                                    @foreach ($kabupatens[$organisasi->provinsi_id] as $kabupaten)
                                                        <option value="{{$kabupaten->id}}" @if(old('kabupaten_id', $organisasi->kabupaten_id) == $kabupaten->id) selected @endif>{{$kabupaten->nama}}</option>
                                                    @endforeach
                                                @endisset
                                            </select>    
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('profil.anggota.show') }}" class="btn btn-default">Batal</a>
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