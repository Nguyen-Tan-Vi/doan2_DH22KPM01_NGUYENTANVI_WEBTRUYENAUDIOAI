<?php
require_once __DIR__ . '/../../../includes/functions.php';
require_once __DIR__ . '/../../check_admin.php';
require_once __DIR__ . '/../../../includes/db.php';

if(isset($_POST['add_user'])){
    $name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // 1. Kiểm tra Email đã tồn tại chưa
    $check_email = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
    
    // 2. Định dạng mật khẩu (10 ký tự, 1 chữ HOA, 1 ký tự đặc biệt)
    $password_pattern = "/^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?\":{}|<>]).{10,}$/";

    if (mysqli_num_rows($check_email) > 0) {
        $error = "Email này đã được sử dụng!";
    } elseif (!preg_match($password_pattern, $password)) {
        $error = "Mật khẩu chưa đủ mạnh! (Phải từ 10 ký tự, có 1 chữ hoa và 1 ký tự đặc biệt)";
    } else {
        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 3. Thực hiện Insert vào CSDL
        $sql = "INSERT INTO users (name, email, password, role, created_at) 
                VALUES ('$name', '$email', '$hashed_password', 0, NOW())";
        
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
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
    <title>Thêm Người Dùng - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 450px;">
        <div class="card shadow-sm border-0 p-4 rounded-4">
            <div class="text-center mb-4">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px;">
                    <i class="fas fa-user-plus fa-lg"></i>
                </div>
                <h4 class="fw-bold text-primary mb-0">THÊM NGƯỜI DÙNG</h4>
            </div>
            
            <?php if(isset($error)) echo "<div class='alert alert-danger small'>$error</div>"; ?>
            
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold small">Tên đăng nhập / Họ tên</label>
                    <input type="text" name="user_name" class="form-control" placeholder="Nguyễn Văn A" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="admin@example.com" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required>
                    <div class="form-text" style="font-size: 0.7rem;">Ít nhất 10 ký tự, có chữ HOA và ký tự đặc biệt.</div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-bold small">Phân quyền</label>
                    <select name="role" class="form-select">
                        <option value="user">Người dùng thường (User)</option>
                        <option value="admin">Quản trị viên (Admin)</option>
                    </select>
                </div>

                <div class="d-grid gap-2">
                    <button href="index.php" type="submit" name="add_user" class="btn btn-primary fw-bold">
                        <i class="fas fa-save me-1"></i> LƯU TÀI KHOẢN
                    </button>
                    <a href="index.php" class="btn btn-light border fw-bold text-muted small">
                         QUAY LẠI
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>