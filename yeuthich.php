<?php

if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}

require_once __DIR__ . '/includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Bạn cần đăng nhập!']);
    exit;
}

if (isset($_POST['truyen_id'])) {
    $user_id = $_SESSION['user_id'];
    $truyen_id = (int)$_POST['truyen_id'];

    $check = mysqli_query($conn, "SELECT id FROM yeuthich WHERE user_id = '$user_id' AND truyen_id = '$truyen_id'");

    if (mysqli_num_rows($check) > 0) {
        $sql = "DELETE FROM yeuthich WHERE user_id = '$user_id' AND truyen_id = '$truyen_id'";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['status' => 'removed', 'message' => 'Đã bỏ khỏi yêu thích']);
        }
    } else {
        $sql = "INSERT INTO yeuthich (user_id, truyen_id) VALUES ('$user_id', '$truyen_id')";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['status' => 'added', 'message' => 'Đã thêm vào yêu thích']);
        }
    }
}
?>