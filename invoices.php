<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Ambil daftar invoice dari folder pdf
$invoices = [];
$pdf_dir = 'pdf/';
if (is_dir($pdf_dir)) {
    if ($dh = opendir($pdf_dir)) {
        while (($file = readdir($dh)) !== false) {
            if (pathinfo($file, PATHINFO_EXTENSION) == 'pdf') {
                $invoices[] = $file;
            }
        }
        closedir($dh);
    }
}

rsort($invoices); // Urutkan dari yang terbaru
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Tagihan</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Daftar Tagihan Pelanggan</h1>
            <nav>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="add_customer.php">Tambah Pelanggan</a></li>
                    <li><a href="active_customers.php">Pelanggan Aktif</a></li>
                    <li><a href="invoices.php" class="active">Tagihan</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>No. Invoice</th>
                        <th>Nama File</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoices as $invoice): 
                        $invoice_date = date('d/m/Y', filemtime($pdf_dir . $invoice));
                    ?>
                    <tr>
                        <td><?php echo pathinfo($invoice, PATHINFO_FILENAME); ?></td>
                        <td><?php echo $invoice; ?></td>
                        <td><?php echo $invoice_date; ?></td>
                        <td>
                            <a href="<?php echo $pdf_dir . $invoice; ?>" class="btn small" target="_blank">Lihat</a>
                            <a href="<?php echo $pdf_dir . $invoice; ?>" class="btn small" download>Unduh</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
