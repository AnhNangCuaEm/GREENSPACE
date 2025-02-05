document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    let timeoutId = null;

    //Handle input event
    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        
        const query = this.value.trim();
        
        if (query.length < 1) {
            searchResults.style.display = 'none';
            return;
        }

        // Set timeout to avoid sending too many requests
        timeoutId = setTimeout(() => {
            search(query)
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

    // Add event listener for focus
    searchInput.addEventListener('focus', function() {
        const query = this.value.trim();
        if (query.length >= 1) {
            searchResults.style.display = 'block';
        }
    });

    // Display results
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

    // Close results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });
});

async function search(query) {
    try {
        const response = await fetch(`/functions/search.php?query=${encodeURIComponent(query)}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
            credentials: 'omit' // Don't send cookies
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Search error:', error);
        throw error;
    }
}
