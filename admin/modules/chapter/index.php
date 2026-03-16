<?php
require_once '../../check_admin.php'; 
require_once '../../../includes/db.php'; 

// Lấy danh sách chương kèm tên truyện để dễ quản lý
$sql = "SELECT chapter.*, truyen.tentruyen 
        FROM chapter 
        JOIN truyen ON chapter.truyen_id = truyen.id 
        ORDER BY chapter.id DESC";
$query = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Chương - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <h2>Quản lý Chương truyện</h2>
            <a href="create.php" class="btn btn-primary">Thêm chương mới</a>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tên Chương</th>
                            <th>Thuộc Truyện</th>
                            <th>Slug</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($query)){ ?>
                        <tr>
                            <td><strong><?php echo $row['tieude']; ?></strong></td>
                            <td><span class="badge bg-info text-dark"><?php echo $row['tentruyen']; ?></span></td>
                            <td><?php echo $row['slug_chapter']; ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Sửa</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa chương này?')">Xóa</a>
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