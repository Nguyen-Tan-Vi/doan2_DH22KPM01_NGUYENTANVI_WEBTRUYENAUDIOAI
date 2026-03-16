<?php
require_once '../../check_admin.php'; 
require_once '../../../includes/db.php'; 

// Lấy danh sách truyện để đổ vào thẻ Select
$sql_truyen = "SELECT id, tentruyen FROM truyen ORDER BY id DESC";
$query_truyen = mysqli_query($conn, $sql_truyen);

if(isset($_POST['themchapter'])){
    $truyen_id = $_POST['truyen_id'];
    $tieude = mysqli_real_escape_string($conn, $_POST['tieude']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug_chapter']);
    $noidung = mysqli_real_escape_string($conn, $_POST['noidung']); // Chứa text cho Audio AI
    $kichhoat = $_POST['kichhoat'];

    $sql = "INSERT INTO chapter(truyen_id, tieude, slug_chapter, noidung, kichhoat) 
            VALUES('$truyen_id', '$tieude', '$slug', '$noidung', '$kichhoat')";
    
    if(mysqli_query($conn, $sql)){
        header('Location: index.php');
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Chương - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow border-0 p-4">
            <h4>Thêm Chương Truyện Mới</h4>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Chọn Truyện</label>
                    <select name="truyen_id" class="form-select" required>
                        <?php while($t = mysqli_fetch_assoc($query_truyen)){ ?>
                            <option value="<?php echo $t['id']; ?>"><?php echo $t['tentruyen']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tiêu đề chương (VD: Chương 1: Khởi đầu)</label>
                    <input type="text" name="tieude" id="title" class="form-control" required onkeyup="ChangeToSlug()">
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug chương</label>
                    <input type="text" name="slug_chapter" id="slug" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nội dung truyện (Dùng để đọc Audio AI)</label>
                    <textarea name="noidung" class="form-control" rows="10" placeholder="Dán nội dung chữ vào đây..."></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="kichhoat" class="form-select">
                        <option value="1">Hiển thị</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>
                <button type="submit" name="themchapter" class="btn btn-success w-100">Lưu Chương</button>
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