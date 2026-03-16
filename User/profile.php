<?php
// File: user/profile.php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php'; // Đã có hàm upload_image và get_avatar_letter
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$msg = "";
// Định nghĩa thư mục lưu avatar (tính từ file profile.php ra)
// Đảm bảo thư mục public/uploads/avatars/ tồn tại ở gốc dự án
$avatar_dir = '../public/uploads/avatars/'; 

// Lấy dữ liệu hiện tại của User
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id' LIMIT 1"));

// 2. XỬ LÝ KHI NGƯỜI DÙNG NHẤN "LƯU THAY ĐỔI"
if (isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];
    $current_avatar = $user['avatar']; // Tên file ảnh cũ

    $sql_parts = [];
    $sql_parts[] = "name = '$name'"; // Luôn cập nhật tên

    // A. Xử lý Mật khẩu mới
    if (!empty($new_pass)) {
        if ($new_pass === $confirm_pass) {
            $pass_hash = md5($new_pass);
            $sql_parts[] = "password = '$pass_hash'";
        } else {
            $msg .= "<div class='alert alert-danger'>Mật khẩu xác nhận không khớp!</div>";
        }
    }

    // B. Xử lý Upload Ảnh đại diện mới (Chỉ xử lý nếu không có lỗi mật khẩu trước đó)
    if (empty($msg) && !empty($_FILES['avatar']['name'])) {
        $upload_result = upload_image($_FILES['avatar'], $avatar_dir);
        
        if ($upload_result['success']) {
            $new_avatar_name = $upload_result['filename'];
            $sql_parts[] = "avatar = '$new_avatar_name'";
            
            // Xóa ảnh cũ nếu có (tránh rác server)
            if (!empty($current_avatar) && file_exists($avatar_dir . $current_avatar)) {
                unlink($avatar_dir . $current_avatar);
            }
        } else {
            $msg .= "<div class='alert alert-danger'>" . $upload_result['message'] . "</div>";
        }
    }

    // C. Thực thi câu lệnh SQL nếu không có lỗi
    if (empty($msg)) {
        $sql_final = "UPDATE users SET " . implode(', ', $sql_parts) . " WHERE id = '$user_id'";
        if (mysqli_query($conn, $sql_final)) {
            $msg = "<div class='alert alert-success'>Cập nhật hồ sơ thành công!</div>";
            $_SESSION['user_name'] = $name; // Cập nhật tên hiển thị trên session
            // Tải lại dữ liệu user mới nhất
            $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id' LIMIT 1"));
        } else {
            $msg = "<div class='alert alert-danger'>Lỗi Database: " . mysqli_error($conn) . "</div>";
        }
    }
}

// 3. XỬ LÝ XÓA TÀI KHOẢN (Giữ nguyên)
if (isset($_POST['delete_account'])) {
    $confirm_password = md5($_POST['password_to_delete']);
    $check_pass = mysqli_query($conn, "SELECT id, avatar FROM users WHERE id = '$user_id' AND password = '$confirm_password'");
    
    if (mysqli_num_rows($check_pass) > 0) {
        $u_info = mysqli_fetch_assoc($check_pass);
        // Xóa file ảnh đại diện trên server trước khi xóa record
        if (!empty($u_info['avatar']) && file_exists($avatar_dir . $u_info['avatar'])) {
            unlink($avatar_dir . $u_info['avatar']);
        }
        
        mysqli_query($conn, "DELETE FROM users WHERE id = '$user_id'");
        session_destroy();
        header('Location: ../index.php?msg=account_deleted');
        exit();
    } else {
        $msg = "<div class='alert alert-danger'>Mật khẩu xác nhận không chính xác!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ sơ của <?php echo $user['name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', Tahoma, sans-serif; }
        .card-profile { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
        .header-bg { background: #343a40; height: 140px; }
        .avatar-container { margin-top: -70px; text-align: center; position: relative; display: inline-block; }
        
        /* CSS Hiển thị Ảnh đại diện thật hoặc Chữ cái đầu */
        .avatar-real, .avatar-letter { 
            width: 140px; height: 140px; border-radius: 50%; 
            border: 6px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.15);
            object-fit: cover; /* Đảm bảo ảnh không bị méo */
        }
        .avatar-letter {
            background: #e9ecef; color: #343a40;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 4rem; font-weight: bold; text-transform: uppercase;
        }

        /* Nút bấm nhỏ để chọn ảnh đè lên avatar */
        .change-avatar-btn {
            position: absolute; bottom: 5px; right: 5px;
            background: #fff; color: #343a40; width: 35px; height: 35px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2); border: none;
        }
        .change-avatar-btn:hover { background: #e9ecef; }
        #avatar-input { display: none; /* Ẩn input file thật */ }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            
            <form method="POST" enctype="multipart/form-data">
                
                <div class="card card-profile mb-4">
                    <div class="header-bg"></div>
                    
                    <div class="text-center">
                        <div class="avatar-container">
                            <?php 
                            // Kiểm tra xem user có ảnh đại diện thật không
                            if (!empty($user['avatar']) && file_exists($avatar_dir . $user['avatar'])): 
                            ?>
                                <img src="<?php echo $avatar_dir . $user['avatar']; ?>" alt="Avatar" class="avatar-real" id="avatar-preview">
                            <?php else: ?>
                                <div class="avatar-letter" id="avatar-preview-letter">
                                    <?php echo get_avatar_letter($user['name']); ?>
                                </div>
                            <?php endif; ?>

                            <label for="avatar-input" class="change-avatar-btn" title="Đổi ảnh đại diện">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" name="avatar" id="avatar-input" accept="image/*">
                        </div>
                    </div>
                    
                    <div class="card-body p-4 p-lg-5 pt-2 text-center">
                        <h3 class="fw-bold mb-1"><?php echo $user['name']; ?></h3>
                        <p class="text-muted small mb-4">Thành viên từ: <?php echo date('d/m/Y', strtotime($user['created_at'])); ?></p>
                        
                        <?php echo $msg; ?>

                        <div class="text-start">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Địa chỉ Email</label>
                                <input type="text" class="form-control bg-light" value="<?php echo $user['email']; ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Họ và tên</label>
                                <input type="text" name="name" class="form-control" value="<?php echo $user['name']; ?>" required>
                            </div>

                            <hr class="my-4">
                            <h6 class="fw-bold mb-3"><i class="fas fa-key text-warning me-2"></i>Đổi mật khẩu (Bỏ trống nếu giữ nguyên)</h6>
                            <div class="mb-3">
                                <input type="password" name="new_password" class="form-control" placeholder="Mật khẩu mới">
                            </div>
                            <div class="mb-4">
                                <input type="password" name="confirm_password" class="form-control" placeholder="Xác nhận mật khẩu mới">
                            </div>
                        </div>
                        <div>
                            <button type="submit" name="update_profile" class="btn btn-dark flex-grow-1 fw-bold py-2 shadow-sm">
                            <i class="fas fa-save me-2"></i>LƯU THAY ĐỔI
                        </button>
    
                        <a href="logout.php" class="btn btn-outline-danger fw-bold py-2 px-4 shadow-sm" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                        </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="d-flex justify-content-between align-items-center px-2">
                <a href="../index.php" class="text-decoration-none text-muted small">
                    <i class="fas fa-arrow-left me-1"></i>Về trang chủ
                </a>
                <button class="btn btn-outline-danger btn-sm border-0" data-bs-toggle="modal" data-bs-target="#delModal">
                    <i class="fas fa-user-times me-1"></i>Xóa tài khoản
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="delModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-danger">Xóa tài khoản vĩnh viễn?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-start">
                    <p>Mọi dữ liệu của bạn sẽ bị xóa và không thể khôi phục. Vui lòng nhập mật khẩu để xác nhận.</p>
                    <input type="password" name="password_to_delete" class="form-control" placeholder="Nhập mật khẩu hiện tại" required>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" name="delete_account" class="btn btn-danger px-4 fw-bold">Xóa ngay</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById('avatar-input').onchange = function (evt) {
        var tgt = evt.target || window.event.srcElement,
            files = tgt.files;

        // FileReader support
        if (FileReader && files && files.length) {
            var fr = new FileReader();
            fr.onload = function () {
                var previewImg = document.getElementById('avatar-preview');
                var previewLetter = document.getElementById('avatar-preview-letter');

                if (previewImg) {
                    // Nếu đang có ảnh thật, thay đổi src
                    previewImg.src = fr.result;
                } else if (previewLetter) {
                    // Nếu đang hiện chữ cái, ẩn chữ cái đi và tạo thẻ img mới
                    previewLetter.style.display = 'none';
                    var newImg = document.createElement('img');
                    newImg.src = fr.result;
                    newImg.className = 'avatar-real';
                    newImg.id = 'avatar-preview';
                    previewLetter.parentNode.insertBefore(newImg, previewLetter);
                }
            }
            fr.readAsDataURL(files[0]);
        }
    }
</script>
</body>
</html>