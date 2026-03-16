<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php'; 
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// 1. Lấy tham số lọc và Phân trang
$id_dm = isset($_GET['the-loai']) ? mysqli_real_escape_string($conn, $_GET['the-loai']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'new';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if($page <= 0) $page = 1;

$limit = 12; // Số truyện mỗi trang
$offset = ($page - 1) * $limit;

// 2. Xây dựng điều kiện lọc (Sửa lại id_danh_muc cho khớp bảng truyen của bạn)
$where = " WHERE 1=1";
if (!empty($id_dm)) {
    // Nếu trong bảng truyen của bạn là iddanhmuc (viết liền) thì hãy xóa dấu gạch dưới ở đây
    $where .= " AND id = '$id_dm'"; 
}

// 3. Tính tổng số truyện để chia trang
$sql_count = "SELECT COUNT(*) as total FROM truyen $where";
$res_count = mysqli_query($conn, $sql_count);
$total_records = mysqli_fetch_assoc($res_count)['total'];
$total_pages = ceil($total_records / $limit);

// 4. Lấy danh sách truyện theo trang
$order = ($sort == 'hot') ? "ORDER BY luot_xem DESC" : "ORDER BY id DESC";
$sql_truyen = "SELECT * FROM truyen $where $order LIMIT $limit OFFSET $offset";
$result_truyen = mysqli_query($conn, $sql_truyen);

// 5. Lấy danh sách danh mục (Bảng danhmuc, cột tendanhmuc viết liền)
$sql_categories = "SELECT * FROM danhmuc ORDER BY tendanhmuc ASC";
$res_categories = mysqli_query($conn, $sql_categories);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mê Truyện - Danh Mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">
    <style>
    /* Màu mặc định cho các ô thể loại */
    .genre-item {
        background-color: #333;
        color: #ccc;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        margin: 5px;
        transition: 0.3s;
    }

    /* Màu khi di chuột qua */
    .genre-item:hover {
        background-color: #444;
        color: #fff;
    }

    /* Màu đỏ cho ô ĐANG CHỌN */
    .active-genre {
        background-color: #dc3545 !important; /* Màu đỏ của Bootstrap (btn-danger) */
        color: white !important;
        font-weight: bold;
    }
</style>
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

<main class="container">
    <div class="filter-section bg-white p-4 rounded-4 shadow-sm mb-5">
        <div class="mb-3">
            <div class="fw-bold mb-2 text-secondary small">DANH MỤC:</div>
            <div class="filter-tags">
                <a href="the-loai.php?sort=<?php echo $sort; ?>" 
                   class="btn btn-sm px-3 rounded-pill fw-bold <?php echo ($id_dm == '' || $id_dm == 0) ? 'btn-danger active' : 'btn-outline-light border'; ?>">
                   Tất cả
                </a>

                <?php 
                // Reset con trỏ dữ liệu danh mục
                mysqli_data_seek($res_categories, 0); 
                while($dm = mysqli_fetch_assoc($res_categories)): 
                ?>
                    <a href="the-loai.php?the-loai=<?php echo $dm['id']; ?>&sort=<?php echo $sort; ?>" 
                       class="btn btn-sm px-3 rounded-pill fw-bold <?php echo ($id_dm == $dm['id']) ? 'btn-danger active' : 'btn-outline-light border'; ?> m-1">
                       <?php echo htmlspecialchars($dm['tendanhmuc']); ?>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>

        <hr class="opacity-10">

        <div>
            <div class="fw-bold mb-2 text-secondary small">SẮP XẾP:</div>
            <a href="?the-loai=<?php echo $id_dm; ?>&sort=new" 
               class="btn btn-sm px-3 rounded-pill fw-bold <?php echo ($sort == 'new' || $sort == '') ? 'btn-danger active' : 'btn-outline-light border'; ?>">
               Mới nhất
            </a>
            
            <a href="?the-loai=<?php echo $id_dm; ?>&sort=hot" 
               class="btn btn-sm px-3 rounded-pill fw-bold <?php echo ($sort == 'hot') ? 'btn-danger active' : 'btn-outline-light border'; ?>">
               Xem nhiều
            </a>
        </div>
    </div>

    <h4 class="section-title mb-4 fw-bold border-start border-danger border-4 ps-3">KẾT QUẢ (<?php echo $total_records; ?>)</h4>
    <div class="row g-4 mb-4">
        <?php if ($result_truyen && mysqli_num_rows($result_truyen) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result_truyen)): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="chi-tiet-truyen.php?id=<?php echo $row['id']; ?>" class="text-decoration-none text-dark">
                        <div class="comic-card h-100 bg-white rounded-3 overflow-hidden">
                            <div class="position-relative" style="height: 250px; background: #eee; overflow: hidden;">
    <?php 
        // Lấy dữ liệu từ cột hinhanh (đúng theo ảnh bạn gửi)
        $pic = $row['hinhanh']; 
        
        if (!empty($pic)) {
            // Kiểm tra nếu là link mạng (http/https)
            if (filter_var($pic, FILTER_VALIDATE_URL)) {
                $src_hinh = $pic;
            } else {
                // Nếu là file, nối với đường dẫn thư mục public (Trang ngoài không cần ../../)
                $src_hinh = "public/uploads/" . $pic;
            }
        } else {
            // Nếu cột hinhanh trống
            $src_hinh = "public/uploads/no-image.jpg";
        }
    ?>
    <img src="<?php echo $src_hinh; ?>" 
         class="w-100 h-100 object-fit-cover" 
         alt="Bìa truyện"
         onerror="this.src='https://placehold.co/250x350?text=Khong+Thay+Anh';">
</div>
                            <div class="p-3">
                                <div class="fw-bold text-truncate mb-2"><?php echo htmlspecialchars($row['tentruyen']); ?></div>
                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted"><i class="fas fa-list me-1"></i><?php echo $row['so_chuong']; ?> chap</span>
                                    <span class="text-danger fw-bold"><i class="fas fa-eye me-1"></i><?php echo number_format($row['luot_xem']); ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5 text-muted bg-white rounded-3 shadow-sm">
                <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                <p>Không có truyện nào phù hợp với yêu cầu của bạn.</p>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($total_pages > 1): ?>
    <nav class="my-5">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link shadow-sm mx-1 rounded-3 border-0" href="?the-loai=<?php echo $id_dm; ?>&sort=<?php echo $sort; ?>&page=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</main>

<footer class="main-footer">
    <div class="container text-center">
        <h4 class="fw-bold mb-3">MÊ TRUYỆN</h4>
        <p class="mb-0 small text-secondary">&copy; 2026 Toàn bộ bản quyền thuộc về Mê Truyện Team.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>