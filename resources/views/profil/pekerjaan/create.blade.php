@extends('layouts.master-user')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Tambah Pekerjaan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('profil.anggota.show') }}">Detail Anggota</a></li>
                            <li class="breadcrumb-item active">Tambah Pekerjaan</li>
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
                                <div class="card-title">Silahkan masukkan data pekerjaan anggota</div>
                            </div>
                            <form action="{{ route('profil.pekerjaan.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="jenis">Pekerjaan</label>
                                        <div class="col-md-9">
                                            <input type="hidden" name="anggota_id" value="{{$anggota->id}}">
                                            <select name="jenis" id="jenis" class="form-control" required>
                                                <option value="">Pilih Pekerjaan</option>
                                                <option value="PNS" @if(old('jenis') == 'PNS') selected @endif>Pegawai Negeri Sipil (PNS)</option>
                                                <option value="Karyawan Swasta" @if(old('jenis') == 'Karyawan Swasta') selected @endif>Karyawan Swasta</option>
                                                <option value="Wiraswasta" @if(old('jenis') == 'Wiraswasta') selected @endif>Wiraswasta</option>
                                                <option value="Akademisi" @if(old('jenis') == 'Akademisi') selected @endif>Akademisi</option>
                                                <option value="Freelancer" @if(old('jenis') == 'Freelancer') selected @endif>Freelancer</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="perusahaan">Perusahaan</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="perusahaan" id="perusahaan" value="{{ old('perusahaan') }}" placeholder="PT. Bintang Muda">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="departemen">Departemen</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="departemen" id="departemen" value="{{ old('departemen') }}" placeholder="IT Support">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="jabatan">Jabatan</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="jabatan" id="jabatan" value="{{ old('jabatan') }}" placeholder="Kepala Divisi">
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
                                        <label class="col-md-3 col-form-label" for="deskripsi">Deskripsi</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="3" placeholder="Develop and Maintenance IT System">{{ old('deskripsi') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="provinsi_id">Provinsi</label>
                                        <div class="col-md-9">
                                            <select name="provinsi_id" id="provinsi_id" class="form-control">
                                                <option value="">Pilih Provinsi</option>
                                                @foreach ($provinsis as $provinsi)
                                                    <option value="{{ $provinsi->id}}" @if(old('provinsi_id') == $provinsi->id) selected @endif>{{ $provinsi->nama }}</option>                                    
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