<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php'; 
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// 1. Lấy ID truyện từ URL
$id_truyen = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 2. Truy vấn thông tin truyện và tên danh mục
$sql_truyen = "SELECT t.*, dm.tendanhmuc 
               FROM truyen t 
               LEFT JOIN danhmuc dm ON t.danhmuc_id = dm.id 
               WHERE t.id = $id_truyen";
$res_truyen = mysqli_query($conn, $sql_truyen);
$truyen = mysqli_fetch_assoc($res_truyen);

if (!$truyen) {
    die("Truyện không tồn tại!");
}

// Kiểm tra xem người dùng đã thích truyện này chưa để hiển thị màu nút
$is_favorite = false;
if (isset($_SESSION['user_id'])) {
    $u_id = $_SESSION['user_id'];
    $check_fav = mysqli_query($conn, "SELECT id FROM yeuthich WHERE user_id = $u_id AND truyen_id = $id_truyen");
    if (mysqli_num_rows($check_fav) > 0) {
        $is_favorite = true;
    }
}

// 3. Tăng lượt xem
mysqli_query($conn, "UPDATE truyen SET luot_xem = luot_xem + 1 WHERE id = $id_truyen");

// 4. Lấy danh sách chapter
$sql_chapter = "SELECT * FROM chapter WHERE truyen_id = $id_truyen ORDER BY so_chuong DESC";
$res_chapter = mysqli_query($conn, $sql_chapter);

// Lấy chapter đầu tiên
$sql_first_chap = "SELECT id FROM chapter WHERE truyen_id = $id_truyen ORDER BY so_chuong ASC LIMIT 1";
$res_first = mysqli_query($conn, $sql_first_chap);
$first_chap = mysqli_fetch_assoc($res_first);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($truyen['tentruyen']); ?> - Mê Truyện</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

<main class="container mt-4">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="row g-0">
            <div class="col-md-3">
                <img src="public/uploads/<?php echo $truyen['hinhanh']; ?>" class="img-fluid w-100 h-100" style="object-fit: cover; min-height: 350px;" alt="Cover">
            </div>
            <div class="col-md-9">
                <div class="card-body p-4">
                    <h1 class="fw-bold mb-2"><?php echo htmlspecialchars($truyen['tentruyen']); ?></h1>
                    <p>
                        <strong>Thể loại:</strong> 
                        <a href="the-loai.php?id=<?php echo $truyen['danhmuc_id']; ?>" class="text-decoration-none">
                            <?php echo $truyen['tendanhmuc']; ?>
                        </a>
                    </p>
                    
                    <div class="d-flex gap-3 mb-4">
                        <span class="text-dark small"><i class="fas fa-eye me-1 text-danger"></i> <?php echo number_format($truyen['luot_xem']); ?> lượt xem</span>
                        <span class="text-dark small"><i class="fas fa-layer-group me-1 text-primary"></i> <?php echo $truyen['so_chuong']; ?> chương</span>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase small text-secondary">Tóm tắt nội dung:</h6>
                        <p class="text-dark" style="line-height: 1.6; font-size: 15px;">
                            <?php echo nl2br(htmlspecialchars($truyen['tomtat'])); ?>
                        </p>
                    </div>

                    <div class="d-flex gap-2">
                        <?php if($first_chap): ?>
                            <a href="doc-truyen.php?id=<?php echo $first_chap['id']; ?>" class="btn btn-danger rounded-pill px-4 fw-bold">Đọc từ đầu</a>
                        <?php endif; ?>
                        
                        <button id="btn-yeuthich" 
                                class="btn <?php echo $is_favorite ? 'btn-danger' : 'btn-outline-dark'; ?> rounded-pill px-4 fw-bold" 
                                data-id="<?php echo $id_truyen; ?>">
                            <i class="<?php echo $is_favorite ? 'fas' : 'far'; ?> fa-heart me-1"></i> 
                            <span id="text-yeuthich"><?php echo $is_favorite ? 'Đã yêu thích' : 'Yêu thích'; ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-4 shadow-sm mb-5">
        <h4 class="fw-bold mb-4 border-start border-danger border-4 ps-3">DANH SÁCH CHAPTER</h4>
        <div class="list-chapter" style="max-height: 500px; overflow-y: auto;">
            <?php if(mysqli_num_rows($res_chapter) > 0): ?>
                <div class="list-group list-group-flush">
                    <?php while($chap = mysqli_fetch_assoc($res_chapter)): ?>
                        <a href="doc-truyen.php?id=<?php echo $chap['id']; ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between py-3">
                            <span class="fw-medium">Chapter <?php echo $chap['so_chuong']; ?>: <?php echo htmlspecialchars($chap['tieude']); ?></span>
                            <span class="text-muted small"><?php echo date('d/m/Y', strtotime($chap['ngay_cap_nhat'])); ?></span>
                        </a>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-light mb-3"></i>
                    <p class="text-muted">Truyện này hiện chưa có chapter nào.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<footer class="main-footer">
    <div class="container text-center py-4">
        <h4 class="fw-bold mb-3">MÊ TRUYỆN</h4>
        <p class="mb-0 small text-secondary">&copy; 2026 Toàn bộ bản quyền thuộc về Mê Truyện Team.</p>
    </div>
</footer>

<script>
$(document).ready(function() {
    $('#btn-yeuthich').click(function() {
        var truyen_id = $(this).data('id');
        var btn = $(this);
        var icon = btn.find('i');
        var text = btn.find('#text-yeuthich');

        $.ajax({
            url: 'yeuthich.php',
            type: 'POST',
            data: { truyen_id: truyen_id },
            dataType: 'json',
            success: function(response) {
                if (response.status == 'added') {
                    btn.removeClass('btn-outline-dark').addClass('btn-danger');
                    icon.removeClass('far').addClass('fas');
                    text.text('Đã yêu thích');
                } else if (response.status == 'removed') {
                    btn.removeClass('btn-danger').addClass('btn-outline-dark');
                    icon.removeClass('fas').addClass('far');
                    text.text('Yêu thích');
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Có lỗi xảy ra, vui lòng thử lại sau!');
            }
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>