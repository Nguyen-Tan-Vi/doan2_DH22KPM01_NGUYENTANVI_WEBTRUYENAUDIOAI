<?php
require_once '../../check_admin.php'; 
require_once '../../../includes/db.php'; 

// 1. Lấy ID chương từ URL
$id = $_GET['id'];

// 2. Lấy dữ liệu cũ của chương này
$sql_chapter = "SELECT * FROM chapter WHERE id = '$id' LIMIT 1";
$query_chapter = mysqli_query($conn, $sql_chapter);
$row_chapter = mysqli_fetch_assoc($query_chapter);

// 3. Lấy danh sách truyện để đổ vào thẻ Select
$sql_truyen = "SELECT id, tentruyen FROM truyen ORDER BY id DESC";
$query_truyen = mysqli_query($conn, $sql_truyen);

// 4. Xử lý khi nhấn nút Cập nhật
if(isset($_POST['suachapter'])){
    $truyen_id = $_POST['truyen_id'];
    $tieude = mysqli_real_escape_string($conn, $_POST['tieude']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug_chapter']);
    $noidung = mysqli_real_escape_string($conn, $_POST['noidung']);
    $kichhoat = $_POST['kichhoat'];

    $sql_update = "UPDATE chapter SET 
                    truyen_id = '$truyen_id', 
                    tieude = '$tieude', 
                    slug_chapter = '$slug', 
                    noidung = '$noidung', 
                    kichhoat = '$kichhoat' 
                   WHERE id = '$id'";
    
    if(mysqli_query($conn, $sql_update)){
        echo "<script>alert('Cập nhật chương thành công!'); window.location='index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Chương - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow border-0">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Chỉnh Sửa Chương Truyện</h4>
                        <a href="index.php" class="btn btn-outline-secondary btn-sm">Quay lại</a>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Thuộc bộ truyện</label>
                                    <select name="truyen_id" class="form-select" required>
                                        <?php while($t = mysqli_fetch_assoc($query_truyen)){ ?>
                                            <option value="<?php echo $t['id']; ?>" 
                                                <?php if($t['id'] == $row_chapter['truyen_id']) echo 'selected'; ?>>
                                                <?php echo $t['tentruyen']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Trạng thái</label>
                                    <select name="kichhoat" class="form-select">
                                        <option value="1" <?php if($row_chapter['kichhoat']==1) echo 'selected'; ?>>Hiển thị</option>
                                        <option value="0" <?php if($row_chapter['kichhoat']==0) echo 'selected'; ?>>Ẩn chương</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tiêu đề chương</label>
                                <input type="text" name="tieude" id="title" class="form-control" 
                                       value="<?php echo $row_chapter['tieude']; ?>" required onkeyup="ChangeToSlug()">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Slug chương (Đường dẫn)</label>
                                <input type="text" name="slug_chapter" id="slug" class="form-control" 
                                       value="<?php echo $row_chapter['slug_chapter']; ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-primary"><i class="fas fa-keyboard"></i> Nội dung chương (Dữ liệu cho Audio AI)</label>
                                <textarea name="noidung" class="form-control" rows="15" required><?php echo $row_chapter['noidung']; ?></textarea>
                                <div class="form-text text-muted">Mẹo: Nên dán văn bản thô, không chứa mã HTML lạ để AI đọc mượt nhất.</div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" name="suachapter" class="btn btn-warning">Lưu thay đổi</button>
                            </div>
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
            slug = slug.replace(/([^0-9a-z-\s])/g, '');
            slug = slug.replace(/\s+/g, '-');
            slug = slug.replace(/^-+/g, '');
            slug = slug.replace(/-+$/g, '');
            document.getElementById('slug').value = slug;
        }
    </script>
</body>
</html>