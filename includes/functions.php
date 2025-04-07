<?php
require_once 'db.php';

// Fungsi untuk menambahkan pelanggan baru
function addCustomer($data) {
    global $conn;
    
    $customer_id = generateCustomerId();
    $name = $conn->real_escape_string($data['name']);
    $address = $conn->real_escape_string($data['address']);
    $phone = $conn->real_escape_string($data['phone']);
    $package = $conn->real_escape_string($data['package']);
    $price = (float)$data['price'];
    $join_date = date('Y-m-d');
    $status = 'active';
    
    $sql = "INSERT INTO customers (customer_id, name, address, phone, package, price, join_date, status) 
            VALUES ('$customer_id', '$name', '$address', '$phone', '$package', $price, '$join_date', '$status')";
    
    return $conn->query($sql);
}

// Fungsi untuk mendapatkan semua pelanggan aktif
function getActiveCustomers() {
    global $conn;
    
    $sql = "SELECT * FROM customers WHERE status = 'active' ORDER BY name";
    $result = $conn->query($sql);
    
    $customers = [];
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }
    
    return $customers;
}

// Fungsi untuk mendapatkan data pendapatan bulanan
function getMonthlyRevenue() {
    global $conn;
    
    $sql = "SELECT 
                MONTH(payment_date) as month, 
                SUM(amount) as total 
            FROM payments 
            WHERE YEAR(payment_date) = YEAR(CURRENT_DATE())
            GROUP BY MONTH(payment_date)";
    
    $result = $conn->query($sql);
    
    $revenue = array_fill(1, 12, 0);
    while ($row = $result->fetch_assoc()) {
        $revenue[$row['month']] = (float)$row['total'];
    }
    
    return $revenue;
}
?>
