<?php
require_once __DIR__ . '/../../../includes/functions.php';
require_once __DIR__ . '/../../check_admin.php';
require_once __DIR__ . '/../../../includes/db.php';

$query = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="../../index.php"><i class="fas fa-user-shield"></i> Admin Panel</a>
            <div class="navbar-nav ms-auto text-white align-items-center">
                <span class="me-3">Chào, <?php echo $_SESSION['user_name']; ?>!</span>
                <a class="btn btn-danger btn-sm" href="../../../logout.php">Đăng xuất</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group shadow-sm">
                    <a href="../../index.php" class="list-group-item list-group-item-action"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="../danhmuc/index.php" class="list-group-item list-group-item-action"><i class="fas fa-list me-2"></i>Quản lý Danh mục</a>
                    <a href="../truyen/index.php" class="list-group-item list-group-item-action"><i class="fas fa-book me-2"></i>Quản lý Truyện</a>
                    <a href="index.php" class="list-group-item list-group-item-action active"><i class="fas fa-user me-2"></i>Quản lý Người Dùng</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>Danh sách thành viên</h3>
                    <a href="create.php" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm User</a>
                </div>
                <div class="card border-0 shadow-sm">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3">ID</th>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Quyền</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($query)): ?>
                            <tr class="align-middle">
                                <td class="ps-3">#<?php echo $row['id']; ?></td>
                                <td class="fw-bold"><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo ($row['role'] == 1) ? '<span class="badge bg-danger">Admin</span>' : '<span class="badge bg-info text-dark">User</span>'; ?></td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn chắc chắn muốn xóa?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
            <a href="../../index.php" class="text-decoration-none"><i class="fas fa-arrow-left"></i> Quay lại Dashboard</a>
        </div>
            </div>
        </div>
    </div>
</body>
</html>