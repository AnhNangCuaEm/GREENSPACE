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
        data[key] = value;
    });

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
            console.error('プロフィールの更新に失敗しました');
        }
    })
    .catch(error => console.error('Fetch error:', error));
});

document.getElementById('closePopup').addEventListener('click', function () {
    document.getElementById('infoPopup').style.display = 'none'; // Hide the popup
});