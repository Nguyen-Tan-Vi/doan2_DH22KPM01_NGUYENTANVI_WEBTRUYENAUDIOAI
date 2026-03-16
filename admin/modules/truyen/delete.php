<?php
require_once '../../check_admin.php'; 
require_once '../../../includes/db.php'; 

$id = $_GET['id'];

// 1. Lấy tên file ảnh cũ để xóa
$sql_img = "SELECT hinhanh FROM truyen WHERE id = '$id'";
$res = mysqli_query($conn, $sql_img);
$row = mysqli_fetch_assoc($res);
unlink('../../../public/uploads/'.$row['hinhanh']); // Xóa file thật

// 2. Xóa dữ liệu trong DB
mysqli_query($conn, "DELETE FROM truyen WHERE id = '$id'");
header('Location: index.php');
?>