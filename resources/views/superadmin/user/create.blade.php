@extends('layouts.master')

@section('title')
    <title>Tambah User Baru</title>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Manajemen Users</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Manajemen Users</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Tambah User Baru</h3>
                            </div>
                            <form action="{{ route('superadmin.akses.user.store') }}" method="post">
                                @csrf
                                    <div class="card-body">
                                        @if (session('success'))
                                            <x-alert type="success" :message="session('success')"/>
                                        @endif

                                        <div class="form-group">
                                            <label for="">Nama</label>
                                            <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" placeholder="Masukkan nama" required>
                                            <p class="text-danger">{{ $errors->first('name') }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" placeholder="Masukkan email" required>
                                            <p class="text-danger">{{ $errors->first('email') }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Password</label>
                                            <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}" placeholder="Masukkan password" required>
                                            <p class="text-danger">{{ $errors->first('password') }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Role</label>
                                            <select name="role" class="form-control {{ $errors->has('role') ? 'is-invalid':'' }}" required>
                                                <option value="">Pilih Role</option>
                                                @foreach ($role as $row)
                                                <option value="{{ $row->name }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                            <p class="text-danger">{{ $errors->first('role') }}</p>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-sm btn-primary float-right"><i class="fa fa-send"></i> Simpan</button>
                                        <a href="{{ route('superadmin.akses.user.index') }}" class="btn btn-sm btn-danger float-right mr-2">Batal</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection