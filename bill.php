<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

// Timezone
date_default_timezone_set('Asia/Kolkata'); 

// Fix price
if(isset($_POST['amount'])){
    $_POST['price'] = $_POST['amount'];
}

// Clean price
$raw_price   = str_replace(['₹', ','], '', $_POST['price'] ?? '0'); 
$price       = (float)$raw_price;

// ✅ FIXED
$painting_id = (int)($_POST['painting_id'] ?? 0);

// Inputs
$name    = mysqli_real_escape_string($conn, $_POST['name'] ?? 'Guest');
$email   = mysqli_real_escape_string($conn, $_POST['email'] ?? ''); 
$phone   = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
$address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
$title   = mysqli_real_escape_string($conn, $_POST['p_title'] ?? 'Artwork');

$quantity = (int)($_POST['quantity'] ?? 1);   
$total = $price * $quantity;
$method   = mysqli_real_escape_string($conn, $_POST['method'] ?? 'N/A'); 
// ✅ USER AUTO CREATE (YAHI FIX HAI)
$check_user = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");

if(mysqli_num_rows($check_user) > 0){
    $user = mysqli_fetch_assoc($check_user);
    $user_id = $user['id'];
} else {
    mysqli_query($conn, "INSERT INTO users (name,email,phone,address,password) 
    VALUES ('$name','$email','$phone','$address','')");

    $user_id = mysqli_insert_id($conn);
}


$bill_no = "ART-" . rand(100000, 999999);

// Insert
$query = "INSERT INTO orders 
(name, email, painting_id, painting, price, quantity, total, status, phone, address, payment) 
VALUES 
('$name', '$email', $painting_id, '$title', $price, $quantity, $total, 'Pending', '$phone', '$address', '$method')";

if (!mysqli_query($conn, $query)) {
    die("Order Error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Invoice #<?php echo $bill_no; ?></title>

<style>
:root { --primary:#2c3e50; --accent:#2ecc71; --text:#333; }

body {
    background:#f4f7f6;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color:var(--text);
}

.invoice-card {
    max-width:700px;
    margin:50px auto;
    background:#fff;
    padding:40px;
    border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
    border-top:8px solid var(--primary);
}

.header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:2px solid #eee;
    padding-bottom:20px;
}

.info-grid {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin:30px 0;
}

.order-table {
    width:100%;
    border-collapse:collapse;
    margin:20px 0;
}

.order-table th {
    background:#f9f9f9;
    padding:12px;
}

.order-table td {
    padding:12px;
    border-bottom:1px solid #eee;
}

.total-box {
    background:var(--accent);
    color:#fff;
    padding:15px 30px;
    border-radius:8px;
    font-size:22px;
    font-weight:bold;
    display:inline-block;
}

.actions {
    margin-top:40px;
    display:flex;
    gap:10px;
}

.btn {
    flex:1;
    padding:15px;
    border:none;
    border-radius:6px;
    text-align:center;
    text-decoration:none;
    font-weight:bold;
}

.btn-print { background:var(--primary); color:#fff; }
.btn-home { background:#eee; color:var(--primary); }

@media print {
    .actions { display:none; }
}
</style>
</head>

<body>

<div class="invoice-card">

<div class="header">
    <div>
        <h2>💎 ART GEM GALLERY</h2>
        <p style="color:#777;">Order Confirmation</p>
    </div>
    <div style="text-align:right;">
        <p><strong>#<?php echo $bill_no; ?></strong></p>
        <small><?php echo date("d M Y, h:i A"); ?></small>
    </div>
</div>

<div class="info-grid">
    <div>
        <h4>Billed To:</h4>
        <p><?php echo htmlspecialchars($name); ?></p>
        <p><?php echo htmlspecialchars($email); ?></p>
        <p><?php echo htmlspecialchars($phone); ?></p>
    </div>
    <div>
        <h4>Address:</h4>
        <p><?php echo nl2br(htmlspecialchars($address)); ?></p>
    </div>
</div>

<table class="order-table">
<tr>
    <th>Artwork</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Total</th>
</tr>
<tr>
    <td><?php echo htmlspecialchars($title); ?><br>ID: <?php echo $painting_id; ?></td>
    <td>₹<?php echo number_format($price,2); ?></td>
    <td><?php echo $quantity; ?></td>
    <td>₹<?php echo number_format($total,2); ?></td>
</tr>
</table>

<div style="text-align:right;">
    <p>Payment: <strong><?php echo strtoupper($method); ?></strong></p>
    <div class="total-box">
        ₹<?php echo number_format($total,2); ?>
    </div>
</div>

<p style="text-align:center; margin-top:30px; color:#999;">
  🎊 Thank you for your purchase! ❤️✨
</p>

<div class="actions">
    <button onclick="window.print()" class="btn btn-print">Print</button>
    <a href="index.php" class="btn btn-home">Home</a>
</div>

</div>

</body>
</html> 