<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'db.php';

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE email='$email' AND password='$pass'";
    $res = mysqli_query($conn, $sql);

    if(!$res){
        die("Error: " . mysqli_error($conn));
    }

    if(mysqli_num_rows($res) > 0){
        $row = mysqli_fetch_assoc($res);
        $_SESSION['admin_id'] = $row['id'];
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<h3 style='color:red;text-align:center;'>❌ Invalid Login</h3>";
    }
}
?>

<form method="POST" style="text-align:center;margin-top:100px;">
    <h2>👑 Admin Login</h2>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button name="login">Login</button>
</form>