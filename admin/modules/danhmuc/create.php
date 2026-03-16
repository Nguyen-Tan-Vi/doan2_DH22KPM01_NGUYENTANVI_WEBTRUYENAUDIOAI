<?php
require_once '../../check_admin.php'; 
require_once '../../../includes/db.php'; 

if(isset($_POST['them'])){
    $tendanhmuc = mysqli_real_escape_string($conn, $_POST['tendanhmuc']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug_danhmuc']);
    $mota = mysqli_real_escape_string($conn, $_POST['mota']);
    $kichhoat = $_POST['kichhoat'];

    $sql_insert = "INSERT INTO danhmuc(tendanhmuc, slug_danhmuc, mota, kichhoat) 
                   VALUES('$tendanhmuc', '$slug', '$mota', '$kichhoat')";
    
    if(mysqli_query($conn, $sql_insert)){
        header('Location: index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Danh mục - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0">
                    <div class="card-header bg-white"><h4>Thêm Danh Mục Mới</h4></div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Tên danh mục</label>
                                <input type="text" name="tendanhmuc" id="title" class="form-control" placeholder="Ví dụ: Tiên Hiệp" required onkeyup="ChangeToSlug()">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slug (Tự động)</label>
                                <input type="text" name="slug_danhmuc" id="slug" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mô tả</label>
                                <textarea name="mota" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Trạng thái</label>
                                <select name="kichhoat" class="form-select">
                                    <option value="1">Hiển thị</option>
                                    <option value="0">Tạm ẩn</option>
                                </select>
                            </div>
                            <button type="submit" name="them" class="btn btn-primary w-100">Lưu danh mục</button>
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
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            slug = slug.replace(/\s+/g, '-'); // Thay khoảng cách bằng dấu -
            document.getElementById('slug').value = slug;
        }
    </script>
</body>
</html>