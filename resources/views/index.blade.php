@extends('layouts.main')

@section('content')
    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Usulan Card -->
                    <div class="col-4">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Usulan</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-file-text"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalUsulan }}</h6>
                                        <span class="text-primary small pt-1 fw-bold">{{ $usulan->count() }}</span>
                                        <span class="text-muted small pt-2 ps-1">dalam 7 hari terakhir</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Usulan Card -->

                    <!-- Usulan Disetujui Card -->
                    <div class="col-4">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Usulan Disetujui</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-check-circle"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalUsulanDisetujui }}</h6>
                                        <span
                                            class="text-success small pt-1 fw-bold">{{ $usulan->where('status', 'disetujui')->count() }}</span>
                                        <span class="text-muted small pt-2 ps-1">dalam 7 hari terakhir</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Usulan Disetujui Card -->

                    <!-- Arsip Card -->
                    <div class="col-4">

                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Arsip</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-archive"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalArsip }}</h6>
                                        <span class="text-danger small pt-1 fw-bold">{{ $arsip->count() }}</span>
                                        <span class="text-muted small pt-2 ps-1">dalam 7 hari terakhir</span>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->

                    <!-- Reports -->
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <h5 class="card-title">Ringkasan Aktivitas Surat Mingguan <span>| 7 hari terakhir</span>
                                </h5>

                                <!-- Line Chart -->
                                <div id="reportsChart"></div>
                                <!-- End Line Chart -->

                            </div>

                        </div>
                    </div><!-- End Reports -->

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- Recent Activity -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Activitas Terakhir</h5>

                        <div class="activity">
                            @if ($activities->isEmpty())
                                <p>Tidak ada aktivitas terbaru.</p>
                            @else
                                @foreach ($activities as $activity)
                                    <div class="activity-item d-flex">
                                        <div class="activite-label" style="width: 50px">
                                            {{ $activity->created_at->diffForHumans(['short' => true]) }}</div>
                                        <i
                                            class='bi bi-circle-fill activity-badge text-{{ $activity->type }} align-self-start'></i>
                                        <div class="activity-content">
                                            <span class="fw-bold text-dark">{{ $activity->user->name }}</span>
                                            {{ $activity->log }}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                    </div>
                </div><!-- End Recent Activity -->

                <!-- Website Traffic -->
                <div class="card">

                    <div class="card-body pb-0">
                        <h5 class="card-title">Usulan Surat <span>| 7 hari terakhir</span></h5>

                        <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                echarts.init(document.querySelector("#trafficChart")).setOption({
                                    tooltip: {
                                        trigger: 'item'
                                    },
                                    legend: {
                                        top: '5%',
                                        left: 'center'
                                    },
                                    series: [{
                                        name: 'Access From',
                                        type: 'pie',
                                        radius: ['40%', '70%'],
                                        avoidLabelOverlap: false,
                                        label: {
                                            show: false,
                                            position: 'center'
                                        },
                                        emphasis: {
                                            label: {
                                                show: true,
                                                fontSize: '18',
                                                fontWeight: 'bold'
                                            }
                                        },
                                        labelLine: {
                                            show: false
                                        },
                                        data: [{
                                                value: {{ $usulan->filter(function ($usulan) {
                                                        return $usulan->jenis_usulan === 'Surat Cuti';
                                                    })->count() }},
                                                name: 'Surat Cuti'
                                            },
                                            {
                                                value: {{ $usulan->filter(function ($usulan) {
                                                        return $usulan->jenis_usulan === 'Surat Pengantar';
                                                    })->count() }},
                                                name: 'Surat Pengantar'
                                            },
                                            // {
                                            //     value: 0,
                                            //     name: 'Surat ABC'
                                            // },
                                            // {
                                            //     value: 0,
                                            //     name: 'Surat Lainnya'
                                            // }
                                        ]
                                    }]
                                });
                            });
                        </script>

                    </div>
                </div><!-- End Website Traffic -->

            </div><!-- End Right side columns -->

        </div>
    </section>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Data dari controller
            const usulanData = @json($usulan);
            const arsipData = @json($arsip);

            // Mendapatkan rentang 7 hari terakhir
            const dates = [];
            const today = new Date();

            for (let i = 6; i >= 0; i--) {
                const date = new Date();
                date.setDate(today.getDate() - i);
                date.setHours(0, 0, 0, 0);
                dates.push(date);
            }

            // Format tanggal untuk kategori xaxis
            const formattedDates = dates.map(date => {
                return date.toISOString();
            });

            // Mempersiapkan data untuk chart
            const usulanCounts = Array(7).fill(0);
            const disetujuiCounts = Array(7).fill(0);
            const arsipCounts = Array(7).fill(0);

            // Menghitung jumlah usulan per hari
            usulanData.forEach(item => {
                const createdAt = new Date(item.created_at);
                createdAt.setHours(0, 0, 0, 0);

                for (let i = 0; i < 7; i++) {
                    if (createdAt.getTime() === dates[i].getTime()) {
                        usulanCounts[i]++;
                        break;
                    }
                }
            });

            // Menghitung jumlah usulan yang disetujui per hari
            usulanData.forEach(item => {
                if (item.status === "disetujui" && item.approved_at) {
                    const approvedAt = new Date(item.approved_at);
                    approvedAt.setHours(0, 0, 0, 0);

                    for (let i = 0; i < 7; i++) {
                        if (approvedAt.getTime() === dates[i].getTime()) {
                            disetujuiCounts[i]++;
                            break;
                        }
                    }
                }
            });

            // Menghitung jumlah arsip per hari
            arsipData.forEach(item => {
                const createdAt = new Date(item.created_at);
                createdAt.setHours(0, 0, 0, 0);

                for (let i = 0; i < 7; i++) {
                    if (createdAt.getTime() === dates[i].getTime()) {
                        arsipCounts[i]++;
                        break;
                    }
                }
            });

            // Membuat chart
            new ApexCharts(document.querySelector("#reportsChart"), {
                series: [{
                    name: 'Usulan',
                    data: usulanCounts,
                }, {
                    name: 'Usulan Disetujui',
                    data: disetujuiCounts,
                }, {
                    name: 'Arsip',
                    data: arsipCounts,
                }],
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar: {
                        show: false
                    },
                },
                markers: {
                    size: 4
                },
                colors: ['#4154f1', '#2eca6a', '#ff771d'],
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.4,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                xaxis: {
                    type: 'datetime',
                    categories: formattedDates
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy'
                    },
                }
            }).render();
        });
    </script>
@endpush
