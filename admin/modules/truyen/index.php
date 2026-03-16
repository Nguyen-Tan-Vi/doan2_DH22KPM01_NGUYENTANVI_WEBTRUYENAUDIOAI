<?php
require_once '../../check_admin.php'; 
require_once '../../../includes/db.php'; 

$sql = "SELECT truyen.*, danhmuc.tendanhmuc 
        FROM truyen 
        JOIN danhmuc ON truyen.danhmuc_id = danhmuc.id 
        ORDER BY truyen.id DESC";
$query = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Truyện - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <h2>Quản lý Truyện</h2>
            <a href="create.php" class="btn btn-primary">Thêm truyện mới</a>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                    <tr>
                        <th>Ảnh bìa</th>
                        <th>Tên truyện</th>
                        <th>Danh mục</th>
                        <th>Tác giả</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($query)){ ?>
                    <tr>
                        <td>
                            <img src="../../../public/uploads/<?php echo $row['hinhanh']; ?>" width="60" class="rounded shadow-sm">
                        </td>
                        <td><strong><?php echo $row['tentruyen']; ?></strong></td>
                        <td><span class="badge bg-secondary"><?php echo $row['tendanhmuc']; ?></span></td>
                        <td><?php echo $row['tacgia']; ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa truyện sẽ mất hết các chương liên quan. Bạn chắc chứ?')">Xóa</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">
            <a href="../../index.php" class="text-decoration-none"><i class="fas fa-arrow-left"></i> Quay lại Dashboard</a>
        </div>
</body>
</html>