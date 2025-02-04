document.getElementById('editBtn').addEventListener('click', function () {
    document.getElementById('infoPopup').style.display = 'block';
    document.body.style.overflow = 'hidden'; // Vô hiệu hóa cuộn
});

document.getElementById('closeInfoPopup').addEventListener('click', function () {
    document.getElementById('infoPopup').style.display = 'none';
    document.body.style.overflow = 'auto'; // Bật lại cuộn
});

document.getElementById('editForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);
    const data = {};
    let hasChanges = false;

    // Convert FormData to a JSON object and check for changes
    formData.forEach((value, key) => {
        const input = document.getElementById(key);
        const originalValue = input.defaultValue;
        
        if (key === 'phone') {
            if (value.trim() === '') {
                data[key] = '0';
                if (originalValue !== '') hasChanges = true;
            } else {
                data[key] = value;
                if (value !== originalValue) hasChanges = true;
            }
        } else if (key !== 'password' && key !== 'confirmPassword') {
            data[key] = value;
            if (value !== originalValue) hasChanges = true;
        }
    });

    // Kiểm tra password riêng
    const password = formData.get('password');
    const confirmPassword = formData.get('confirmPassword');
    
    if (password || confirmPassword) {
        if (!password || !confirmPassword) {
            document.getElementById('infoPopup').style.display = 'none';
            const resultPopup = document.getElementById('result');
            resultPopup.innerHTML = 'パスワードを両方入力してください';
            resultPopup.classList.add('slidedown');

            setTimeout(() => {
                resultPopup.classList.remove('slidedown');
                resultPopup.classList.add('slideup');
                setTimeout(() => {
                    resultPopup.classList.remove('slideup');
                }, 300);
            }, 4000);
            return;
        }

        if (password !== confirmPassword) {
            document.getElementById('infoPopup').style.display = 'none';
            const resultPopup = document.getElementById('result');
            resultPopup.innerHTML = 'パスワードが一致しません';
            resultPopup.classList.add('slidedown');

            setTimeout(() => {
                resultPopup.classList.remove('slidedown');
                resultPopup.classList.add('slideup');
                setTimeout(() => {
                    resultPopup.classList.remove('slideup');
                }, 300);
            }, 4000);
            return;
        }

        // Nếu password hợp lệ, thêm flag và password vào data
        data.updatePassword = true;  // Thêm flag này
        data.password = password;
        hasChanges = true;
    }

    // Nếu không có thay đổi, hiển thị thông báo và dừng lại
    if (!hasChanges) {
        document.getElementById('infoPopup').style.display = 'none';
        const resultPopup = document.getElementById('result');
        resultPopup.innerHTML = '変更内容がありません'; // "Không có thay đổi nào"
        resultPopup.classList.add('slidedown');

        setTimeout(() => {
            resultPopup.classList.remove('slidedown');
            resultPopup.classList.add('slideup');
            setTimeout(() => {
                resultPopup.classList.remove('slideup');
            }, 300);
        }, 4000);
        return;
    }

    // Send AJAX request to update the profile
    fetch('functions/update_info.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' // Set content type to JSON
        },
        body: JSON.stringify(data), // Convert data to JSON string
    })
    .then(response => {
        if (response.ok) {
            document.getElementById('infoPopup').style.display = 'none'; // Hide the popup

            // Show result popup after applying changes
            const resultPopup = document.getElementById('result');
            resultPopup.innerHTML = 'プロフィールが更新されました!'; // Display success message
            resultPopup.classList.add('slidedown'); // Add class for animation

            // Set timeout to hide popup after 3 seconds
            setTimeout(() => {
                resultPopup.classList.remove('slidedown'); // Remove slidedown class
                resultPopup.classList.add('slideup'); // Add class to hide animation

                // Reset animation classes after slideup completes
                setTimeout(() => {
                    resultPopup.classList.remove('slideup'); // Remove slideup class for future displays
                }, 300); // Time needed to complete animation
            }, 4000); // 4 seconds

        } else {
            // Handle error response
            const resultPopup = document.getElementById('result');
            resultPopup.innerHTML = 'プロフィールの更新に失敗しました'; // Display error message
            resultPopup.classList.add('slidedown'); // Add class for animation

            // Set timeout to hide popup after 3 seconds
            setTimeout(() => {
                resultPopup.classList.remove('slidedown'); // Remove slidedown class
                resultPopup.classList.add('slideup'); // Add class to hide animation

                // Reset animation classes after slideup completes
                setTimeout(() => {
                    resultPopup.classList.remove('slideup'); // Remove slideup class for future displays
                }, 300); // Time needed to complete animation
            }, 4000); // 4 seconds
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        const resultPopup = document.getElementById('result');
        resultPopup.innerHTML = 'エラーが発生しました。もう一度お試しください。'; // Display fetch error message
        resultPopup.classList.add('slidedown'); // Add class for animation

        // Set timeout to hide popup after 3 seconds
        setTimeout(() => {
            resultPopup.classList.remove('slidedown'); // Remove slidedown class
            resultPopup.classList.add('slideup'); // Add class to hide animation

            // Reset animation classes after slideup completes
            setTimeout(() => {
                resultPopup.classList.remove('slideup'); // Remove slideup class for future displays
            }, 300); // Time needed to complete animation
        }, 4000); // 4 seconds
    });
});

document.getElementById('closePopup').addEventListener('click', function () {
    document.getElementById('infoPopup').style.display = 'none'; // Hide the popup
});