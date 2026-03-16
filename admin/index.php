<?php
// Kiểm tra quyền Admin trước khi cho phép vào trang
require_once 'check_admin.php'; 
require_once '../includes/db.php'; 

// 1. Lấy thống kê từ Database sachtruyen
$count_danhmuc = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM danhmuc"));
$count_truyen = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM truyen"));
$count_chapter = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM chapter"));

// Đếm tổng số user (Nếu bạn đã thêm cột role, dùng: WHERE role = 0 để chỉ đếm khách)
$count_users = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users"));
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ thống Quản trị - Web Đọc Truyện AI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .card-stat { transition: transform 0.3s; border: none; }
        .card-stat:hover { transform: translateY(-5px); }
        .list-group-item.active { background-color: #343a40; border-color: #343a40; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="fas fa-user-shield me-2"></i>Admin Panel</a>
            <div class="navbar-nav ms-auto align-items-center">
                <span class="nav-link text-white me-3 small">Chào, <strong><?php echo $_SESSION['user_name']; ?></strong>!</span>
                <a class="btn btn-outline-danger btn-sm" href="login.php">Đăng xuất</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group shadow-sm border-0">
                    <a href="index.php" class="list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a href="modules/danhmuc/index.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-list me-2"></i>Quản lý Danh mục
                    </a>
                    <a href="modules/truyen/index.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-book me-2"></i>Quản lý Truyện
                    </a>
                    <a href="modules/chapter/index.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-alt me-2"></i>Quản lý Chương (Audio)
                    </a>
                    <a href="modules/user/index.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-users me-2"></i>Quản lý Người Dùng
                    </a>
                </div>
            </div>

            <div class="col-md-9">
                <h2 class="mb-4 fw-bold text-dark">Tổng quan hệ thống</h2>
                
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="card card-stat bg-primary text-white shadow-sm h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title small text-uppercase">Danh mục</h6>
                                <h2 class="display-6 fw-bold mb-0"><?php echo $count_danhmuc; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-stat bg-success text-white shadow-sm h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title small text-uppercase">Truyện</h6>
                                <h2 class="display-6 fw-bold mb-0"><?php echo $count_truyen; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-stat bg-warning text-dark shadow-sm h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title small text-uppercase">Chương</h6>
                                <h2 class="display-6 fw-bold mb-0"><?php echo $count_chapter; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-stat bg-info text-white shadow-sm h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title small text-uppercase">Người dùng</h6>
                                <h2 class="display-6 fw-bold mb-0"><?php echo $count_users; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 p-4 bg-white rounded shadow-sm border-0">
                    <h4 class="mb-4 text-dark"><i class="fas fa-rocket me-2 text-primary"></i>Thao tác nhanh</h4>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="modules/truyen/create.php" class="btn btn-outline-primary px-4 shadow-sm">
                            <i class="fas fa-plus me-1"></i> Thêm Truyện
                        </a>
                        <a href="modules/chapter/create.php" class="btn btn-outline-success px-4 shadow-sm">
                            <i class="fas fa-microphone me-1"></i> Đăng Chương AI
                        </a>
                        <a href="modules/user/index.php" class="btn btn-outline-info px-4 shadow-sm text-dark">
                            <i class="fas fa-user-cog me-1"></i> Quản lý Thành viên
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5 py-4 text-center text-muted border-top bg-white">
        <small>&copy; 2026 Admin Panel - Web Truyện Audio</small>
    </footer>

</body>
</html>