const synth = window.speechSynthesis;
let utterance = null;
let isPaused = false;
let currentSpeed = 1.0;

// Hàm hỗ trợ tìm giọng tiếng Việt tốt nhất có thể
function getVietnameseVoice() {
    const voices = synth.getVoices();
    // Ưu tiên tìm giọng vi-VN, nếu không thấy thì tìm giọng có chữ 'Vietnam'
    return voices.find(v => v.lang === 'vi-VN' || v.lang === 'vi_VN' || v.name.includes('Vietnamese'));
}

function playAudio() {
    if (typeof isLoggedIn !== 'undefined' && !isLoggedIn) {
        if (confirm("Bạn cần đăng nhập để sử dụng trình đọc AI. Chuyển đến trang đăng nhập?")) {
            window.location.href = "User/login.php";
        }
        return;
    }
    
    const textContainer = document.getElementById('chapter-text');
    if (!textContainer) return;

    const content = textContainer.innerText.trim();
    const btn = document.getElementById('btn-play-audio');

    // Nếu đang nói mà nhấn nút
    if (synth.speaking) {
        if (isPaused) {
            synth.resume();
            isPaused = false;
            btn.innerHTML = '<i class="fas fa-pause me-1"></i> Tạm dừng';
        } else {
            synth.pause();
            isPaused = true;
            btn.innerHTML = '<i class="fas fa-play me-1"></i> Tiếp tục';
        }
        return;
    }

    // Khởi tạo phiên đọc mới
    synth.cancel(); 
    utterance = new SpeechSynthesisUtterance(content);
    
    // THIẾT LẬP GIỌNG ĐỌC TIẾNG VIỆT
    const vnVoice = getVietnameseVoice();
    if (vnVoice) {
        utterance.voice = vnVoice;
    }
    
    utterance.lang = 'vi-VN'; // Ép buộc ngôn ngữ là tiếng Việt
    utterance.rate = currentSpeed;

    utterance.onstart = () => {
        btn.innerHTML = '<i class="fas fa-pause me-1"></i> Tạm dừng';
    };

    utterance.onend = () => {
        btn.innerHTML = '<i class="fas fa-play me-1"></i> Nghe truyện';
        isPaused = false;
    };

    utterance.onerror = (event) => {
        console.error("Lỗi đọc AI:", event);
    };

    synth.speak(utterance);
}

function stopAudio() {
    synth.cancel();
    isPaused = false;
    document.getElementById('btn-play-audio').innerHTML = '<i class="fas fa-play me-1"></i> Nghe truyện';
}

function changeSpeed(val) {
    currentSpeed = parseFloat(val);
    if (synth.speaking) {
        stopAudio();
        playAudio();
    }
}

// Lệnh này quan trọng: Load danh sách giọng nói ngay khi trình duyệt sẵn sàng
if (speechSynthesis.onvoiceschanged !== undefined) {
    speechSynthesis.onvoiceschanged = getVietnameseVoice;
}