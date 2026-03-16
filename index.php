<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php'; 
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$sql = "SELECT * FROM truyen ORDER BY id DESC LIMIT 8";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mê Truyện - Trang Chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">
</head>
<body style="margin-top: 0;">

<header class="main-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-6 col-7 d-flex align-items-center">
                <a href="index.php" class="text-decoration-none logo-text fw-bolder me-4" style="letter-spacing: -1px;">
                    MÊ <span class="text-danger">TRUYỆN</span>
                </a>
                
                <a href="the-loai.php" class="text-decoration-none fw-bold nav-link-item me-2 d-none d-sm-block">
                    <i class="fas fa-th-list me-1 text-secondary"></i> Danh sách
                </a>

                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="tu-sach.php" class="text-decoration-none fw-bold nav-link-item text-danger">
                        <i class="fas fa-heart me-1"></i> Tủ truyện
                    </a>
                <?php endif; ?>
            </div>
            
            <div class="col-lg-4 col-md-3 d-none d-md-block">
                <form action="search.php" method="GET" class="search-container m-0">
                    <i class="fas fa-search"></i>
                    <input type="text" name="keyword" placeholder="Tìm kiếm truyện, tác giả...">
                </form>
            </div>
            
            <div class="col-lg-3 col-md-3 col-5 text-end">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="user/profile.php" class="text-decoration-none d-flex align-items-center justify-content-end text-dark user-link">
                        <span class="fw-bold me-2 small d-none d-lg-inline"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        <div class="nav-avatar">
                            <?php echo get_avatar_letter($_SESSION['user_name']); ?>
                        </div>
                    </a>
                <?php else: ?>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="User/login.php" class="btn btn-sm btn-light border px-3 rounded-pill fw-bold text-muted">Đăng nhập</a>
                        <a href="User/register.php" class="btn btn-sm btn-danger px-3 rounded-pill fw-bold shadow-sm">Đăng ký</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<main class="container mt-5">
    <h3 class="section-title mb-4">MỚI CẬP NHẬT</h3>
    
    <div class="row g-4">
        <?php 
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="col-6 col-md-3">
                <a href="chi-tiet-truyen.php?id=<?php echo $row['id']; ?>" class="text-decoration-none text-dark">
                    <div class="comic-card">
                        <div class="comic-img-box">
                            <img src="public/uploads/<?php echo $row['hinhanh']; ?>" alt="Comic">
                        </div>
                        <div class="comic-info">
                            <div class="fw-bold mb-1 text-truncate"><?php echo $row['tentruyen']; ?></div>
                            <div class="small text-muted d-flex justify-content-between">
                                <span>Chương <?php echo $row['so_chuong']; ?></span>
                                <span><i class="fas fa-eye"></i> <?php echo number_format($row['luot_xem']); ?></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php 
            }
        } else {
            echo '<div class="col-12 text-center py-5">Đang cập nhật dữ liệu...</div>';
        }
        ?>
    </div>
</main>

<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h4 class="fw-bolder mb-3">
                    <span class="text-white">MÊ</span> <span class="text-danger">TRUYỆN</span>
                </h4>
                <p class="text-muted small lh-lg">
                    Hệ thống đọc truyện trực tuyến và nghe audio AI miễn phí, chất lượng cao. Cập nhật liên tục các chương mới nhất của các bộ truyện hot trên thị trường.
                </p>
            </div>
            
            <div class="col-md-4 mb-4 ps-md-5">
                <h5 class="fw-bold text-white mb-3">Liên Kết Nhanh</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php" class="footer-link"><i class="fas fa-angle-right me-2 small"></i>Trang chủ</a></li>
                    <li><a href="the-loai.php" class="footer-link"><i class="fas fa-angle-right me-2 small"></i>Thể loại truyện</a></li>
                    <li><a href="tu-sach.php" class="footer-link"><i class="fas fa-angle-right me-2 small"></i>Tủ truyện của bạn</a></li>
                </ul>
            </div>
            
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold text-white mb-3">Kết Nối Với Chúng Tôi</h5>
                <div class="d-flex mb-3">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
                </div>
                <p class="text-muted small mb-0"><i class="fas fa-envelope me-2"></i> hotro@metruyen.com</p>
            </div>
        </div>
        
        <div class="row mt-4 pt-4 border-top border-secondary text-center">
            <div class="col-12">
                <p class="small text-muted mb-0">&copy; 2026 Toàn bộ bản quyền thuộc về <strong>Mê Truyện Team</strong>. Thiết kế và phát triển với <i class="fas fa-heart text-danger mx-1"></i>.</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>