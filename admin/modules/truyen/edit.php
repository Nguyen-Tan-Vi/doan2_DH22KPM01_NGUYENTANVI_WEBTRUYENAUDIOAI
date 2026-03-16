<?php
require_once '../../check_admin.php'; 
require_once '../../../includes/db.php'; 

// 1. Lấy ID truyện cần sửa
$id = $_GET['id'];
$sql_get = "SELECT * FROM truyen WHERE id = '$id' LIMIT 1";
$query_get = mysqli_query($conn, $sql_get);
$row = mysqli_fetch_assoc($query_get);

// 2. Lấy danh sách danh mục để chọn lại (nếu muốn)
$query_dm = mysqli_query($conn, "SELECT * FROM danhmuc ORDER BY id DESC");

// 3. Xử lý khi nhấn nút Cập nhật
if(isset($_POST['suatruyen'])){
    $tentruyen = mysqli_real_escape_string($conn, $_POST['tentruyen']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug_truyen']);
    $tomtat = mysqli_real_escape_string($conn, $_POST['tomtat']);
    $tacgia = mysqli_real_escape_string($conn, $_POST['tacgia']);
    $danhmuc_id = $_POST['danhmuc_id'];
    $kichhoat = $_POST['kichhoat'];

    // Xử lý Ảnh bìa
    $hinhanh = $_FILES['hinhanh']['name'];
    $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
    
    if($hinhanh != ''){
        // NẾU CÓ CHỌN ẢNH MỚI:
        $hinhanh_time = time().'_'.$hinhanh;
        // Xóa ảnh cũ trong thư mục uploads để tránh rác server
        if(file_exists('../../../public/uploads/'.$row['hinhanh'])){
            unlink('../../../public/uploads/'.$row['hinhanh']);
        }
        // Upload ảnh mới
        move_uploaded_file($hinhanh_tmp, '../../../public/uploads/'.$hinhanh_time);
        
        $sql_update = "UPDATE truyen SET 
            tentruyen='$tentruyen', slug_truyen='$slug', tomtat='$tomtat', 
            hinhanh='$hinhanh_time', tacgia='$tacgia', danhmuc_id='$danhmuc_id', kichhoat='$kichhoat' 
            WHERE id = '$id'";
    } else {
        // NẾU KHÔNG CHỌN ẢNH MỚI: Giữ nguyên ảnh cũ ($row['hinhanh'])
        $sql_update = "UPDATE truyen SET 
            tentruyen='$tentruyen', slug_truyen='$slug', tomtat='$tomtat', 
            tacgia='$tacgia', danhmuc_id='$danhmuc_id', kichhoat='$kichhoat' 
            WHERE id = '$id'";
    }

    if(mysqli_query($conn, $sql_update)){
        header('Location: index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Truyện - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow border-0 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Chỉnh Sửa Truyện: <?php echo $row['tentruyen']; ?></h4>
                <a href="index.php" class="btn btn-outline-secondary btn-sm">Quay lại</a>
            </div>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên truyện</label>
                    <input type="text" name="tentruyen" id="title" class="form-control" 
                           value="<?php echo $row['tentruyen']; ?>" required onkeyup="ChangeToSlug()">
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Slug</label>
                    <input type="text" name="slug_truyen" id="slug" class="form-control" 
                           value="<?php echo $row['slug_truyen']; ?>" readonly>
                </div>

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Thay ảnh bìa mới (Để trống nếu giữ nguyên)</label>
                        <input type="file" name="hinhanh" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-4 text-center">
                        <label class="d-block mb-2 fw-bold">Ảnh hiện tại</label>
                        <img src="../../../public/uploads/<?php echo $row['hinhanh']; ?>" width="100" class="img-thumbnail">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tác giả</label>
                        <input type="text" name="tacgia" class="form-control" value="<?php echo $row['tacgia']; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Danh mục</label>
                        <select name="danhmuc_id" class="form-select">
                            <?php while($dm = mysqli_fetch_assoc($query_dm)){ ?>
                                <option value="<?php echo $dm['id']; ?>" 
                                    <?php if($dm['id'] == $row['danhmuc_id']) echo 'selected'; ?>>
                                    <?php echo $dm['tendanhmuc']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Tóm tắt</label>
                    <textarea name="tomtat" class="form-control" rows="5"><?php echo $row['tomtat']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <select name="kichhoat" class="form-select">
                        <option value="1" <?php if($row['kichhoat']==1) echo 'selected'; ?>>Hiển thị</option>
                        <option value="0" <?php if($row['kichhoat']==0) echo 'selected'; ?>>Ẩn</option>
                    </select>
                </div>

                <button type="submit" name="suatruyen" class="btn btn-warning w-100">Cập Nhật Truyện</button>
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