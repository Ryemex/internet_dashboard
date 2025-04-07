<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (addCustomer($_POST)) {
        header('Location: active_customers.php?success=1');
        exit();
    } else {
        $error = "Gagal menambahkan pelanggan. Silakan coba lagi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Tambah Pelanggan</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Tambah Pelanggan Baru</h1>
            <nav>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="add_customer.php" class="active">Tambah Pelanggan</a></li>
                    <li><a href="active_customers.php">Pelanggan Aktif</a></li>
                    <li><a href="invoices.php">Tagihan</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <?php if (isset($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" class="customer-form">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea id="address" name="address" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
                
                <div class="form-group">
                    <label for="package">Paket Internet</label>
                    <select id="package" name="package" required>
                        <option value="">Pilih Paket</option>
                        <option value="10 Mbps">10 Mbps - Rp 200.000</option>
                        <option value="20 Mbps">20 Mbps - Rp 300.000</option>
                        <option value="50 Mbps">50 Mbps - Rp 500.000</option>
                        <option value="100 Mbps">100 Mbps - Rp 800.000</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="price">Harga</label>
                    <input type="number" id="price" name="price" required>
                </div>
                
                <button type="submit" class="btn">Simpan Pelanggan</button>
            </form>
        </main>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        // Update harga berdasarkan paket yang dipilih
        document.getElementById('package').addEventListener('change', function() {
            const package = this.value;
            let price = 0;
            
            switch(package) {
                case '10 Mbps':
                    price = 200000;
                    break;
                case '20 Mbps':
                    price = 300000;
                    break;
                case '50 Mbps':
                    price = 500000;
                    break;
                case '100 Mbps':
                    price = 800000;
                    break;
            }
            
            document.getElementById('price').value = price;
        });
    </script>
</body>
</html>
