<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Kiểm tra xem đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header('Location: ../user/login.php');
    exit();
}

// 2. Kiểm tra quyền (role 1 là admin, 0 là user)
if ($_SESSION['user_role'] != 1) {
    // Nếu không phải admin, đá về trang chủ hoặc hiện thông báo lỗi
    echo "<script>
            alert('Bạn không có quyền truy cập vào khu vực này!');
            window.location.href = '../index.php';
          </script>";
    exit();
}
?>