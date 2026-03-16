<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$id_chapter = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT c.*, t.tentruyen, t.id AS truyen_id 
        FROM chapter c 
        JOIN truyen t ON c.truyen_id = t.id 
        WHERE c.id = $id_chapter";
$res = mysqli_query($conn, $sql);
$chapter = mysqli_fetch_assoc($res);

if (!$chapter) { die("Chương không tồn tại!"); }

$truyen_id = $chapter['truyen_id'];
$so_chuong_hien_tai = $chapter['so_chuong'];

// Nút trước/sau
$prev_chap = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM chapter WHERE truyen_id = $truyen_id AND CAST(so_chuong AS UNSIGNED) < CAST($so_chuong_hien_tai AS UNSIGNED) ORDER BY CAST(so_chuong AS UNSIGNED) DESC LIMIT 1"));
$next_chap = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM chapter WHERE truyen_id = $truyen_id AND CAST(so_chuong AS UNSIGNED) > CAST($so_chuong_hien_tai AS UNSIGNED) ORDER BY CAST(so_chuong AS UNSIGNED) ASC LIMIT 1"));

$all_chapters_res = mysqli_query($conn, "SELECT id, so_chuong, tieude FROM chapter WHERE truyen_id = $truyen_id ORDER BY CAST(so_chuong AS UNSIGNED) ASC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo $chapter['tentruyen']; ?> - <?php echo $chapter['tieude']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #1a1a1a; color: #ccc; }
        .main-header {
            background: rgba(34, 34, 34, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #333;
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1050;
        }
        .logo-text { font-size: 1.5rem; color: #fff !important; letter-spacing: -1px; }
        .nav-link-item { color: #bbb !important; font-size: 0.95rem; transition: 0.3s; padding: 8px 15px; border-radius: 8px; }
        .nav-link-item:hover { color: #ff4d4d !important; background: rgba(255, 77, 77, 0.1); }
        .search-container { background: #2a2a2a; border-radius: 20px; padding: 4px 15px; border: 1px solid #444; display: flex; align-items: center; max-width: 280px; margin: 0 auto; }
        .search-container input { background: transparent; border: none; color: #fff; padding: 4px 8px; width: 100%; outline: none; font-size: 0.85rem; }
        .user-link { color: #ddd !important; }
        .nav-avatar { width: 35px; height: 35px; background: linear-gradient(45deg, #ff4d4d, #b30000); color: #fff; border: 2px solid #444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .btn-login { color: #ddd; border-color: #444; }
        
        .btn-tu-sach {
            color: #ff4d4d !important;
            font-weight: bold;
            text-decoration: none;
            margin-right: 15px;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
        }
        .btn-tu-sach:hover { opacity: 0.8; }
        /* --- CSS CHO CHẾ ĐỘ SÁNG (LIGHT MODE) --- */
        body.light-mode { background-color: #f4f6f9; color: #333; }
        body.light-mode .main-header { background: rgba(255, 255, 255, 0.95); border-bottom: 1px solid #ddd; }
        body.light-mode .logo-text { color: #333 !important; }
        body.light-mode .nav-link-item { color: #555 !important; }
        body.light-mode .search-container { background: #f1f1f1; border: 1px solid #ddd; }
        body.light-mode .search-container input { color: #333; }
        
        /* Ghi đè các class màu tối của Bootstrap */
        body.light-mode .control-bar, 
        body.light-mode .reading-container { background-color: #ffffff !important; border-color: #ddd !important; }
        body.light-mode .text-white { color: #222 !important; }
        body.light-mode .text-muted { color: #666 !important; }
        body.light-mode .content-area { color: #222 !important; }
        body.light-mode .audio-player-box { background: #fafafa; border-color: #eee !important; }
        body.light-mode .form-select { background-color: #fff !important; color: #333 !important; border-color: #ccc !important; }
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

<div class="control-bar shadow-sm py-2 bg-dark border-bottom border-secondary">
    <div class="container d-flex justify-content-center align-items-center gap-2">
        <a href="chi-tiet-truyen.php?id=<?php echo $truyen_id; ?>" class="btn btn-outline-light btn-sm"><i class="fas fa-home"></i></a>
        
        <button id="theme-toggle" class="btn btn-warning btn-sm text-dark" title="Đổi màu nền">
            <i class="fas fa-sun"></i>
        </button>

        <?php if ($prev_chap): ?>
            <a href="doc-truyen.php?id=<?php echo $prev_chap['id']; ?>" class="btn btn-danger btn-sm"><i class="fas fa-chevron-left"></i></a>
        <?php else: ?>
            <button class="btn btn-secondary btn-sm" disabled><i class="fas fa-chevron-left"></i></button>
        <?php endif; ?>

        <select class="form-select form-select-sm w-auto bg-dark text-light border-secondary" onchange="window.location.href='doc-truyen.php?id=' + this.value">
            <?php mysqli_data_seek($all_chapters_res, 0); ?>
            <?php while($c = mysqli_fetch_assoc($all_chapters_res)): ?>
                <option value="<?php echo $c['id']; ?>" <?php echo ($c['id'] == $id_chapter) ? 'selected' : ''; ?>>
                    <?php echo !empty($c['tieude']) ? $c['tieude'] : "Chương " . $c['so_chuong']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <?php if ($next_chap): ?>
            <a href="doc-truyen.php?id=<?php echo $next_chap['id']; ?>" class="btn btn-danger btn-sm"><i class="fas fa-chevron-right"></i></a>
        <?php else: ?>
            <button class="btn btn-secondary btn-sm" disabled><i class="fas fa-chevron-right"></i></button>
        <?php endif; ?>
    </div>
</div>

<main class="container my-4">
    <div class="reading-container shadow p-4 rounded bg-dark">
        <div class="text-center mb-4">
            <h2 class="text-white"><?php echo htmlspecialchars($chapter['tentruyen']); ?></h2>
            <p class="text-muted mb-1">Chương <?php echo $chapter['so_chuong']; ?></p>
            <h4 class="text-danger fw-bold"><?php echo htmlspecialchars($chapter['tieude']); ?></h4>
            <hr class="border-secondary">
        </div>

        <div class="audio-player-box text-center mb-4 p-3 border border-secondary rounded">
            <p class="small text-secondary mb-2"><i class="fas fa-robot me-1"></i> Trình đọc AI thông minh</p>
            <div class="d-flex justify-content-center gap-2">
                <button id="btn-play-audio" class="btn btn-danger" onclick="handleAudioClick()">
                    <i class="fas fa-play me-1"></i> Nghe truyện
                </button>
                <button class="btn btn-outline-light" onclick="stopAudio()">
                    <i class="fas fa-stop"></i>
                </button>
            </div>
        </div>

        <div class="content-area" style="font-size: 1.2rem; line-height: 1.8; color: #ececec;">
            <?php if (!empty($chapter['noidung'])): ?>
                <div class="chapter-content" id="chapter-text">
                    <?php echo nl2br(htmlspecialchars($chapter['noidung'])); ?>
                </div>
            <?php else: ?>
                <div class="text-center">
                    <?php 
                    $images = explode(',', $chapter['anh_chapter']); 
                    foreach ($images as $img): 
                        $img_trim = trim($img);
                        if ($img_trim):
                    ?>
                        <img src="<?php echo (filter_var($img_trim, FILTER_VALIDATE_URL)) ? $img_trim : 'public/uploads/chapters/'.$img_trim; ?>" class="img-fluid mb-2" alt="Trang truyện">
                    <?php endif; endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="d-flex justify-content-between mt-5 pb-4">
            <?php if ($prev_chap): ?>
                <a href="doc-truyen.php?id=<?php echo $prev_chap['id']; ?>" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Chương trước</a>
            <?php else: ?>
                <span></span>
            <?php endif; ?>
            <?php if ($next_chap): ?>
                <a href="doc-truyen.php?id=<?php echo $next_chap['id']; ?>" class="btn btn-danger px-4">Chương sau <i class="fas fa-arrow-right ms-2"></i></a>
            <?php else: ?>
                <button class="btn btn-dark" disabled>Hết chương</button>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;</script>
<script>
    function handleAudioClick() {
        if (!isLoggedIn) {
            if (confirm("Tính năng nghe đọc AI yêu cầu đăng nhập. Đi tới trang đăng nhập?")) {
                window.location.href = "User/login.php";
            }
        } else {
            playAudio();
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeIcon = themeToggleBtn.querySelector('i');
        const body = document.body;

        // 1. Kiểm tra xem người dùng đã chọn chế độ Sáng trước đó chưa (Lưu trong LocalStorage)
        const currentTheme = localStorage.getItem('reading_theme');
        if (currentTheme === 'light') {
            body.classList.add('light-mode');
            themeIcon.classList.replace('fa-sun', 'fa-moon'); // Đổi icon thành Mặt trăng
            themeToggleBtn.classList.replace('btn-warning', 'btn-dark');
            themeToggleBtn.classList.replace('text-dark', 'text-light');
        }

        // 2. Xử lý khi nhấn nút
        themeToggleBtn.addEventListener('click', () => {
            body.classList.toggle('light-mode');
            
            if (body.classList.contains('light-mode')) {
                // Chuyển sang sáng
                localStorage.setItem('reading_theme', 'light');
                themeIcon.classList.replace('fa-sun', 'fa-moon');
                themeToggleBtn.classList.replace('btn-warning', 'btn-dark');
                themeToggleBtn.classList.replace('text-dark', 'text-light');
            } else {
                // Chuyển về tối
                localStorage.setItem('reading_theme', 'dark');
                themeIcon.classList.replace('fa-moon', 'fa-sun');
                themeToggleBtn.classList.replace('btn-dark', 'btn-warning');
                themeToggleBtn.classList.replace('text-light', 'text-dark');
            }
        });
    });
</script>
<script src="public/js/audio-ai.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>