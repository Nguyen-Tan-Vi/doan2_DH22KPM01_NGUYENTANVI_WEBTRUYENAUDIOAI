<?php
require_once __DIR__ . '/../../../includes/functions.php';
require_once __DIR__ . '/../../check_admin.php';
require_once __DIR__ . '/../../../includes/db.php';

$id = intval($_GET['id']);

// Chặn Admin tự xóa chính mình để tránh khóa hệ thống
if($id == $_SESSION['user_id']){
    echo "<script>alert('Lỗi: Bạn không thể tự xóa chính mình!'); window.location='index.php';</script>";
} else {
    mysqli_query($conn, "DELETE FROM users WHERE id = '$id'");
    header('Location: index.php');
}
?>