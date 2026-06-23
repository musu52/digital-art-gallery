<?php
include 'db.php';

if(isset($_GET['id']) && isset($_GET['status'])){
    
    $id = $_GET['id'];
    $status = $_GET['status'];

    // Update query
    $sql = "UPDATE orders SET status='$status' WHERE id='$id'";
    $res = mysqli_query($conn, $sql);

    if($res){
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "❌ Update Failed: " . mysqli_error($conn);
    }
} else {
    echo "❌ Invalid Request";
}
?>