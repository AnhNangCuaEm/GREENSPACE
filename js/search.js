document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    let timeoutId = null;

    // Xử lý sự kiện input
    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        
        const query = this.value.trim();
        
        if (query.length < 1) {
            searchResults.style.display = 'none';
            return;
        }

        // Đặt timeout để tránh gửi quá nhiều request
        timeoutId = setTimeout(() => {
            fetch(`functions/search.php?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    searchResults.style.display = 'block';
                    const resultsContent = searchResults.querySelector('.results-content');
                    if (data.length > 0) {
                        displayResults(data);
                    } else {
                        resultsContent.innerHTML = '<div class="search-result-item">検索結果がありません</div>';
                    }
                })
                .catch(error => console.error('Error:', error));
        }, 300); // 300ms delay
    });

    // Thêm event listener cho focus
    searchInput.addEventListener('focus', function() {
        const query = this.value.trim();
        if (query.length >= 1) {
            searchResults.style.display = 'block';
        }
    });

    // Hiển thị kết quả
    function displayResults(results) {
        const resultsContent = searchResults.querySelector('.results-content');
        resultsContent.innerHTML = results.map(result => `
            <a href="${result.type}.php?id=${result.id}" class="search-result-item">
                <img src="${result.thumbnail}" alt="${result.name}">
                <div class="result-info">
                    <div class="result-name">${result.name}</div>
                    <div class="result-type">${result.type === 'park' ? '公園' : 'イベント'}</div>
                </div>
            </a>
        `).join('');
    }

    // Đóng kết quả khi click ra ngoài
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });
});
