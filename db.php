<?php
// 🔴 Show errors (development ke liye)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 🔐 Start session only if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🛢️ Database connection
$conn = mysqli_connect("localhost", "root", "", "art_gallery");

// ❌ Connection error handling
if (!$conn) {
    die("❌ Database Connection Failed: " . mysqli_connect_error());
}

// ✅ Set charset (IMPORTANT for emojis & Hindi)
mysqli_set_charset($conn, "utf8mb4");
?>