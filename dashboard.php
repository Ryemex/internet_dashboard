<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$monthly_revenue = getMonthlyRevenue();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Dashboard Pelanggan Internet</h1>
            <nav>
                <ul>
                    <li><a href="dashboard.php" class="active">Dashboard</a></li>
                    <li><a href="add_customer.php">Tambah Pelanggan</a></li>
                    <li><a href="active_customers.php">Pelanggan Aktif</a></li>
                    <li><a href="invoices.php">Tagihan</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <section class="stats">
                <div class="stat-card">
                    <h3>Pelanggan Aktif</h3>
                    <p><?php echo count(getActiveCustomers()); ?></p>
                </div>
                
                <div class="stat-card">
                    <h3>Pendapatan Bulan Ini</h3>
                    <p>Rp <?php echo number_format($monthly_revenue[date('n')], 0, ',', '.'); ?></p>
                </div>
            </section>
            
            <section class="chart">
                <h2>Grafik Pendapatan Tahunan</h2>
                <canvas id="revenueChart" width="800" height="400"></canvas>
            </section>
        </main>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        // Data untuk chart
        const revenueData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Pendapatan per Bulan (Rp)',
                data: [<?php echo implode(', ', $monthly_revenue); ?>],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };
        
        // Inisialisasi chart
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'bar',
            data: revenueData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
