<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Pastikan customer_id ada
if (!isset($_GET['customer_id'])) {
    header('Location: active_customers.php');
    exit();
}

$customer_id = $_GET['customer_id'];

// Ambil data pelanggan
$sql = "SELECT * FROM customers WHERE customer_id = '$customer_id'";
$result = $conn->query($sql);
$customer = $result->fetch_assoc();

if (!$customer) {
    header('Location: active_customers.php');
    exit();
}

// Generate nomor invoice
$invoice_number = 'INV-' . date('Ymd') . '-' . substr(md5(uniqid()), 0, 6);
$invoice_date = date('d F Y');
$due_date = date('d F Y', strtotime('+7 days'));

// Buat konten PDF
require_once('tcpdf/tcpdf.php');

// Buat PDF baru
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set dokumen meta
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Internet Provider');
$pdf->SetTitle('Invoice ' . $invoice_number);
$pdf->SetSubject('Invoice Pelanggan');
$pdf->SetKeywords('Invoice, Tagihan, Internet');

// Set margin
$pdf->SetMargins(15, 15, 15);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set font
$pdf->SetFont('helvetica', '', 10);

// Add a page
$pdf->AddPage();

// Konten HTML untuk invoice
$html = '
<h1 style="text-align:center;">INVOICE</h1>
<table>
    <tr>
        <td width="50%">
            <strong>Kepada:</strong><br>
            ' . $customer['name'] . '<br>
            ' . $customer['address'] . '<br>
            Telp: ' . $customer['phone'] . '<br>
            ID Pelanggan: ' . $customer['customer_id'] . '
        </td>
        <td width="50%" style="text-align:right;">
            <strong>No. Invoice:</strong> ' . $invoice_number . '<br>
            <strong>Tanggal:</strong> ' . $invoice_date . '<br>
            <strong>Jatuh Tempo:</strong> ' . $due_date . '
        </td>
    </tr>
</table>

<br><br>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th width="80%">Deskripsi</th>
            <th width="20%">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Tagihan Internet Bulanan - Paket ' . $customer['package'] . '</td>
            <td align="right">Rp ' . number_format($customer['price'], 0, ',', '.') . '</td>
        </tr>
        <tr>
            <td align="right"><strong>TOTAL</strong></td>
            <td align="right"><strong>Rp ' . number_format($customer['price'], 0, ',', '.') . '</strong></td>
        </tr>
    </tbody>
</table>

<br><br>

<p>Pembayaran dapat dilakukan melalui transfer ke:<br>
Bank: BCA<br>
No. Rekening: 1234567890<br>
a.n. Internet Provider</p>

<p>Terima kasih telah menggunakan layanan kami.</p>
';

// Output HTML ke PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Simpan file PDF
$pdf_filename = 'pdf/' . $invoice_number . '.pdf';
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . '/internet_dashboard/' . $pdf_filename, 'F');

// Redirect ke halaman invoice
header('Location: ' . $pdf_filename);
exit();
?>
