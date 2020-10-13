@extends('layouts.master-user')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Edit Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('profil.anggota.show') }}">Profile</a></li>
                            <li class="breadcrumb-item active">Edit Profile</li>
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

                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Silahkan update data anggota</div>
                            </div>
                            <form action="{{ route('profil.anggota.update') }}" method="POST">
                                @csrf @method('PUT')
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="nama">Nama</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama', $anggota->nama) }}" placeholder="Anggara Putra" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="no_hp">Nomor Handphone</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="no_hp" id="no_hp" value="{{ old('no_hp', $anggota->no_hp) }}" placeholder="082-xxx-xxx-xxx">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="tempat_lahir">Tempat Lahir</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $anggota->tempat_lahir) }}" placeholder="Makassar">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="tanggal_lahir">Tanggal Lahir</label>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', isset($anggota->tanggal_lahir) ? $anggota->tanggal_lahir->format('Y-m-d') : null) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="jenis_kelamin">Jenis Kelamin</label>
                                        <div class="col-md-9">
                                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="LAKI-LAKI" @if(old('jenis_kelamin', $anggota->jenis_kelamin) == 'LAKI-LAKI') selected @endif>LAKI-LAKI</option>
                                                <option value="PEREMPUAN" @if(old('jenis_kelamin', $anggota->jenis_kelamin) == 'PEREMPUAN') selected @endif>PEREMPUAN</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="tahun_dad">Tahun DAD</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="tahun_dad" id="tahun_dad" value="{{ old('tahun_dad', $anggota->tahun_dad) }}" placeholder="2004" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="jurusan_id">Jurusan</label>
                                        <div class="col-md-9">
                                            <select name="jurusan_id" id="jurusan_id" class="form-control" required>
                                                <option value="">Pilih Jurusan</option>
                                                @foreach ($jurusans as $jurusan)
                                                    <option value="{{ $jurusan->id}}" @if(old('jurusan_id', $anggota->jurusan_id) == $jurusan->id) selected @endif>{{ $jurusan->nama }}</option>                                    
                                                @endforeach
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="alamat">Alamat</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="3" placeholder="Jl. Tirto Utomo Gg.4 No.47">{{ old('alamat', $anggota->alamat) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="provinsi_id">Provinsi</label>
                                        <div class="col-md-9">
                                            <select name="provinsi_id" id="provinsi_id" class="form-control">
                                                <option value="">Pilih Provinsi</option>
                                                @foreach ($provinsis as $provinsi)
                                                    <option value="{{$provinsi->id}}" @if(old('provinsi_id', $anggota->provinsi_id) == $provinsi->id) selected @endif>{{$provinsi->nama}}</option>
                                                @endforeach
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="kabupaten_id">Kabupaten/Kota</label>
                                        <div class="col-md-9">
                                            <select name="kabupaten_id" id="kabupaten_id" class="form-control">
                                                <option value="">Pilih Kabupaten</option>
                                                @isset($anggota->provinsi_id)
                                                    @foreach ($kabupatens[$anggota->provinsi_id] as $kabupaten)
                                                        <option value="{{$kabupaten->id}}" @if(old('kabupaten_id', $anggota->kabupaten_id) == $kabupaten->id) selected @endif>{{$kabupaten->nama}}</option>
                                                    @endforeach
                                                @endisset
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="foto">Foto Anggota</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="foto" name="foto">
                                                    <label class="custom-file-label" for="foto">Pilih file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('profil.anggota.show') }}" class="btn btn-default">Batal</a>
                                    <button type="submit" class="btn btn-warning float-right">Update</button>                                    
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