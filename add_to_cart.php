<?php
include 'db.php'; // Aapki database connection file
session_start();

if(isset($_POST['add_to_cart'])) {
    $painting_id = $_POST['painting_id'];
    // User session se user_id lein (agar login hai)
    $user_id = $_SESSION['user_id'] ?? 0; 

    // Check karein ki item pehle se cart mein to nahi
    $check_cart = mysqli_query($conn, "SELECT * FROM cart WHERE painting_id = '$painting_id' AND user_id = '$user_id'");

    if(mysqli_num_rows($check_cart) > 0) {
        echo "<script>alert('Item already in cart!'); window.location.href='index.php';</script>";
    } else {
        $query = "INSERT INTO cart (user_id, painting_id) VALUES ('$user_id', '$painting_id')";
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Added to Cart!'); window.location.href='index.php';</script>";
        }
    }
}
?>