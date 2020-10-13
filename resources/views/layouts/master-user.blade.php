<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>DB Fokal IMM Aufklarung</title>
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.jpg')}}" type="image/jpg">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Required Meta Tags Always Come First -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Database kader, kader IMM, forum komunikasi alumni IMM, Fokal IMM, IMM Aufklarung">
    <meta name="title" content="Fokal IMM Aufklarung">
    <meta name="description" content="Database Anggota Fokal IMM Aufklarung">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="profile">
    <meta property="og:url" content="https://simkat.dpcFokalmalang.org/">
    <meta property="og:title" content="Fokal IMM Aufklarung">
    <meta property="og:description" content="Database Anggota Fokal IMM Aufklarung">
    <meta property="og:image" content="{{ asset('img/favicon.jpg')}}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://simkat.dpcFokalmalang.org/">
    <meta property="twitter:title" content="Fokal IMM Aufklarung">
    <meta property="twitter:description" content="Database Anggota Fokal IMM Aufklarung">
    <meta property="twitter:image" content="{{ asset('img/favicon.jpg')}}">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    @yield('css')
</head>

@section('layout')
    <body class="hold-transition layout-top-nav">
@show


<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light navbar-white border-bottom">
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand">
                <img src="{{ asset('img/logo.jpg') }}" alt="Fokal Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">DB Fokal IMM Aufklarung</span>
            </a>
            
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <img src="{{ asset(Auth::user()->foto) }}" alt="Fokal Logo" class="brand-image img-circle elevation-2" style="opacity: .8">
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-header">{{Auth::user()->name}}</span>
                            @role('admin')
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('admin.index') }}" class="dropdown-item">
                                    <i class="fas fa-th-large mr-2"></i> Dashboard Admin
                                </a>
                            @endrole
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('profil.anggota.show', ['anggotum' => Auth::user()->anggota_id ]) }}" class="dropdown-item">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item dropdown-footer" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                LOGOUT
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endauth
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login.provider', ['provider' => 'google']) }}"><i class="far fa-user"></i> LOGIN</a>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
    <!-- /.navbar -->

    @yield('content')

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Copyright &copy; 2014-2018 <a href="https://adminlte.io">AdminLTE.io</a> | All rights reserved.
        </div>
        <!-- Default to the left -->
        <strong>Develop by <b><a href="http://irit-io.id">Irit.io</a></b>.</strong> Turning ideas into code.
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

@yield('script')

</body>
</html>