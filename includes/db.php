<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "truyenaudio"; // Tên database theo sơ đồ của bạn

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>