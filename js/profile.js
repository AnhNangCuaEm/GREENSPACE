
document.getElementById('changeAvtBtn').addEventListener('click', function () {
    document.getElementById('avatarPopup').style.display = 'block';
    document.body.style.overflow = 'hidden'; // Vô hiệu hóa cuộn
});

document.getElementById('closePopup').addEventListener('click', function () {
    document.getElementById('avatarPopup').style.display = 'none';
    document.body.style.overflow = 'auto'; // Bật lại cuộn
});

document.getElementById('applyAvatar').addEventListener('click', function () {
    const selectedAvatar = document.querySelector('.avatar-option.selected');
    if (selectedAvatar) {
        const newAvatar = selectedAvatar.src; // Get the selected avatar URL

        // Send AJAX request to update the avatar
        fetch('functions/update_avatar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ avatar: newAvatar }),
        })
            .then(response => {
                if (response.ok) {
                    document.getElementById('avatarPopup').style.display = 'none'; // Tắt popup sau khi click apply
                    document.body.style.overflow = 'auto'; // Bật lại cuộn

                    // Show result popup after applying avatar
                    const resultPopup = document.getElementById('result');
                    resultPopup.innerHTML = 'アバター変更しました!'; // Display success message
                    resultPopup.classList.add('slidedown'); // Add class for animation

                    // Set timeout to hide popup after 3 seconds
                    setTimeout(() => {
                        resultPopup.classList.remove('slidedown'); // Remove slidedown class
                        resultPopup.classList.add('slideup'); // Add class to hide animation

                        // Reset animation classes after slideup completes
                        setTimeout(() => {
                            resultPopup.classList.remove('slideup'); // Remove slideup class for future displays
                        }, 300); // Time needed to complete animation
                    }, 4000); // 3 seconds

                } else {
                    console.error('アバター変更失敗しました');
                }
            })
            .catch(error => console.error('Fetch error:', error));
    }
});

document.querySelectorAll('.avatar-option').forEach(option => {
    option.addEventListener('click', function () {
        // Xóa lớp 'selected' và 'clicked' khỏi tất cả các tùy chọn
        document.querySelectorAll('.avatar-option').forEach(opt => {
            opt.classList.remove('selected');
            opt.classList.remove('clicked'); // Remove clicked class as well
        });
        // Thêm lớp 'selected' và 'clicked' cho tùy chọn hiện tại
        this.classList.add('selected');
        this.classList.add('clicked'); // Thêm lớp clicked để tạo hiệu ứng
    });
});