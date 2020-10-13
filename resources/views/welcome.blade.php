@extends('layouts.master-user')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"> DB System <small>Fokal IMM Aufklarung</small></h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>            
                            <div class="info-box-content">
                                <span class="info-box-text">Anggota</span>
                                <span class="info-box-number">{{$statistik['jumlah']}} orang</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-bookmark"></i></span>            
                            <div class="info-box-content">
                                <span class="info-box-text">Angkatan</span>
                                <span class="info-box-number">{{$statistik['angkatan']}} tahun</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fas fa-home"></i></span>            
                            <div class="info-box-content">
                                <span class="info-box-text">Tersebar di </span>
                                <span class="info-box-number">{{$statistik['kabupaten']}} kabupaten</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="fas fa-university"></i></span>            
                            <div class="info-box-content">
                                <span class="info-box-text">Tersebar di</span>
                                <span class="info-box-number">{{$statistik['provinsi']}} provinsi</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-danger card-outline">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Selamat Datang!</h5>
                                <p class="card-text">Website ini merupakan database anggota Fokal IMM Aufklarung</p>
                                <p class="card-text">Data anggota yang dihimpun ialah
                                    <ul>
                                        <li>Data Diri</li>
                                        <li>Riwayat Pekerjaan</li>
                                        <li>Riwayat Organisasi</li>
                                    </ul>
                                </p>
                                <p class="card-text">Untuk informasi lebih lanjut silahkan hubungi Ketua Fokal IMM Aufklarung.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="m-0">Pengajuan dan Penelusuran Data</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">Immawan/i dapat mengajukan data sebagai anggota setelah melakukan login dan mengisi data diri.</p>
                                <p class="card-text">Data yang diajukan immawan/i akan diverifikasi oleh admin.</p>
                                <p class="card-text">Penelusuran data dapat dilakukan oleh akun yang telah diverifikasi</p>
                                <a href="{{ route('database.index') }}" class="btn btn-danger">Telusuri Anggota</a>
                            </div>
                        </div>
                    </div>
                </div>
                <h5 class="mt-4 mb-2">Grafik data anggota</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Per Angkatan</h3>
                            </div>
                            <div class="card-body">
                                    <canvas id="barChart" style="min-height: 100%; height: 100%; max-height: 100%; max-width: 100%; display: block; width: 532px;" width="1064" height="1300" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">                        
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Per Rayon</h3>                
                            </div>
                            <div class="card-body">
                                <canvas id="pieChart" style="min-height: 100%; height: 100%; max-height: 100%; max-width: 100%; display: block; width: 532px;" width="1064" height="750" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>                        
                    </div>                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')  
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.4.0/dist/chartjs-plugin-datalabels.min.js"></script> 
    <script>
        $(function () {
            $.get("{{ route('statistik') }}", function (data) {
                console.log(data)
                // STATISTIK ANGGOTA
                var barChartCanvas = $('#barChart').get(0).getContext('2d')
                var barChart = new Chart(barChartCanvas, {
                    type: 'horizontalBar', 
                    data: {
                        labels  : data.anggota.labels,
                        datasets: [{
                            label               : 'Anggota',
                            backgroundColor     : 'rgba(60,141,188,0.9)',
                            borderColor         : 'rgba(60,141,188,0.8)',
                            data                : data.anggota.data
                        }]
                    },
                    options : {
                        scales: {
                            xAxes: [{
                                stacked: true,
                            }],
                        },
                        plugins: {
                            datalabels: {
                                color: '#fff',
                            }
                        },                          
                    }
                })            

                // STATISTIK RAYON
                var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
                var pieChart = new Chart(pieChartCanvas, {
                    type: 'pie',
                    data: {
                        labels: data.rayon.labels,
                        datasets: [{
                            data: data.rayon.data,
                            backgroundColor : ['#DC3446', '#FFC106', '#3994CE', '#fd7e14', '#6f42c1'],
                        }]
                    },
                    options: {
                        tooltips: {
                            enabled: true
                        },
                        plugins: {
                            datalabels: {
                                color: '#fff',
                            }
                        }
                    }
                })
            })
        })
    </script>
@endsection