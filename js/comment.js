document.addEventListener('DOMContentLoaded', function() {
    // Get necessary elements
    const openCommentBtn = document.getElementById('openCommentPopup');
    const closeCommentBtn = document.getElementById('closeCommentPopup');
    const commentPopup = document.querySelector('.comment-popup');

    // Process event when click open popup button
    openCommentBtn.addEventListener('click', function() {
        commentPopup.classList.add('show');
        document.body.style.overflow = 'hidden';
    });

    // Process event when click close popup button
    closeCommentBtn.addEventListener('click', function() {
        commentPopup.classList.remove('show');
        document.body.style.overflow = '';
    });

    // Close popup when click outside content
    commentPopup.addEventListener('click', function(e) {
        if (e.target === commentPopup) {
            commentPopup.classList.remove('show');
            document.body.style.overflow = '';
        }
    });

    // Add form submission handler
    const commentForm = document.getElementById('commentForm');
    commentForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        
        fetch('functions/comment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Clear form
            commentForm.reset();
            
            // Close popup
            commentPopup.classList.remove('show');
            document.body.style.overflow = '';

            // Show message
            const resultPopup = document.getElementById('result');
            resultPopup.innerHTML = data.success ? 'コメントを投稿しました!' : 'コメントの投稿に失敗しました。';
            resultPopup.classList.add('slidedown');

            // Hide message after 3 seconds
            setTimeout(() => {
                resultPopup.classList.remove('slidedown');
                resultPopup.classList.add('slideup');

                setTimeout(() => {
                    resultPopup.classList.remove('slideup');
                    resultPopup.innerHTML = ''; // Clear the content
                    if (data.success) {
                    }
                }, 300);
            }, 3000);
        })
        .catch(error => {
            console.error('Error:', error);
            const resultPopup = document.getElementById('result');
            resultPopup.innerHTML = 'エラーが発生しました。';
            resultPopup.classList.add('slidedown');

            setTimeout(() => {
                resultPopup.classList.remove('slidedown');
                resultPopup.classList.add('slideup');

                setTimeout(() => {
                    resultPopup.classList.remove('slideup');
                    resultPopup.innerHTML = ''; // Clear the content
                }, 300);
            }, 3000);
        });
    });

    // Add delete comment handler
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-comment')) {
            const commentId = e.target.closest('.delete-comment').dataset.commentId;
            const userEmail = document.querySelector('input[name="email"]').value;

            const formData = new URLSearchParams();
            formData.append('commentId', commentId);
            formData.append('email', userEmail);

            fetch('functions/comment.php', {
                method: 'DELETE',
                body: formData.toString(),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then(response => response.json())
            .then(data => {
                const resultPopup = document.getElementById('result');
                resultPopup.innerHTML = data.success ? 'コメントを削除しました!' : 'コメントの削除に失敗しました。';
                resultPopup.classList.add('slidedown');

                // Add code to close popup
                commentPopup.style.display = 'none';
                document.body.style.overflow = '';

                setTimeout(() => {
                    resultPopup.classList.remove('slidedown');
                    resultPopup.classList.add('slideup');

                    setTimeout(() => {
                        resultPopup.classList.remove('slideup');
                        resultPopup.innerHTML = ''; // Clear the content
                        if (data.success) {
                        }
                    }, 300);
                }, 3000);
            })
            .catch(error => {
                console.error('Error:', error);
                const resultPopup = document.getElementById('result');
                resultPopup.innerHTML = 'エラーが発生しました。';
                resultPopup.classList.add('slidedown');
            });
        }
    });
});
