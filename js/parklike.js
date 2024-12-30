document.addEventListener('DOMContentLoaded', function () {
    const likeSvg = document.getElementById('likeSvg');
    const likeCount = document.getElementById('likeCount');

    likeSvg.addEventListener('click', function () {
        const parkId = new URLSearchParams(window.location.search).get('id');
        const isCurrentlyLiked = likeSvg.style.fill === 'rgb(252, 248, 219)'; // #fcf8db

        // Send AJAX request
        fetch('functions/parklike.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=updateLike&parkId=${parkId}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Toggle the fill style
                    likeSvg.style.fill = isCurrentlyLiked ? 'none' : '#fcf8db';

                    // Update like count
                    likeCount.textContent = data.likeCount;
                }
            })
            .catch(error => console.error('Error:', error));
    });
});
