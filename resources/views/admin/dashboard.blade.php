@extends('layouts.master')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
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
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Data Per Angkatan</h3>
                            </div>
                            <div class="card-body">
                                    <canvas id="barChart" style="min-height: 100%; height: 100%; max-height: 100%; max-width: 100%; display: block; width: 532px;" width="1064" height="1300" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>                        
                    </div>
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Data Per Rayon</h3>                
                            </div>
                            <div class="card-body">
                                <canvas id="pieChart" style="min-height: 100%; height: 100%; max-height: 100%; max-width: 100%; display: block; width: 532px;" width="1064" height="750" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>                        
                    </div>                    
                </div>
            </div>
        </section>
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