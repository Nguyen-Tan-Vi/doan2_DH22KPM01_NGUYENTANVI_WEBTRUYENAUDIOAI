<?php
require_once __DIR__ . '/../../../includes/functions.php';
require_once __DIR__ . '/../../check_admin.php';
require_once __DIR__ . '/../../../includes/db.php';

$id = $_GET['id'];
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'"));

if(isset($_POST['suauser'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = $_POST['role'];
    $password = $_POST['password'];

    if(!empty($password)){
        $pass_new = md5($password);
        $sql = "UPDATE users SET name='$name', email='$email', password='$pass_new', role='$role' WHERE id='$id'";
    } else {
        $sql = "UPDATE users SET name='$name', email='$email', role='$role' WHERE id='$id'";
    }
    
    if(mysqli_query($conn, $sql)) {
        header('Location: index.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow-sm p-4 border-0">
            <h4 class="mb-4 text-center">CHỈNH SỬA USER</h4>
            <form method="POST">
                <div class="mb-3"><label class="form-label">Họ tên</label><input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required></div>
                <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required></div>
                <div class="mb-3"><label class="form-label">Mật khẩu mới</label><input type="password" name="password" class="form-control" placeholder="Bỏ trống nếu giữ nguyên"></div>
                <div class="mb-3">
                    <label class="form-label">Vai trò</label>
                    <select name="role" class="form-select">
                        <option value="0" <?php if($row['role']==0) echo 'selected'; ?>>Người dùng</option>
                        <option value="1" <?php if($row['role']==1) echo 'selected'; ?>>Admin</option>
                    </select>
                </div>
                <button type="submit" name="suauser" class="btn btn-warning w-100">Cập nhật</button>
                <a href="index.php" class="btn btn-link w-100 mt-2 text-secondary">Hủy bỏ</a>
            </form>
        </div>
    </div>
</body>
</html>