<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$customers = getActiveCustomers();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Pelanggan Aktif</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Daftar Pelanggan Aktif</h1>
            <nav>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="add_customer.php">Tambah Pelanggan</a></li>
                    <li><a href="active_customers.php" class="active">Pelanggan Aktif</a></li>
                    <li><a href="invoices.php">Tagihan</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <?php if (isset($_GET['success'])): ?>
                <div class="alert success">Pelanggan berhasil ditambahkan!</div>
            <?php endif; ?>
            
            <table class="customer-table">
                <thead>
                    <tr>
                        <th>ID Pelanggan</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Paket</th>
                        <th>Harga</th>
                        <th>Tanggal Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?php echo $customer['customer_id']; ?></td>
                        <td><?php echo $customer['name']; ?></td>
                        <td><?php echo $customer['address']; ?></td>
                        <td><?php echo $customer['phone']; ?></td>
                        <td><?php echo $customer['package']; ?></td>
                        <td>Rp <?php echo number_format($customer['price'], 0, ',', '.'); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($customer['join_date'])); ?></td>
                        <td>
                            <a href="generate_invoice.php?customer_id=<?php echo $customer['customer_id']; ?>" class="btn small">Buat Tagihan</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
