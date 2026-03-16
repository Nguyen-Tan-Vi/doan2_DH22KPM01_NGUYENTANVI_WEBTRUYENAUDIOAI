<?php
require_once '../../check_admin.php'; 
require_once '../../../includes/db.php'; 

// Lấy danh sách danh mục để chọn
$query_dm = mysqli_query($conn, "SELECT * FROM danhmuc ORDER BY id DESC");

if(isset($_POST['themtruyen'])){
    $tentruyen = mysqli_real_escape_string($conn, $_POST['tentruyen']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug_truyen']);
    $tomtat = mysqli_real_escape_string($conn, $_POST['tomtat']);
    $tacgia = mysqli_real_escape_string($conn, $_POST['tacgia']);
    $danhmuc_id = $_POST['danhmuc_id'];
    $kichhoat = $_POST['kichhoat'];

    // Xử lý Upload Ảnh bìa
    $hinhanh = $_FILES['hinhanh']['name'];
    $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
    $hinhanh_time = time().'_'.$hinhanh; // Tránh trùng tên file

    $sql = "INSERT INTO truyen(tentruyen, slug_truyen, tomtat, hinhanh, tacgia, danhmuc_id, kichhoat) 
            VALUES('$tentruyen', '$slug', '$tomtat', '$hinhanh_time', '$tacgia', '$danhmuc_id', '$kichhoat')";
    
    if(mysqli_query($conn, $sql)){
        move_uploaded_file($hinhanh_tmp, '../../../public/uploads/'.$hinhanh_time);
        header('Location: index.php');
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Truyện - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow border-0 p-4">
            <h4>Thêm Truyện Mới</h4>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Tên truyện</label>
                    <input type="text" name="tentruyen" id="title" class="form-control" required onkeyup="ChangeToSlug()">
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug_truyen" id="slug" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ảnh bìa</label>
                    <input type="file" name="hinhanh" class="form-control" accept="image/*" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tác giả</label>
                        <input type="text" name="tacgia" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Danh mục</label>
                        <select name="danhmuc_id" class="form-select">
                            <?php while($dm = mysqli_fetch_assoc($query_dm)){ ?>
                                <option value="<?php echo $dm['id']; ?>"><?php echo $dm['tendanhmuc']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tóm tắt</label>
                    <textarea name="tomtat" class="form-control" rows="4"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="kichhoat" class="form-select">
                        <option value="1">Hiển thị</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>
                <button type="submit" name="themtruyen" class="btn btn-primary w-100">Lưu Truyện</button>
            </form>
        </div>
    </div>
    <script>
        function ChangeToSlug() {
            var title = document.getElementById("title").value;
            var slug = title.toLowerCase();
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