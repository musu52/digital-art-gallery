<?php
session_start();
include 'db.php';
// 🔐 Admin login check (IMPORTANT)
if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}

// 📊 Total Counts
$user_result=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM users"));
$total_users=$user_result['total'];
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders"))['total'];
$total_paintings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM paintings"))['total'];
$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as total FROM orders WHERE status='Delivered'"))['total'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>👑 Admin Dashboard</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI';
            background: #f4f6f9;
        }

        /* 🔝 Navbar */
        .navbar {
            background: #2c3e50;
            color: white;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        /* 📊 Dashboard Cards */
        .container {
            padding: 30px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            text-align: center;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-8px);
        }

        .card h2 {
            margin: 10px 0;
            color: #333;
        }

        .card p {
            color: gray;
        }

        /* 📦 Orders Table */
        .table-box {
            margin-top: 40px;
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background: #34495e;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        /* 🎨 Status */
        .status {
            padding: 6px 12px;
            border-radius: 20px;
            color: white;
            font-size: 12px;
        }

        .delivered { background: #2ecc71; }
        .pending { background: #f39c12; }
        .cancel { background: #e74c3c; }

        /* ⚙️ Buttons */
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            color: white;
        }

        .btn-deliver { background: #27ae60; }
        .btn-cancel { background: #c0392b; }
    </style>
</head>

<body>

<!-- 🔝 Navbar -->
<div class="navbar">
    <h2>👑 Admin Panel</h2>
    <a href="logout.php">🚪 Logout</a>
</div>

<div class="container">

    <!-- 📊 CARDS -->
    <div class="cards">
        <div class="card">
            <h2>👥 <?php echo $total_users; ?></h2>
            <p>Total Users</p>
        </div>

        <div class="card">
            <h2>🛒 <?php echo $total_orders; ?></h2>
            <p>Total Orders</p>
        </div>

        <div class="card">
            <h2>🎨 <?php echo $total_paintings; ?></h2>
            <p>Total Paintings</p>
        </div>

        <div class="card">
            <h2>₹<?php echo $total_revenue ? $total_revenue : 0; ?></h2>
            <p>Total Revenue</p>
        </div>
    </div>

    <!-- 📦 ORDERS -->
    <div class="table-box">
        <h2>📦 Recent Orders</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Painting</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php
            $orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC ");

            while($row = mysqli_fetch_assoc($orders)) {

                $statusClass = "pending";
                if($row['status'] == "Delivered") $statusClass = "delivered";
                if($row['status'] == "Cancelled") $statusClass = "cancel";

                echo "<tr>
                        <td>#{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['painting']}</td>
                        <td>₹{$row['total']}</td>
                        <td><span class='status $statusClass'>{$row['status']}</span></td>
                        <td>
                            <a href='update_order.php?id={$row['id']}&status=Delivered' class='btn btn-deliver'>✔ Deliver</a>
                            <a href='update_order.php?id={$row['id']}&status=Cancelled' class='btn btn-cancel'>❌ Cancel</a>
                        </td>
                      </tr>";

            }
            ?>
    </table>
    </div>

</div>

</body>
</html>