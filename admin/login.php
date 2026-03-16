<?php
require_once '../includes/db.php';

$error = "";
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Đây là biến chúng ta đã định nghĩa

    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // SỬA TẠI ĐÂY: Đổi $password_nhap_vao thành $password
        if (password_verify($password, $user['password'])) {
            // Đăng nhập thành công...
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

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
        $error = "Email không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 bg-white p-4 shadow-sm rounded">
                <h3 class="text-center mb-4">ĐĂNG NHẬP</h3>
                <?php if($error != "") echo "<div class='alert alert-danger'>$error</div>"; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="admin@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Đăng nhập</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>