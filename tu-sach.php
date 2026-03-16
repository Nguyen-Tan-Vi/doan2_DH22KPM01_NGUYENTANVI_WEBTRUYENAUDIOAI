<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['user_id'])) {
    header('Location: User/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Truy vấn lấy danh sách truyện mà người dùng này đã yêu thích
$sql = "SELECT t.* FROM yeuthich y 
        JOIN truyen t ON y.truyen_id = t.id 
        WHERE y.user_id = $user_id 
        ORDER BY y.created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tủ truyện của tôi - Mê Truyện</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .comic-card { transition: transform 0.3s; border: none; }
        .comic-card:hover { transform: translateY(-5px); }
        .comic-img { height: 250px; object-fit: cover; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container my-5">
        <h2 class="fw-bold mb-4"><i class="fas fa-heart text-danger me-2"></i>TỦ TRUYỆN CỦA TÔI</h2>
        <hr>
        <div class="row">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-6 col-md-3 col-lg-2 mb-4">
                        <div class="card comic-card bg-transparent">
                            <a href="chi-tiet-truyen.php?id=<?php echo $row['id']; ?>">
                                <img src="public/uploads/<?php echo $row['hinhanh']; ?>" class="card-img-top comic-img shadow-sm" alt="...">
                            </a>
                            <div class="card-body px-0 py-2">
                                <h6 class="fw-bold text-dark text-truncate mb-1">
                                    <a href="chi-tiet-truyen.php?id=<?php echo $row['id']; ?>" class="text-decoration-none text-dark">
                                        <?php echo htmlspecialchars($row['tentruyen']); ?>
                                    </a>
                                </h6>
                                <small class="text-muted">Đã lưu vào thư viện</small>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" width="100" class="mb-3 opacity-50">
                    <p class="text-muted">Tủ truyện đang trống. Hãy nhấn "Yêu thích" để lưu truyện nhé!</p>
                    <a href="index.php" class="btn btn-danger rounded-pill">Khám phá truyện ngay</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>