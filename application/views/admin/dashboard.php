<div class="main-content px-4 py-4">
    <section class="row mb-4">
        <h2 class="visually-hidden">Ringkasan Statistik</h2>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h6 class="text-muted text-uppercase mb-2">Total Produk</h6>
                    <h4 class="fw-bold text-primary"><?= $total_produk ?? 0 ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h6 class="text-muted text-uppercase mb-2">Total Pesanan</h6>
                    <h4 class="fw-bold text-info"><?= $total_pesanan ?? 0 ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h6 class="text-muted text-uppercase mb-2">Total Pendapatan</h6>
                    <h4 class="fw-bold text-success">Rp <?= number_format($total_pendapatan ?? 0, 0, ',', '.') ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h6 class="text-muted text-uppercase mb-2">Total Pelanggan</h6>
                    <h4 class="fw-bold text-warning">500+</h4>
                </div>
            </div>
        </div>
    </section>

    <section class="row mb-4">
        <h2 class="visually-hidden">Notifikasi & Ringkasan Pendapatan</h2>
        <div class="col-lg-8 mb-3 mb-lg-0">
            <div class="card rounded-4 animate__animated animate__fadeInUp h-100">
                <div class="card-header bg-primary text-white d-flex align-items-center rounded-top-4 py-3">
                    <i class="fas fa-bell me-2 fa-lg"></i>
                    <h5 class="mb-0">Notifikasi Terbaru</h5>
                </div>
                <div class="card-body p-0"> <?php if (!empty($notifikasi)): ?>
                        <ul class="list-group list-group-flush border-top">
                            <?php foreach ($notifikasi as $notif): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                    <div>
                                        <strong class="text-dark d-block mb-1"><?= htmlspecialchars($notif->nama_pemesan) ?></strong>
                                        <span class="badge rounded-pill bg-<?=
                                            ($notif->status_pesanan === 'Pesanan Selesai') ? 'success' :
                                            (($notif->status_pesanan === 'dibatalkan') ? 'danger' : 'warning') ?>">
                                            <?= htmlspecialchars($notif->status_pesanan) ?>
                                        </span>
                                    </div>
                                    <small class="text-muted text-end"><?= date('d M Y H:i', strtotime($notif->tanggal_pesanan)) ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 text-secondary"></i><br>
                            <p class="mb-0">Belum ada notifikasi baru saat ini.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card rounded-4 bg-success text-white text-center animate__animated animate__fadeInRight">
                        <div class="card-body py-4">
                            <h6 class="mb-2 text-uppercase">Pendapatan Hari Ini</h6>
                            <h3 class="fw-bold">Rp <?= number_format($pendapatan_hari_ini ?? 0, 0, ',', '.') ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card rounded-4 bg-info text-white text-center animate__animated animate__fadeInRight" style="animation-delay: 0.1s;">
                        <div class="card-body py-4">
                            <h6 class="mb-2 text-uppercase">Pendapatan Bulan Ini</h6>
                            <h3 class="fw-bold">Rp <?= number_format($pendapatan_bulan_ini ?? 0, 0, ',', '.') ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="card rounded-4 mb-4 animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
        <div class="card-header bg-success text-white rounded-top-4 py-3">
            <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Grafik Produk Terlaris</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($produk_terlaris_nama) && !empty($produk_terlaris_jumlah)): ?>
                <div class="d-flex justify-content-center py-3">
                    <div style="max-width: 400px; max-height: 400px;">
                        <canvas id="pieProdukTerlaris"></canvas>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center text-muted py-5">
                    <i class="fas fa-exclamation-circle fa-3x mb-3 text-secondary"></i><br>
                    <p class="mb-0">Belum ada data produk terlaris untuk ditampilkan.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="card rounded-4 mb-5 animate__animated animate__fadeIn" style="animation-delay: 0.3s;">
        <div class="card-header bg-info text-white rounded-top-4 py-3">
            <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Grafik Penjualan Bulanan</h5>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height: 350px; width: 100%;">
                <canvas id="linePenjualanBulanan"></canvas>
            </div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://kit.fontawesome.com/your-font-awesome-kit-id.js" crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Pie Chart Produk Terlaris ---
        const pieCtx = document.getElementById('pieProdukTerlaris');
        if (pieCtx) {
            new Chart(pieCtx.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: <?= json_encode($produk_terlaris_nama ?? []) ?>,
                    datasets: [{
                        label: 'Jumlah Terjual',
                        data: <?= json_encode($produk_terlaris_jumlah ?? []) ?>,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#28A745', '#6F42C1', '#fd7e14', '#6610f2'], // More colors
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Allow charts to adapt more freely
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 16,
                                padding: 15,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += context.parsed + ' unit'; // Add 'unit' for clarity
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }

        // --- Line Chart Penjualan Bulanan (Realtime) ---
        let lineChart;
        const lineChartCanvas = document.getElementById('linePenjualanBulanan');

        function loadLineChart() {
            // Ensure the canvas element exists before fetching data
            if (!lineChartCanvas) {
                console.warn("Canvas element for line chart not found.");
                return;
            }

            fetch("<?= site_url('admin/get_data_penjualan_bulanan') ?>")
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(res => {
                    const ctx = lineChartCanvas.getContext('2d');

                    if (lineChart) {
                        // Update existing chart
                        lineChart.data.labels = res.labels;
                        lineChart.data.datasets[0].data = res.data;
                        lineChart.update();
                    } else {
                        // Create new chart
                        lineChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: res.labels,
                                datasets: [{
                                    label: 'Total Penjualan (Rp)',
                                    data: res.data,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: '#36A2EB',
                                    borderWidth: 2,
                                    tension: 0.4,
                                    fill: true,
                                    pointBackgroundColor: '#36A2EB',
                                    pointBorderColor: '#fff',
                                    pointHoverBackgroundColor: '#fff',
                                    pointHoverBorderColor: '#36A2EB'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { position: 'top' }, // Changed legend position
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false // Hide X-axis grid lines
                                        }
                                    },
                                    y: {
                                        beginAtZero: true, // Start Y-axis from zero
                                        ticks: {
                                            callback: function(value) {
                                                return 'Rp ' + value.toLocaleString('id-ID');
                                            }
                                        },
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.05)' // Lighter grid lines
                                        }
                                    }
                                }
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error("Gagal memuat data penjualan bulanan:", error);
                    // Display a user-friendly message on the dashboard if chart fails to load
                    if (lineChartCanvas) {
                        const parent = lineChartCanvas.parentElement;
                        parent.innerHTML = `
                            <div class="text-center text-danger py-5">
                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i><br>
                                <p class="mb-0">Gagal memuat grafik penjualan. Silakan coba lagi nanti.</p>
                            </div>
                        `;
                    }
                });
        }

        // Initial load of the line chart
        loadLineChart();
        // Set interval for refreshing the line chart data every 60 seconds
        setInterval(loadLineChart, 60000);
    });
</script>