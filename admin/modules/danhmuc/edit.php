<?php
require_once '../../check_admin.php'; 
require_once '../../../includes/db.php'; 

// 1. Lấy ID từ URL
$id = $_GET['id'];
$sql_get = "SELECT * FROM danhmuc WHERE id = '$id' LIMIT 1";
$query_get = mysqli_query($conn, $sql_get);
$row = mysqli_fetch_assoc($query_get);

// 2. Xử lý khi nhấn nút Cập nhật
if(isset($_POST['sua'])){
    $tendanhmuc = mysqli_real_escape_string($conn, $_POST['tendanhmuc']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug_danhmuc']);
    $mota = mysqli_real_escape_string($conn, $_POST['mota']);
    $kichhoat = $_POST['kichhoat'];

    $sql_update = "UPDATE danhmuc SET 
                    tendanhmuc = '$tendanhmuc', 
                    slug_danhmuc = '$slug', 
                    mota = '$mota', 
                    kichhoat = '$kichhoat' 
                   WHERE id = '$id'";
    
    if(mysqli_query($conn, $sql_update)){
        header('Location: index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Danh mục - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0">
                    <div class="card-header bg-white"><h4>Chỉnh Sửa Danh Mục</h4></div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Tên danh mục</label>
                                <input type="text" name="tendanhmuc" id="title" class="form-control" 
                                       value="<?php echo $row['tendanhmuc']; ?>" required onkeyup="ChangeToSlug()">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slug (Đường dẫn)</label>
                                <input type="text" name="slug_danhmuc" id="slug" class="form-control" 
                                       value="<?php echo $row['slug_danhmuc']; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mô tả</label>
                                <textarea name="mota" class="form-control" rows="3"><?php echo $row['mota']; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Trạng thái</label>
                                <select name="kichhoat" class="form-select">
                                    <option value="1" <?php if($row['kichhoat']==1) echo 'selected'; ?>>Hiển thị</option>
                                    <option value="0" <?php if($row['kichhoat']==0) echo 'selected'; ?>>Tạm ẩn</option>
                                </select>
                            </div>
                            <button type="submit" name="sua" class="btn btn-warning w-100">Cập nhật thay đổi</button>
                            <a href="index.php" class="btn btn-link w-100 mt-2">Hủy bỏ</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function ChangeToSlug() {
            var title = document.getElementById("title").value;
            var slug = title.toLowerCase();
            // ... (Phần logic thay thế ký tự tiếng Việt giống trang create)
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            slug = slug.replace(/\s+/g, '-');
            document.getElementById('slug').value = slug;
        }
    </script>
</body>
</html>