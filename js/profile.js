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
        const newAvatar = selectedAvatar.src;

        fetch('functions/update_avatar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ avatar: newAvatar }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update avatar in the avatar-box
                    document.querySelector('.avatar-box img').src = newAvatar;

                    document.getElementById('avatarPopup').style.display = 'none';
                    document.getElementById('overlay').style.display = 'none';
                    document.body.style.overflow = 'auto';

                    const resultPopup = document.getElementById('result');
                    resultPopup.innerHTML = 'アバター変更しました!';
                    resultPopup.classList.add('slidedown');

                    setTimeout(() => {
                        resultPopup.classList.remove('slidedown');
                        resultPopup.classList.add('slideup');

                        setTimeout(() => {
                            resultPopup.classList.remove('slideup');
                            resultPopup.innerHTML = '';
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