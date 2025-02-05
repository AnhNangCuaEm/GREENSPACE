
document.getElementById('changeAvtBtn').addEventListener('click', function () {
    document.getElementById('avatarPopup').style.display = 'block';
    document.body.style.overflow = 'hidden';
});

document.getElementById('closePopup').addEventListener('click', function () {
    document.getElementById('avatarPopup').style.display = 'none';
    document.body.style.overflow = 'auto';
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
                    document.getElementById('avatarPopup').style.display = 'none'; // Close popup after clicking apply
                    document.body.style.overflow = 'auto'; // Enable scrolling

                    // Show result popup after applying avatar
                    const resultPopup = document.getElementById('result');
                    resultPopup.innerHTML = 'アバター変更しました!';
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
                    console.error('アバター変更失敗しました');
                }
            })
            .catch(error => console.error('Fetch error:', error));
    }
});

document.querySelectorAll('.avatar-option').forEach(option => {
    option.addEventListener('click', function () {
        //Remove selected and clicked classes from all options
        document.querySelectorAll('.avatar-option').forEach(opt => {
            opt.classList.remove('selected');
            opt.classList.remove('clicked');
        });
        // Add selected and clicked classes to current option
        this.classList.add('selected');
        this.classList.add('clicked');
    });
});