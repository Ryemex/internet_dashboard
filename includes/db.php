<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'internet_customers';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk menghasilkan ID pelanggan unik
function generateCustomerId() {
    return 'CUST-' . date('Ymd') . '-' . substr(md5(uniqid()), 0, 6);
}
?>
