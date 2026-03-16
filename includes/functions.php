    <?php
    // 1. Hàm giao diện đầu trang
    function render_header($title = "Hệ thống Admin") {
        $base_url = "/web_doctruyen/admin/"; // Đường dẫn gốc của bạn
        echo '
        <!DOCTYPE html>
        <html lang="vi">
        <head>
            <meta charset="UTF-8">
            <title>'.$title.'</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <style>
                body { background: #f4f7f6; }
                .sidebar { width: 250px; height: 100vh; position: fixed; background: #2c3e50; color: white; }
                .sidebar a { color: #bdc3c7; text-decoration: none; padding: 15px 20px; display: block; }
                .sidebar a:hover { background: #34495e; color: white; }
                .main-content { margin-left: 250px; padding: 30px; }
            </style>
        </head>
        <body>
        <div class="sidebar">
            <div class="p-3 text-center"><h4>ADMIN PANEL</h4></div>
            <nav>
                <a href="'.$base_url.'index.php">Dashboard</a>
                <a href="'.$base_url.'modules/truyen/index.php">Quản lý Truyện</a>
                <a href="'.$base_url.'modules/chapter/index.php">Quản lý Chương</a>
            </nav>
        </div>
        <div class="main-content">';
    }

    // 2. Hàm giao diện cuối trang
    function render_footer() {
        echo '</div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script></body></html>';
    }

    // 3. Hàm bổ trợ: Hiển thị trạng thái Kích hoạt
    function show_status($status) {
        if($status == 1) return '<span class="badge bg-success">Hiển thị</span>';
        return '<span class="badge bg-danger">Đang ẩn</span>';
    }

    function rut_gon_van_ban($text, $limit = 100) {
        if (strlen($text) > $limit) {
            return substr($text, 0, $limit) . "...";
        }
        return $text;
    }

    // 4. Hàm lấy chữ cái đầu làm Avatar
    function get_avatar_letter($name) {
        if (empty($name)) return '?';
        // Sử dụng mb_substr để lấy chuẩn ký tự Tiếng Việt có dấu
        return strtoupper(mb_substr($name, 0, 1, 'UTF-8'));
    }

    // 5. Hàm kiểm tra đăng nhập (Dùng cho trang Profile, Admin)
    function check_login() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /web_doctruyen/user/login.php');
            exit();
        }
    }

    // 6. Hàm kiểm tra quyền Admin
    function is_admin() {
        return (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1);
    }

    // 7. Hàm định dạng ngày tháng Tiếng Việt
    function format_date($date) {
        return date('d/m/Y', strtotime($date));
    }

    // 8. Hàm thông báo Alert nhanh (Bootstrap)
    function show_alert($msg, $type = "success") {
        if(!empty($msg)) {
            echo '<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">
                    '.$msg.'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        }
    }

    // 9. Hàm làm sạch dữ liệu đầu vào (Chống SQL Injection cơ bản)
    function clean_input($conn, $data) {
        return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags($data)));
    }
/**
 * Hàm xử lý upload ảnh an toàn
 * @param array $file_input Dữ liệu từ $_FILES['name']
 * @param string $target_dir Thư mục lưu trữ (vd: '../public/uploads/avatars/')
 * @param int $max_size Kích thước tối đa (mặc định 2MB)
 * @return array ['success' => boolean, 'message' => string, 'filename' => string]
 */
function upload_image($file_input, $target_dir, $max_size = 2097152) {
    // 1. Kiểm tra nếu không có file được chọn
    if (empty($file_input['name'])) {
        return ['success' => false, 'message' => 'Vui lòng chọn một file ảnh.'];
    }

    // 2. Tạo thư mục nếu chưa tồn tại
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = basename($file_input['name']);
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // 3. Kiểm tra xem có phải là ảnh thật không
    $check = getimagesize($file_input['tmp_name']);
    if($check === false) {
        return ['success' => false, 'message' => 'File không phải là ảnh hợp lệ.'];
    }

    // 4. Kiểm tra kích thước file (mặc định < 2MB)
    if ($file_input['size'] > $max_size) {
        return ['success' => false, 'message' => 'File ảnh quá lớn (Tối đa 2MB).'];
    }

    // 5. Kiểm tra định dạng file cho phép
    $allow_types = ['jpg', 'png', 'jpeg', 'gif'];
    if(!in_array($imageFileType, $allow_types)) {
        return ['success' => false, 'message' => 'Chỉ chấp nhận các định dạng JPG, JPEG, PNG & GIF.'];
    }

    // 6. Tự động đổi tên file để tránh trùng (Dùng timestamp + chuỗi ngẫu nhiên)
    $new_filename = time() . '_' . uniqid() . '.' . $imageFileType;
    $final_path = $target_dir . $new_filename;

    // 7. Thực hiện di chuyển file từ thư mục tạm sang thư mục đích
    if (move_uploaded_file($file_input['tmp_name'], $final_path)) {
        return ['success' => true, 'message' => 'Upload thành công.', 'filename' => $new_filename];
    } else {
        return ['success' => false, 'message' => 'Có lỗi xảy ra khi lưu file.'];
    }
}
   ?>
