<?php
require_once '../../check_admin.php'; 
require_once '../../../includes/db.php'; 

// 1. Lấy ID cần xóa
$id = $_GET['id'];

// 2. Thực hiện lệnh xóa trong bảng danhmuc
$sql_delete = "DELETE FROM danhmuc WHERE id = '$id'";

if(mysqli_query($conn, $sql_delete)){
    // Sau khi xóa thành công, quay lại trang index của danh mục
    header('Location: index.php');
} else {
    echo "Lỗi xóa danh mục: " . mysqli_error($conn);
}
?>