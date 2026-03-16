<?php
require_once __DIR__ . '/../includes/db.php';

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];

    // 1. Kiểm tra Email tồn tại
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    
    // 2. Định nghĩa Regex kiểm tra mật khẩu:
    // ^(?=.*[A-Z])       : Phải có ít nhất 1 chữ hoa
    // (?=.*[!@#$%^&*])    : Phải có ít nhất 1 ký tự đặc biệt
    // .{10,}              : Độ dài tối thiểu 10 ký tự
    $password_pattern = "/^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?\":{}|<>]).{10,}$/";

    if (mysqli_num_rows($check) > 0) {
        $error = "Email này đã được sử dụng!";
    } elseif ($password !== $re_password) {
        $error = "Mật khẩu nhắc lại không khớp!";
    } elseif (!preg_match($password_pattern, $password)) {
        $error = "Mật khẩu chưa đủ mạnh! (Phải từ 10 ký tự, có 1 chữ hoa và 1 ký tự đặc biệt)";
    } else {
        // 3. TÁCH BIẾN: Mã hóa mật khẩu trước khi lưu
        // Sử dụng thuật toán BCRYPT (Chuẩn bảo mật hiện nay)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password, role, created_at) 
                VALUES ('$name', '$email', '$hashed_password', 0, NOW())";
        
        if (mysqli_query($conn, $sql)) {
            header('Location: login.php?msg=success');
            exit();
        } else {
            $error = "Lỗi hệ thống, vui lòng thử lại sau.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản bảo mật</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5" style="max-width: 450px;">
        <div class="card shadow border-0 p-4">
            <h4 class="text-center fw-bold mb-4 text-primary">TẠO TÀI KHOẢN</h4>
            
            <?php if(isset($error)) echo "<div class='alert alert-danger small'><i class='fas fa-exclamation-triangle me-2'></i>$error</div>"; ?>
            
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold small">Họ tên</label>
                    <input type="text" name="name" class="form-control" placeholder="Nguyễn Văn A" value="<?php echo isset($name) ? $name : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="example@gmail.com" value="<?php echo isset($email) ? $email : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required>
                    <div class="form-text" style="font-size: 0.75rem;">
                        Tối thiểu 12 ký tự, bao gồm chữ HOA và ký tự đặc biệt (@, #, $,...)
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small">Nhắc lại mật khẩu</label>
                    <input type="password" name="re_password" class="form-control" required>
                </div>

                <button type="submit" name="register" class="btn btn-primary w-100 fw-bold py-2">
                    ĐĂNG KÝ NGAY
                </button>
                
                <p class="text-center mt-3 small text-muted">
                    Đã có tài khoản? <a href="login.php" class="text-primary text-decoration-none fw-bold">Đăng nhập</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>