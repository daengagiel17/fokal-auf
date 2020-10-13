@extends('layouts.master')

@section('title')
    <title>Edit Users</title>
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
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Edit User</h3>
                            </div>
                            <form role="form" action="{{ route('superadmin.akses.user.update', $user->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="card-body">
                                    @if (session('success'))
                                        <x-alert type="success" :message="session('success')"/>
                                    @endif

                                    <div class="form-group">
                                        <label for="">Nama</label>
                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" placeholder="Masukkan nama" required>
                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" name="email" value="{{ $user->email }}" class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" required>
                                        <p class="text-danger">{{ $errors->first('email') }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}" placeholder="Masukkan password">
                                        <p class="text-danger">{{ $errors->first('password') }}</p>
                                        <p class="text-warning">Kosongkan, jika tidak ingin mengganti password</p>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-warning btn-sm float-right"><i class="fa fa-send"></i> Update</button>
                                    <a href="{{ route('superadmin.akses.user.index') }}" class="btn btn-sm btn-danger float-right mr-2">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection