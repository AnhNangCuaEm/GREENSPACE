document.getElementById('editBtn').addEventListener('click', function () {
    document.getElementById('infoPopup').style.display = 'block';
    document.body.style.overflow = 'hidden'; // Vô hiệu hóa cuộn
});

document.getElementById('closeInfoPopup').addEventListener('click', function () {
    document.getElementById('infoPopup').style.display = 'none';
    document.body.style.overflow = 'auto'; // Bật lại cuộn
});

document.getElementById('editForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(this); // Create a FormData object from the form
    const data = {}; // Create an object to hold the data

    // Convert FormData to a JSON object
    formData.forEach((value, key) => {
        // Check if phone is empty and set it to '0' if true
        if (key === 'phone' && value.trim() === '') {
            data[key] = '0'; // Default to '0' if phone is empty
        } else {
            data[key] = value;
        }
    });

    // Check if password fields are filled and match
    const password = data.password;
    const confirmPassword = data.confirmPassword;

    if (password && confirmPassword) {
        if (password === confirmPassword) {
            data.updatePassword = true; // Indicate that password update is requested
        } else {
            // Hide the popup before showing the error message
            document.getElementById('infoPopup').style.display = 'none'; // Hide the popup

            // Show error message if passwords do not match
            const resultPopup = document.getElementById('result');
            resultPopup.innerHTML = 'パスワードが一致しません'; // Display password mismatch message
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

            return; // Exit the function if passwords do not match
        }
    } else {
        delete data.password; // Remove password if not valid
        delete data.confirmPassword; // Remove confirm password if not valid
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
            console.log('Profile updated successfully');
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
            console.error('プロフィールの更新に失敗しました');
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