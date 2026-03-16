<?php
require_once '../../../includes/functions.php';
require_once '../../check_admin.php'; 
require_once '../../../includes/db.php'; 

$sql = "SELECT * FROM danhmuc ORDER BY id DESC";
$query = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Danh mục - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-tags text-primary"></i> Quản lý Danh mục</h2>
            <a href="create.php" class="btn btn-success"><i class="fas fa-plus"></i> Thêm mới</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên danh mục</th>
                            <th>Slug</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($query)){ ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><strong><?php echo $row['tendanhmuc']; ?></strong></td>
                            <td><small class="text-muted"><?php echo $row['slug_danhmuc']; ?></small></td>
                            <td>
                                <?php echo $row['kichhoat'] == 1 
                                    ? '<span class="badge bg-info">Hiển thị</span>' 
                                    : '<span class="badge bg-secondary">Tạm ẩn</span>'; ?>
                            </td>
                            <td class="text-center">
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning">Sửa</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa danh mục này sẽ ảnh hưởng đến truyện thuộc thể loại này. Bạn chắc chứ?')">Xóa</a>
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
    </div>
</body>
</html>