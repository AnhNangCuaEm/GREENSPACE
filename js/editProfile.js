document.getElementById('editBtn').addEventListener('click', function () {
    document.getElementById('infoPopup').style.display = 'block';
    document.body.style.overflow = 'hidden'; //Disable scrolling
});

document.getElementById('closeInfoPopup').addEventListener('click', function () {
    document.getElementById('infoPopup').style.display = 'none';
    document.body.style.overflow = 'auto'; //Enable scrolling
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

    // Check password separately
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

        // If password is valid, add flag and password to data
        data.updatePassword = true;  // Add this flag
        data.password = password;
        hasChanges = true;
    }

    // If there are no changes, show message and stop
    if (!hasChanges) {
        document.getElementById('infoPopup').style.display = 'none';
        const resultPopup = document.getElementById('result');
        resultPopup.innerHTML = '変更内容がありません';
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
            resultPopup.innerHTML = 'プロフィールが更新されました!';
            resultPopup.classList.add('slidedown');

            // Set timeout to hide popup after 3 seconds
            setTimeout(() => {
                resultPopup.classList.remove('slidedown');
                resultPopup.classList.add('slideup');

                // Reset animation classes after slideup completes
                setTimeout(() => {
                    resultPopup.classList.remove('slideup');
                }, 300);
            }, 4000);

        } else {
            // Handle error response
            const resultPopup = document.getElementById('result');
            resultPopup.innerHTML = 'プロフィールの更新に失敗しました';
            resultPopup.classList.add('slidedown');

            // Set timeout to hide popup after 3 seconds
            setTimeout(() => {
                resultPopup.classList.remove('slidedown');
                resultPopup.classList.add('slideup');

                // Reset animation classes after slideup completes
                setTimeout(() => {
                    resultPopup.classList.remove('slideup');
                }, 300);
            }, 4000);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        const resultPopup = document.getElementById('result');
        resultPopup.innerHTML = 'エラーが発生しました。もう一度お試しください。';
        resultPopup.classList.add('slidedown');

        // Set timeout to hide popup after 3 seconds
        setTimeout(() => {
            resultPopup.classList.remove('slidedown');
            resultPopup.classList.add('slideup');

            // Reset animation classes after slideup completes
            setTimeout(() => {
                resultPopup.classList.remove('slideup');
            }, 300);
        }, 4000);
    });
});

document.getElementById('closePopup').addEventListener('click', function () {
    document.getElementById('infoPopup').style.display = 'none'; // Hide the popup
});