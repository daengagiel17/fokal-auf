@extends('layouts.master')

@section('title')
    <title>Set Permissions</title>
@endsection

@section('css')
    <style type="text/css">
        .tab-pane{
            height:150px;
            overflow-y:scroll;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Manajemen Role</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Manajemen Role</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        @if (session('success'))
                            <x-alert type="success" :message="session('success')"/>
                        @endif

                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <div class="card-title">Set Permissions</div>
                            </div>

                            <form action="{{ route('superadmin.akses.role.permissions', $role->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Role</label>
                                        <input type="text" class="form-control" id="name" value="{{ $role->name }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="permission">Permission</label>
                                        <div class="tab-pane active" id="permission">
                                            @foreach ($permissions->chunk(5) as $chunk)
                                                @foreach ($chunk as $key => $permission)
                                                    <input type="checkbox" name="permission[]" class="minimal-red" value="{{ $permission }}" {{ $hasPermission->contains($permission) ? 'checked' : '' }}> 
                                                    {{ $permission }} 
                                                    <br>
                                                @endforeach   
                                                <br>                                                         
                                            @endforeach
                                        </div>
                                    </div> 
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-sm btn-info float-right">Set Permission</button>
                                    <a href="{{ route('superadmin.akses.role.index') }}" class="btn btn-sm btn-danger float-right mr-2">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection