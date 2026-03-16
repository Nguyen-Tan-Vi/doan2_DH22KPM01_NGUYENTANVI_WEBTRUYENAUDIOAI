// main.js - Các tính năng tương tác cơ bản
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Nút cuộn lên đầu trang (Back to Top)
    const backToTop = document.createElement('button');
    backToTop.innerHTML = '<i class="fas fa-arrow-up"></i>';
    backToTop.className = 'btn btn-danger back-to-top shadow';
    backToTop.style = "position:fixed; bottom:20px; right:20px; display:none; z-index:1000;";
    document.body.appendChild(backToTop);

    window.onscroll = function() {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            backToTop.style.display = "block";
        } else {
            backToTop.style.display = "none";
        }
    };

    backToTop.onclick = function() {
        window.scrollTo({top: 0, behavior: 'smooth'});
    };

    // 2. Tự động lưu vị trí đọc (Nếu cần)
    // Code này có thể mở rộng sau
});