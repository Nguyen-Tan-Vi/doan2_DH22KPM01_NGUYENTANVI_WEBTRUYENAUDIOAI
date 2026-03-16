<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/db.php';

$error = "";

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Mật khẩu người dùng nhập vào

    // 1. Chỉ tìm User theo Email
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // 2. Kiểm tra mật khẩu bằng password_verify
        // Tham số 1: Mật khẩu chưa mã hóa (người dùng vừa nhập)
        // Tham số 2: Chuỗi đã mã hóa lấy từ Database
        if (password_verify($password, $user['password'])) {
            
            // Đăng nhập thành công -> Lưu Session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            // Chuyển hướng
            if ($user['role'] == 1) {
                header('Location: ../admin/index.php');
            } else {
                header('Location: ../index.php');
            }
            exit();
        } else {
            $error = "Mật khẩu không chính xác!";
        }
    } else {
        $error = "Email không tồn tại trong hệ thống!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 400px;">
        <div class="card p-4 shadow-sm border-0">
            <h3 class="text-center mb-4 fw-bold">ĐĂNG NHẬP</h3>
            
            <?php if(!empty($error)): ?>
                <div class="alert alert-danger small"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100 py-2 fw-bold">Vào hệ thống</button>
            </form>
            <p class="mt-3 text-center small text-muted">
                Chưa có tài khoản? <a href="register.php" class="text-decoration-none">Đăng ký</a>
            </p>
        </div>
    </div>
</body>
</html>