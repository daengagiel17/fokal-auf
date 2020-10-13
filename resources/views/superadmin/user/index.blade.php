@extends('layouts.master')

@section('title')
    <title>Manajemen User</title>
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
                    <div class="col-md-12">
                        @if (session('success'))
                            <x-alert type="success" :message="session('success')"/>
                        @endif
                        @if (session('errors'))
                            <x-alert type="danger" :message="session('errors')"/>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Daftar User</h3>
                                <div class="card-tools">
                                    <a href="{{ route('superadmin.akses.user.create') }}" class="btn btn-primary btn-sm">Tambah</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <td>#</td>
                                                <td>Nama</td>
                                                <td>Email</td>
                                                <td>Role</td>
                                                <td>Aksi</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($users as $key => $user)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>
                                                        @foreach ($user->getRoleNames() as $role)
                                                            <label for="" class="badge badge-info">{{ $role }}</label>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('superadmin.akses.user.destroy', $user->id) }}" method="POST">
                                                            @csrf @method('DELETE')
                                                            <a href="{{ route('superadmin.akses.user.roles', $user->id) }}" class="btn btn-info btn-sm"><i class="fa fa-user-secret"></i></a>
                                                            <a href="{{ route('superadmin.akses.user.edit', $user->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">Tidak ada data</td>
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
        </section>
    </div>
@endsection