document.addEventListener('DOMContentLoaded', function () {
    // Get active section from localStorage, default to 'dashboard' if none saved
    const activeSection = localStorage.getItem('activeSection') || 'dashboard';

    // Activate the saved section
    const activeButton = document.querySelector(`.nav-btn[data-section="${activeSection}"]`);
    if (activeButton) {
        // Remove active class from all buttons and sections
        document.querySelectorAll('.nav-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.content-section').forEach(section => section.classList.remove('active'));

        // Add active class to saved button and section
        activeButton.classList.add('active');
        document.getElementById(`${activeSection}-section`).classList.add('active');

        // Load content for active section
        switch (activeSection) {
            case 'dashboard':
                loadDashboard();
                break;
            case 'users':
                loadUsers();
                break;
            case 'parks':
                loadParks();
                break;
            case 'events':
                loadEvents();
                break;
            case 'feedbacks':
                loadFeedbacks();
                break;
        }
    }

    // Add click event listeners to nav buttons
    document.querySelectorAll('.nav-btn').forEach(button => {
        button.addEventListener('click', function () {
            if (this.hasAttribute('onclick')) return; // Skip for buttons with onclick attribute

            const section = this.dataset.section;

            // Save active section to localStorage
            localStorage.setItem('activeSection', section);

            // Remove active class from all buttons and sections
            document.querySelectorAll('.nav-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.content-section').forEach(section => section.classList.remove('active'));

            // Add active class to clicked button and corresponding section
            this.classList.add('active');
            document.getElementById(`${section}-section`).classList.add('active');

            // Load content based on section
            switch (section) {
                case 'dashboard':
                    loadDashboard();
                    break;
                case 'users':
                    loadUsers();
                    break;
                case 'parks':
                    loadParks();
                    break;
                case 'events':
                    loadEvents();
                    break;
                case 'feedbacks':
                    loadFeedbacks();
                    break;
            }
        });
    });
});

function loadUsers() {
    fetch('functions/get_users.php')
        .then(response => response.json())
        .then(users => {
            const usersSection = document.getElementById('users-section');
            let html = `
                <div class="events-header">
                    <h2>User Management</h2>
                    <div class="header-controls">
                        <input type="text" id="userSearch" placeholder="ユーザーを検索..." onkeyup="filterUsers()">
                    </div>
                </div>
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>アバター</th>
                            <th>名前</th>
                            <th>メール</th>
                            <th>電話番号</th>
                            <th>住所</th>
                            <th>役割</th>
                            <th>ステータス</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
            `;

            users.forEach(user => {
                html += `
                    <tr data-status="${user.status}" data-role="${user.role}">
                        <td><img src="${user.avatar}" alt="avatar" width="50"></td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.phone}</td>
                        <td>${user.address}</td>
                        <td>
                            <select class="role-select" onchange="updateUserRole('${user.email}', this.value)">
                                <option value="user" ${user.role === 'user' ? 'selected' : ''}>User</option>
                                <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Admin</option>
                            </select>
                        </td>
                        <td>
                            <select class="status-select" onchange="updateUserStatus('${user.email}', this.value)">
                                <option value="active" ${user.status === 'active' ? 'selected' : ''}>Active</option>
                                <option value="banned" ${user.status === 'banned' ? 'selected' : ''}>Banned</option>
                            </select>
                        </td>
                    </tr>
                `;
            });

            html += `</tbody></table>`;
            usersSection.innerHTML = html;
        });
}

function updateUserRole(email, newRole) {
    fetch('functions/update_user_role.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, role: newRole })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('ユーザーの役割を更新しました');
            } else {
                alert('ユーザーの役割を更新できませんでした');
            }
        });
}

function updateUserStatus(email, newStatus) {
    fetch('functions/update_user_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, status: newStatus })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('ユーザーのステータスを更新しました');
            } else {
                alert('ユーザーのステータスを更新できませんでした');
            }
        });
}

function loadParks() {
    fetch('functions/get_parks.php')
        .then(response => response.json())
        .then(parks => {
            const parksSection = document.getElementById('parks-section');
            let html = `
                <div class="events-header">
                    <h2>Park Management</h2>
                    <div class="header-controls">
                        <input type="text" id="parkSearch" placeholder="公園を検索..." onkeyup="filterParks()">
                        <button class="add-event-btn" onclick="showAddParkModal()">
                            <i class="fas fa-plus"></i> 新公園追加
                        </button>
                    </div>
                </div>
                <table class="events-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Thumb</th>
                            <th>公園名</th>
                            <th>場所</th>
                            <th>面積</th>
                            <th>料金</th>
                            <th>最寄り駅</th>
                            <th>特徴</th>
                            <th>説明</th>
                            <th>メニュー</th>
                        </tr>
                    </thead>
                    <tbody id="parkTableBody">
            `;

            parks.forEach(park => {
                html += `
                    <tr>
                        <td>${park.id}</td>
                        <td><img src="${park.thumbnail}" alt="Park thumbnail" width="50" height="50" style="object-fit: cover;"></td>
                        <td>${park.name}</td>
                        <td>${park.location}</td>
                        <td>${park.area || 'N/A'}</td>
                        <td>${park.price}</td>
                        <td>${park.nearest ? park.nearest.substring(0, 15) + '...' : '最寄り駅がありません'}</td>
                        <td>${park.special}</td>
                        <td>${park.description ? park.description.substring(0, 40) + '...' : '説明がありません'}</td>
                        <td>
                            <div class="action-menu">
                                <button class="action-menu-btn">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>
                                <div class="action-menu-content">
                                    <button onclick="showParkDetails(${park.id})" class="details-btn">
                                        <i class="fas fa-info-circle"></i> 詳細
                                    </button>
                                    <button onclick="editPark(${park.id})" class="edit-btn">
                                        <i class="fas fa-edit"></i> 編集
                                    </button>
                                    <button onclick="addParkImage(${park.id})" class="add-image-btn">
                                        <i class="fas fa-images"></i> 写真管理
                                    </button>
                                    <button onclick="showComments(${park.id})" class="comments-btn">
                                        <i class="fas fa-comments"></i> コメント
                                    </button>
                                    <button onclick="deletePark(${park.id})" class="delete-btn">
                                        <i class="fas fa-trash"></i> 削除
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
            });

            html += `</tbody></table>`;
            parksSection.innerHTML = html;

            // Add click event listeners for action menus
            document.querySelectorAll('.action-menu-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    // Close all other menus
                    document.querySelectorAll('.action-menu').forEach(menu => {
                        if (menu !== btn.parentElement) {
                            menu.classList.remove('active');
                        }
                    });
                    // Toggle current menu
                    btn.parentElement.classList.toggle('active');
                });
            });

            // Close menu when clicking outside
            document.addEventListener('click', () => {
                document.querySelectorAll('.action-menu').forEach(menu => {
                    menu.classList.remove('active');
                });
            });
        });
}

function showAddParkModal() {
    document.body.style.overflow = 'hidden';
    const modal = `
        <div class="modal" id="parkModal">
            <div class="modal-content">
                <h2>新公園追加</h2>
                <form id="parkForm">
                    <div class="form-group">
                        <label>公園名:</label>
                        <input type="text" name="name" placeholder="公園名" required>
                    </div>
                    <div class="form-group">
                        <label>公園名 よみがな:</label>
                        <input type="text" name="name_yomi" placeholder="公園名 (よみがな)" required>
                    </div>
                    <div class="form-group">
                        <label>公園名 英語:</label>
                        <input type="text" name="name_romaji" placeholder="公園名 英語 (ローマ字)" required>
                    </div>
                    <div class="form-group">
                        <label>場所:</label>
                        <input type="text" name="location" placeholder="場所" required>
                    </div>
                    <div class="form-group">
                        <label>場所 よみがな:</label>
                        <input type="text" name="location_yomi" placeholder="場所 よみがな" required>
                    </div>
                    <div class="form-group">
                        <label>場所 英語:</label>
                        <input type="text" name="location_romaji" placeholder="場所 英語 (ローマ字)" required>
                    </div>
                    <div class="form-group">
                        <label>面積:</label>
                        <input type="text" name="area" placeholder="面積" required>
                    </div>
                    <div class="form-group">
                        <label>料金:</label>
                        <input type="text" name="price" placeholder="料金" required>
                    </div>
                    <div class="form-group">
                        <label>最寄り駅:</label>
                        <input type="text" name="nearest" placeholder="最寄り駅" required>
                    </div>
                    <div class="form-group">
                        <label>特徴:</label>
                        <input type="text" name="special" placeholder="特徴" required>
                    </div>
                    <div class="form-group">
                        <label>短説明文:</label>
                        <input type="text" name="parkfeature" placeholder="スライドに表示する説明より短い文" required>
                    </div>
                    <div class="form-group">
                        <label>サムネイルURL:</label>
                        <input type="text" name="thumbnail" placeholder="サムネイルURL" required>
                    </div>
                    <div class="form-group">
                        <label>Google Maps iframe:</label>
                        <textarea name="map" placeholder="Google Maps iframe" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>説明:</label>
                        <textarea name="description" placeholder="説明" required></textarea>
                    </div>
                    <div class="modal-buttons">
                        <button type="submit">保存</button>
                        <button type="button" onclick="closeModal()">キャンセル</button>
                    </div>
                </form>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modal);

    document.getElementById('parkForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        addPark(Object.fromEntries(formData));
    });
}

function addPark(parkData) {
    fetch('functions/add_park.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(parkData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeModal();
                loadParks();
                alert('公園を追加しました');
            } else {
                alert('公園を追加できませんでした');
            }
        });
}

function editPark(parkId) {
    fetch(`functions/get_park.php?id=${parkId}`)
        .then(response => response.json())
        .then(park => {
            showEditParkModal(park);
        });
}

function showEditParkModal(park) {
    document.body.style.overflow = 'hidden';
    const modal = `
        <div class="modal" id="parkModal">
            <div class="modal-content">
                <h2>公園編集</h2>
                <form id="parkForm">
                    <input type="hidden" name="id" value="${park.id}">
                    <div class="form-group">
                        <label>公園名:</label>
                        <input type="text" name="name" value="${park.name}" required>
                    </div>
                    <div class="form-group">
                        <label>公園名 よみがな:</label>
                        <input type="text" name="name_yomi" value="${park.name_yomi || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>公園名 英語:</label>
                        <input type="text" name="name_romaji" value="${park.name_romaji || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>場所:</label>
                        <input type="text" name="location" value="${park.location}" required>
                    </div>
                    <div class="form-group">
                        <label>場所 よみがな:</label>
                        <input type="text" name="location_yomi" value="${park.location_yomi || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>場所 英語:</label>
                        <input type="text" name="location_romaji" value="${park.location_romaji || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>面積:</label>
                        <input type="text" name="area" value="${park.area || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>料金:</label>
                        <input type="text" name="price" value="${park.price || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>最寄り駅:</label>
                        <input type="text" name="nearest" value="${park.nearest || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>特徴:</label>
                        <input type="text" name="special" value="${park.special || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>サムネイルURL:</label>
                        <input type="url" name="thumbnail" value="${park.thumbnail || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Google Maps iframe:</label>
                        <textarea name="map" required>${park.map || ''}</textarea>
                    </div>
                    <div class="form-group">
                        <label>スライドに表示する説明より短い文:</label>
                        <input type="text" name="parkfeature" value="${park.parkfeature}" required>
                    </div>
                    <div class="form-group">
                        <label>説明:</label>
                        <textarea name="description" required>${park.description}</textarea>
                    </div>
                    <div class="modal-buttons">
                        <button type="submit">更新</button>
                        <button type="button" onclick="closeModal()">キャンセル</button>
                    </div>
                </form>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modal);

    document.getElementById('parkForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        updatePark(Object.fromEntries(formData));
    });
}

function updatePark(parkData) {
    fetch('functions/update_park.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(parkData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeModal();
                loadParks();
                alert('公園を更新しました');
            } else {
                alert('公園を更新できませんでした');
            }
        });
}

function deletePark(parkId) {
    if (confirm('公園を削除しますか？')) {
        fetch('functions/delete_park.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: parkId })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadParks();
                    alert('公園を削除しました');
                } else {
                    const errorMessage = data.message || '公園を削除できませんでした';
                    console.error('Delete park error:', data);
                    alert(errorMessage);
                }
            })
            .catch(error => {
                console.error('Network error:', error);
                alert('ネットワークエラーが発生しました');
            });
    }
}

function loadEvents() {
    fetch('functions/get_events.php')
        .then(response => response.json())
        .then(events => {
            const eventsSection = document.getElementById('events-section');
            let html = `
                <div class="events-header">
                    <h2>Event Management</h2>
                    <div class="header-controls">
                        <input type="text" id="eventSearch" placeholder="イベントを検索..." onkeyup="filterEvents()">
                        <button class="add-event-btn" onclick="showAddEventModal()">
                            <i class="fas fa-plus"></i> 新イベント追加
                        </button>
                    </div>
                </div>
                <table class="events-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Thumb</th>
                            <th>イベント名</th>
                            <th>場所</th>
                            <th>日付</th>
                            <th>時間</th>
                            <th>料金</th>
                            <th>説明</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="eventTableBody">
            `;

            events.forEach(event => {
                html += `
                    <tr>
                        <td>${event.id}</td>
                        <td><img src="${event.thumbnail}" alt="Event thumbnail" width="50" height="50" style="object-fit: cover;"></td>
                        <td>${event.name}</td>
                        <td>${event.location}</td>
                        <td>${event.date}</td>
                        <td>${event.time}</td>
                        <td>${event.price}</td>
                        <td>${event.description.substring(0, 50)}...</td>
                        <td>
                            <button onclick="editEvent(${event.id})" class="edit-btn"><i class="fas fa-edit"></i>編集</button>
                            <button onclick="deleteEvent(${event.id})" class="delete-btn"><i class="fas fa-trash"></i>削除</button>
                        </td>
                    </tr>
                `;
            });

            html += `</tbody></table>`;
            eventsSection.innerHTML = html;
        });
}

function showAddEventModal() {
    document.body.style.overflow = 'hidden';
    const modal = `
        <div class="modal" id="eventModal">
            <div class="modal-content">
                <h2>新イベント追加</h2>
                <form id="eventForm">
                    <div class="form-group">
                        <label>イベント名:</label>
                        <input type="text" name="name" placeholder="Event Name" required>
                    </div>
                    <div class="form-group">
                        <label>場所:</label>
                        <input type="text" name="location" placeholder="場所" required>
                    </div>
                    <div class="form-group">
                        <label>日付:</label>
                        <input type="text" name="date" placeholder="日付" required>
                    </div>
                    <div class="form-group">
                        <label>時間:</label>
                        <input type="text" name="time" placeholder="Time" required>
                    </div>
                    <div class="form-group">
                        <label>料金:</label>
                        <input type="text" name="price" placeholder="料金" required>
                    </div>
                    <div class="form-group">
                        <label>サムネイルURL:</label>
                        <input type="url" name="thumbnail" placeholder="サムネイルURL" required>
                    </div>
                    <div class="form-group">
                        <label>説明:</label>
                        <textarea name="description" placeholder="Description" required></textarea>
                    </div>
                    <div class="modal-buttons">
                        <button type="submit">保存</button>
                        <button type="button" onclick="closeModal()">キャンセル</button>
                    </div>
                </form>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modal);

    document.getElementById('eventForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        addEvent(Object.fromEntries(formData));
    });
}

function addEvent(eventData) {
    fetch('functions/add_event.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(eventData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeModal();
                loadEvents();
                alert('イベントを追加しました');
            } else {
                alert('イベントを追加できませんでした');
            }
        });
}

function editEvent(eventId) {
    fetch(`functions/get_event.php?id=${eventId}`)
        .then(response => response.json())
        .then(event => {
            showEditEventModal(event);
        });
}

function showEditEventModal(event) {
    document.body.style.overflow = 'hidden';
    const modal = `
        <div class="modal" id="eventModal">
            <div class="modal-content">
                <h2>イベント編集</h2>
                <form id="eventForm">
                    <input type="hidden" name="id" value="${event.id}">
                    <div class="form-group">
                        <label>イベント名:</label>
                        <input type="text" name="name" value="${event.name}">
                    </div>
                    <div class="form-group">
                        <label>場所:</label>
                        <input type="text" name="location" value="${event.location}">
                    </div>
                    <div class="form-group">
                        <label>日付:</label>
                        <input type="text" name="date" value="${event.date}">
                    </div>
                    <div class="form-group">
                        <label>時間:</label>
                        <input type="text" name="time" value="${event.time}">
                    </div>
                    <div class="form-group">
                        <label>料金:</label>
                        <input type="text" name="price" value="${event.price}">
                    </div>
                    <div class="form-group">
                        <label>サムネイルURL:</label>
                        <input type="url" name="thumbnail" value="${event.thumbnail}">
                    </div>
                    <div class="form-group">
                        <label>説明:</label>
                        <textarea name="description">${event.description}</textarea>
                    </div>
                    <div class="modal-buttons">
                        <button type="submit">更新</button>
                        <button type="button" onclick="closeModal()">キャンセル</button>
                    </div>
                </form>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modal);

    document.getElementById('eventForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        updateEvent(Object.fromEntries(formData));
    });
}

function updateEvent(eventData) {
    fetch('functions/update_event.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(eventData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeModal();
                loadEvents();
                alert('イベントを更新しました');
            } else {
                alert('イベントを更新できませんでした');
            }
        });
}

function deleteEvent(eventId) {
    if (confirm('イベントを削除しますか？')) {
        fetch('functions/delete_event.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: eventId })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadEvents();
                    alert('イベントを削除しました');
                } else {
                    alert('イベントを削除できませんでした');
                }
            });
    }
}

function closeModal() {
    document.body.style.overflow = '';
    const modal = document.getElementById('eventModal');
    if (modal) {
        modal.remove();
    }
    const parkModal = document.getElementById('parkModal');
    if (parkModal) {
        parkModal.remove();
    }
}

function showParkDetails(parkId) {
    document.body.style.overflow = 'hidden';
    fetch(`functions/get_park.php?id=${parkId}`)
        .then(response => response.json())
        .then(park => {
            const modal = `
                <div class="modal" id="parkDetailsModal">
                    <div class="modal-content">
                        <h2>${park.name} 詳細</h2>
                        <div class="details-container">
                            <div class="details-section">
                                <h3>公園名</h3>
                                <p>漢字: ${park.name}</p>
                                <p>よみがな: ${park.name_yomi || 'Not available'}</p>
                                <p>ローマ字: ${park.name_romaji || 'Not available'}</p>
                            </div>

                            <div class="details-section">
                                <h3>場所</h3>
                                <p>漢字: ${park.location}</p>
                                <p>よみがな: ${park.location_yomi || 'Not available'}</p>
                                <p>ローマ字: ${park.location_romaji || 'Not available'}</p>
                            </div>

                            <div class="details-section">
                                <h3>周りの駅</h3>
                                <p>${park.nearest || 'Not available'}</p>
                            </div>

                            <div class="details-section">
                                <h3>公園の特徴</h3>
                                <p>${park.parkfeature || 'No features available'}</p>
                            </div>

                            <div class="details-section">
                                <h3>公園の説明</h3>
                                <p>${park.description || 'No description available'}</p>
                            </div>

                            <div class="details-section">
                                <h3>地図</h3>
                                <div class="map-container">
                                    ${park.map || 'No map available'}
                                </div>
                            </div>
                            
                            <div class="details-section">
                                <h3>写真</h3>
                                <div class="park-images">
                                    ${park.images ? park.images.map(image =>
                `<img src="${image.image_url}" alt="Park image" width="150">`
            ).join('') : 'No images available'}
                                </div>
                            </div>
                        </div>
                        <div class="modal-buttons">
                            <button onclick="closeDetailsModal()">閉じる</button>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modal);
        });
}

function closeDetailsModal() {
    document.body.style.overflow = '';
    const modal = document.getElementById('parkDetailsModal');
    if (modal) {
        modal.remove();
    }
}

function addParkImage(parkId) {
    document.body.style.overflow = 'hidden';
    fetch(`functions/get_park_images.php?park_id=${parkId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            const modal = `
                <div class="modal" id="parkImagesModal">
                    <div class="modal-content">
                        <h2>写真管理</h2>
                        <div class="park-images-container">
                            ${Array.isArray(data) ? data.map(image => `
                    <div class="park-image-item">
                        <img src="${image.image_url}" alt="Park image">
                        <div class="image-url">${image.image_url}</div>
                        <button onclick="deleteParkImage('${parkId}', ${image.id})" class="delete-image-btn">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `).join('') : '<p>No images available</p>'}
                        </div>
                        <div class="add-image-container">
                            <input type="text" id="newImageUrl" placeholder="新しい画像のURL">
                            <button onclick="addNewParkImage('${parkId}')" class="add-new-image-btn">
                                <i class="fas fa-plus"></i> 追加
                            </button>
                        </div>
                        <div class="modal-buttons">
                            <button onclick="closeImageModal()">閉じる</button>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modal);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('データの取得中にエラーが発生しました: ' + error.message);
        });
}

function addNewParkImage(parkId) {
    const imageUrl = document.getElementById('newImageUrl').value.trim();
    if (!imageUrl) {
        alert('画像URLを入力してください');
        return;
    }

    fetch('functions/add_park_image.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ park_id: parkId, image_url: imageUrl })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeImageModal();
                addParkImage(parkId); // Reload the images modal
                alert('画像を追加しました');
            } else {
                alert('画像を追加できませんでした');
            }
        });
}

function deleteParkImage(parkId, imageId) {
    if (confirm('この画像を削除しますか？')) {
        fetch('functions/delete_park_image.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ image_id: imageId })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeImageModal();
                    addParkImage(parkId); // Reload the images modal
                    alert('画像を削除しました');
                } else {
                    alert(data.message || '画像を削除できませんでした');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('エラーが発生しました: ' + error.message);
            });
    }
}

function closeImageModal() {
    document.body.style.overflow = '';
    const modal = document.getElementById('parkImagesModal');
    if (modal) {
        modal.remove();
    }
}

function showComments(parkId) {
    fetch(`../functions/comment.php?parkId=${parkId}`)
        .then(response => {
            return response.json();
        })
        .then(comments => {
            const modal = `
                <div class="modal" id="commentsModal">
                    <div class="modal-content">
                        <h2>コメント管理</h2>
                        <div class="comments-container">
                            ${comments && comments.length > 0 ? comments.map(comment => `
                                <div class="comment-item" data-comment-id="${comment.id}">
                                    <div class="comment-content">
                                        <strong>${comment.user_name}</strong>
                                        <span class="comment-date">${new Date(comment.created_at).toLocaleString('ja-JP')}</span>
                                        <p>${comment.content}</p>
                                    </div>
                                    <button class="delete-comment-btn" onclick="deleteComment(${comment.id}, '${comment.user_email}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            `).join('') : '<p>コメントはまだありません</p>'}
                        </div>
                        <div class="modal-buttons">
                            <button onclick="closeCommentsModal()">閉じる</button>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modal);
        })
        .catch(error => {
            console.error('Error fetching comments:', error); // Debug log
        });
}

function closeCommentsModal() {
    const modal = document.getElementById('commentsModal');
    if (modal) {
        modal.remove();
    }
}

function deleteComment(commentId, userEmail) {

    if (confirm('このコメントを削除しますか？')) {
        const data = new URLSearchParams();
        data.append('commentId', commentId);
        data.append('email', userEmail);

        fetch('../functions/comment.php', {
            method: 'DELETE',
            body: data
        })
            .then(response => {
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('JSON parse error:', e); // Debug log
                        throw new Error('Invalid JSON response');
                    }
                });
            })
            .then(data => {
                if (data.success) {
                    const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
                    if (commentElement) {
                        commentElement.remove();
                    }
                    alert('コメントを削除しました');
                } else {
                    alert('コメントを削除できませんでした: ' + (data.message || '不明なエラー'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('エラーが発生しました');
            });
    }
}

function loadDashboard() {
    const dashboardSection = document.getElementById('dashboard-section');

    const html = `
        <div class="dashboard-wrapper">
            <!-- First row with Traffic Analysis and Stats -->
            <div class="dashboard-row top-row">
                <!-- Traffic Analysis Chart -->
                <div class="dashboard-card traffic-chart">
                    <div class="card-header">
                        <h3>Traffic Analysis</h3>
                        <div class="period-selector">
                            <button class="period-btn" data-period="24hours">24H</button>
                            <button class="period-btn active" data-period="7days">7D</button>
                            <button class="period-btn" data-period="30days">30D</button>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="trafficChart"></canvas>
                    </div>
                </div>

                <!-- Stats Column -->
                <div class="stats-column">
                    <!-- Traffic Overview Card -->
                    <div class="dashboard-card">
                        <h3>Traffic Overview</h3>
                        <div class="stats-grid">
                            <div class="stat-item">
                                <span class="stat-label">Total Visits</span>
                                <span class="stat-value" id="totalVisits">-</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Unique Visitors</span>
                                <span class="stat-value" id="uniqueVisitors">-</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Logged Users</span>
                                <span class="stat-value" id="loggedInUsers">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Device Distribution Card -->
                    <div class="dashboard-card">
                        <h3>デバイス 割合</h3>
                        <div class="device-stats">
                            <div class="device-chart">
                                <canvas id="deviceChart"></canvas>
                            </div>
                            <div class="device-legend">
                                <div class="legend-item">
                                    <span class="legend-color" style="background-color: #2ecc71"></span>
                                    <span class="legend-text" id="desktopLegend">Desktop 0%</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-color" style="background-color: #3498db"></span>
                                    <span class="legend-text" id="mobileLegend">Mobile 0%</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-color" style="background-color: #e74c3c"></span>
                                    <span class="legend-text" id="tabletLegend">Tablet 0%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second row with 3 cards -->
            <div class="dashboard-row">
                <div class="dashboard-card">
                    <h3>満足度</h3>
                    <div class="satisfaction-chart">
                        <canvas id="satisfactionChart"></canvas>
                    </div>
                </div>
                <div class="dashboard-card">
                    <h3>保存された公園</h3>
                    <div id="popularParks" class="breakdown-list"></div>
                </div>
                <div class="dashboard-card">
                    <h3>保存されたイベント</h3>
                    <div id="popularEvents" class="breakdown-list"></div>
                </div>
            </div>

            <!-- Third row with 3 cards -->
            <div class="dashboard-row">
                <div class="dashboard-card">
                    <h3>Popular Pages</h3>
                    <div id="pageBreakdown" class="breakdown-list"></div>
                </div>
                <div class="dashboard-card">
                    <h3>Top Visitors</h3>
                    <div id="topVisitors" class="breakdown-list"></div>
                </div>
            </div>
        </div>
    `;

    dashboardSection.innerHTML = html;

    // Initialize charts
    initTrafficChart();
    initDeviceChart();
    initSatisfactionChart();

    // Load all data
    loadTrafficData('7days');
    loadPopularParks();
    loadPopularEvents();

    // Add event listeners to period buttons
    document.querySelectorAll('.period-btn').forEach(button => {
        button.addEventListener('click', function () {
            document.querySelectorAll('.period-btn').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            loadTrafficData(this.dataset.period);
        });
    });
}

function loadPopularParks() {
    fetch('../admin/functions/get_parks_likes.php')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('popularParks');
            let html = '';
            data.forEach(park => {
                html += `
                    <div class="breakdown-item">
                        <span class="breakdown-label">${park.name}</span>
                        <span class="breakdown-value">${park.likes_count}</span>
                    </div>
                `;
            });
            container.innerHTML = html;
        })
        .catch(error => console.error('Error loading popular parks:', error));
}

function loadPopularEvents() {
    fetch('../admin/functions/get_events_saved.php')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('popularEvents');
            let html = '';
            data.forEach(event => {
                html += `
                    <div class="breakdown-item">
                        <span class="breakdown-label">${event.name}</span>
                        <span class="breakdown-value">${event.saves_count}</span>
                    </div>
                `;
            });
            container.innerHTML = html;
        })
        .catch(error => console.error('Error loading popular events:', error));
}

function initTrafficChart() {
    const ctx = document.getElementById('trafficChart').getContext('2d');
    window.trafficChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Total Visits',
                data: [],
                borderColor: '#2ecc71',
                backgroundColor: 'rgba(46, 204, 113, 0.1)',
                tension: 0.3,
                fill: true
            }, {
                label: 'Unique Visitors',
                data: [],
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2.5, // Điều chỉnh tỷ lệ chart
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

function loadTrafficData(period) {
    fetch('../admin/functions/get_traffic_data.php?period=' + period)
        .then(response => response.json())
        .then(data => {
            updateTrafficChart(data.chartData);
            updateTrafficStats(data.summary);
            updatePageBreakdown(data.pageBreakdown);
            updateTopVisitors(data.topVisitors);
            updateDeviceChart(data.summary);
        })
        .catch(error => console.error('Error loading traffic data:', error));
}

function updateTrafficChart(chartData) {
    window.trafficChart.data.labels = chartData.map(item => item.time_period);
    window.trafficChart.data.datasets[0].data = chartData.map(item => item.visit_count);
    window.trafficChart.data.datasets[1].data = chartData.map(item => item.unique_visitors);
    window.trafficChart.update();
}

function updateTrafficStats(stats) {
    document.getElementById('totalVisits').textContent = stats.total_visits;
    document.getElementById('uniqueVisitors').textContent = stats.unique_visitors;
    document.getElementById('loggedInUsers').textContent = stats.logged_in_users;

    // Update device distribution
    updateDeviceStats(stats);
}

function initDeviceChart() {
    const ctx = document.getElementById('deviceChart').getContext('2d');
    window.deviceChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Desktop', 'Mobile', 'Tablet'],
            datasets: [{
                data: [0, 0, 0], // Will be updated with real data
                backgroundColor: [
                    '#2ecc71', // Desktop - Green
                    '#3498db', // Mobile - Blue
                    '#e74c3c'  // Tablet - Red
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // Hide default legend
                }
            },
            cutout: '60%'
        }
    });
}

function updateDeviceStats(stats) {
    // Calculate percentages
    const total = stats.desktop_visits + stats.mobile_visits + stats.tablet_visits;
    const desktopPercent = ((stats.desktop_visits / total) * 100).toFixed(1);
    const mobilePercent = ((stats.mobile_visits / total) * 100).toFixed(1);
    const tabletPercent = ((stats.tablet_visits / total) * 100).toFixed(1);

    // Update chart data
    window.deviceChart.data.datasets[0].data = [
        stats.desktop_visits,
        stats.mobile_visits,
        stats.tablet_visits
    ];
    window.deviceChart.update();

    // Update legend text with both percentage and count
    document.getElementById('desktopLegend').textContent =
        `Desktop ${desktopPercent}% (${stats.desktop_visits})`;
    document.getElementById('mobileLegend').textContent =
        `Mobile ${mobilePercent}% (${stats.mobile_visits})`;
    document.getElementById('tabletLegend').textContent =
        `Tablet ${tabletPercent}% (${stats.tablet_visits})`;
}

function updatePageBreakdown(pageStats) {
    const container = document.getElementById('pageBreakdown');
    let html = '';
    pageStats.forEach(page => {
        html += `
            <div class="breakdown-item">
                <span class="breakdown-label">${page.page_name}</span>
                <span class="breakdown-value">${page.visit_count}</span>
            </div>
        `;
    });
    container.innerHTML = html;
}

function updateTopVisitors(visitors) {
    const container = document.getElementById('topVisitors');
    let html = '';
    visitors.forEach(visitor => {
        html += `
            <div class="breakdown-item">
                <span class="breakdown-label">${visitor.visitor}</span>
                <span class="breakdown-value">${visitor.visit_count}</span>
            </div>
        `;
    });
    container.innerHTML = html;
}

function filterUsers() {
    const input = document.getElementById('userSearch');
    const filter = input.value.toLowerCase();
    const tbody = document.getElementById('userTableBody');
    const rows = tbody.getElementsByTagName('tr');

    let hasVisibleRows = false;

    // Add special filter conditions for role and status
    const isAdminFilter = filter.includes('admin');
    const isUserFilter = filter.includes('user');
    const isActiveFilter = filter.includes('active');
    const isBannedFilter = filter.includes('banned');
    const searchText = filter
        .replace('admin', '')
        .replace('user', '')
        .replace('active', '')
        .replace('banned', '')
        .trim();

    for (let row of rows) {
        // Skip the "no results" row if it exists
        if (row.classList.contains('no-results-row')) {
            row.remove();
            continue;
        }

        const name = row.getElementsByTagName('td')[1].textContent;
        const email = row.getElementsByTagName('td')[2].textContent;
        const phone = row.getElementsByTagName('td')[3].textContent;
        const address = row.getElementsByTagName('td')[4].textContent;
        const role = row.dataset.role; // Add data-role attribute to tr elements
        const status = row.dataset.status; // Add data-status attribute to tr elements

        // Check filter conditions
        const matchesText = !searchText || 
            name.toLowerCase().includes(searchText) ||
            email.toLowerCase().includes(searchText) ||
            phone.toLowerCase().includes(searchText) ||
            address.toLowerCase().includes(searchText);
        
        const matchesRole = (!isAdminFilter && !isUserFilter) || 
            (isAdminFilter && role === 'admin') ||
            (isUserFilter && role === 'user');

        const matchesStatus = (!isActiveFilter && !isBannedFilter) ||
            (isActiveFilter && status === 'active') ||
            (isBannedFilter && status === 'banned');

        // Show row only if all conditions match
        if (matchesText && matchesRole && matchesStatus) {
            row.style.display = '';
            hasVisibleRows = true;
        } else {
            row.style.display = 'none';
        }
    }

    // Show "no results" message if no matches found
    if (!hasVisibleRows) {
        const noResultsRow = document.createElement('tr');
        noResultsRow.classList.add('no-results-row');
        noResultsRow.innerHTML = `
            <td colspan="7" style="text-align: center;">
                検索結果はありません
            </td>
        `;
        tbody.appendChild(noResultsRow);
    }
}

function filterParks() {
    const input = document.getElementById('parkSearch');
    const filter = input.value.toLowerCase();
    const tbody = document.getElementById('parkTableBody');
    const rows = tbody.getElementsByTagName('tr');

    let hasVisibleRows = false;

    for (let row of rows) {
        // Skip the "no results" row if it exists
        if (row.classList.contains('no-results-row')) {
            row.remove();
            continue;
        }

        const name = row.getElementsByTagName('td')[2].textContent;
        const location = row.getElementsByTagName('td')[3].textContent;
        const nearest = row.getElementsByTagName('td')[6].textContent;
        const special = row.getElementsByTagName('td')[7].textContent;

        if (name.toLowerCase().includes(filter) ||
            location.toLowerCase().includes(filter) ||
            nearest.toLowerCase().includes(filter) ||
            special.toLowerCase().includes(filter)) {
            row.style.display = '';
            hasVisibleRows = true;
        } else {
            row.style.display = 'none';
        }
    }

    // 検索結果がない場合のメッセージを表示
    if (!hasVisibleRows) {
        const noResultsRow = document.createElement('tr');
        noResultsRow.classList.add('no-results-row');
        noResultsRow.innerHTML = `
            <td colspan="10" style="text-align: center;">
                検索結果はありません
            </td>
        `;
        tbody.appendChild(noResultsRow);
    }
}

function filterEvents() {
    const input = document.getElementById('eventSearch');
    const filter = input.value.toLowerCase();
    const tbody = document.getElementById('eventTableBody');
    const rows = tbody.getElementsByTagName('tr');

    let hasVisibleRows = false;

    for (let row of rows) {
        // Skip the "no results" row if it exists
        if (row.classList.contains('no-results-row')) {
            row.remove();
            continue;
        }

        const name = row.getElementsByTagName('td')[2].textContent;
        const location = row.getElementsByTagName('td')[3].textContent;
        const date = row.getElementsByTagName('td')[4].textContent;
        const description = row.getElementsByTagName('td')[7].textContent;

        if (name.toLowerCase().includes(filter) ||
            location.toLowerCase().includes(filter) ||
            date.toLowerCase().includes(filter) ||
            description.toLowerCase().includes(filter)) {
            row.style.display = '';
            hasVisibleRows = true;
        } else {
            row.style.display = 'none';
        }
    }

    // 検索結果がない場合のメッセージを表示
    if (!hasVisibleRows) {
        const noResultsRow = document.createElement('tr');
        noResultsRow.classList.add('no-results-row');
        noResultsRow.innerHTML = `
            <td colspan="9" style="text-align: center;">
                検索結果はありません
            </td>
        `;
        tbody.appendChild(noResultsRow);
    }
}

function loadFeedbacks() {
    fetch('functions/get_feedbacks.php')
        .then(response => response.json())
        .then(response => {
            console.log('Feedback response:', response);

            const feedbacks = response.data || [];
            const feedbacksSection = document.getElementById('feedbacks-section');

            let html = `
                <div class="events-header">
                    <h2>Feedback Management</h2>
                    <div class="header-controls">
                        <input type="text" id="feedbackSearch" placeholder="フィードバックを検索..." onkeyup="filterFeedbacks()">
                    </div>
                </div>
                <table class="feedback-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>UI/UX評価</th>
                            <th>コンテンツ評価</th>
                            <th>総合評価</th>
                            <th>フィードバック内容</th>
                            <th>日付</th>
                            <th>ステータス</th>
                            <th>アクション</th>
                        </tr>
                    </thead>
                    <tbody id="feedbackTableBody">
            `;

            if (response.status === 'error') {
                html += `
                    <tr>
                        <td colspan="9" style="text-align: center; color: red;">
                            エラーが発生しました: ${response.message}
                        </td>
                    </tr>
                `;
            } else if (feedbacks.length === 0) {
                html += `
                    <tr>
                        <td colspan="9" style="text-align: center;">
                            フィードバックはまだありません
                        </td>
                    </tr>
                `;
            } else {
                feedbacks.forEach(feedback => {
                    const createdAt = new Date(feedback.created_at).toLocaleString('ja-JP');
                    const truncatedContent = feedback.feedback_content.length > 50 ?
                        `${feedback.feedback_content.substring(0, 50)}...` :
                        feedback.feedback_content;

                    html += `
                        <tr data-id="${feedback.id}" class="${feedback.is_important ? 'important' : ''} ${feedback.is_read ? 'read' : ''}">
                            <td>${feedback.id}</td>
                            <td>${feedback.email}</td>
                            <td>${feedback.uiux}/5</td>
                            <td>${feedback.content_rating}/5</td>
                            <td>${feedback.overall}/5</td>
                            <td class="feedback-content-cell">
                                <div class="feedback-content-truncated">${truncatedContent}</div>
                                <div class="feedback-content-full">${feedback.feedback_content}</div>
                                <button class="expand-btn">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </td>
                            <td>${createdAt}</td>
                            <td>
                                <div class="status-toggles">
                                    <label class="toggle">
                                        <input type="checkbox" 
                                               onchange="updateFeedbackStatus(${feedback.id}, 'is_read', this.checked)"
                                               ${feedback.is_read ? 'checked' : ''}>
                                        既読
                                    </label>
                                    <label class="toggle">
                                        <input type="checkbox" 
                                               onchange="updateFeedbackStatus(${feedback.id}, 'is_important', this.checked)"
                                               ${feedback.is_important ? 'checked' : ''}>
                                        重要
                                    </label>
                                </div>
                            </td>
                            <td>
                                <button onclick="deleteFeedback(${feedback.id})" class="delete-btn">
                                    <i class="fas fa-trash"></i> 削除
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }

            html += `</tbody></table>`;
            feedbacksSection.innerHTML = html;

            // Add event listeners for expand buttons after table is loaded
            document.querySelectorAll('.expand-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const cell = this.closest('.feedback-content-cell');
                    cell.classList.toggle('expanded');

                    // Change icon based on expanded state
                    const icon = this.querySelector('i');
                    if (cell.classList.contains('expanded')) {
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                    } else {
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    }
                });
            });
        })
        .catch(error => {
            console.error('Error loading feedbacks:', error);
            const feedbacksSection = document.getElementById('feedbacks-section');
            feedbacksSection.innerHTML = `
                <div class="error-message">
                    フィードバックの読み込み中にエラーが発生しました。<br>
                    エラー詳細: ${error.message}
                </div>
            `;
        });
}

function updateFeedbackStatus(id, field, value) {
    fetch('functions/update_feedback_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id, field, value })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = document.querySelector(`tr[data-id="${id}"]`);
                if (row) {
                    if (field === 'is_important') {
                        if (value) {
                            row.classList.add('important');
                        } else {
                            row.classList.remove('important');
                        }
                    } else if (field === 'is_read') {
                        if (value) {
                            row.classList.add('read');
                        } else {
                            row.classList.remove('read');
                        }
                    }
                }
            } else {
                // Nếu update thất bại, revert lại checkbox
                const checkbox = document.querySelector(`tr[data-id="${id}"] input[type="checkbox"][onchange*="${field}"]`);
                if (checkbox) {
                    checkbox.checked = !value;
                }
                alert('ステータスの更新に失敗しました');
            }
        })
        .catch(error => {
            console.error('Error updating status:', error);
            // Revert checkbox nếu có lỗi
            const checkbox = document.querySelector(`tr[data-id="${id}"] input[type="checkbox"][onchange*="${field}"]`);
            if (checkbox) {
                checkbox.checked = !value;
            }
            alert('エラーが発生しました');
        });
}

function deleteFeedback(id) {
    if (confirm('このフィードバックを削除しますか？')) {
        fetch('functions/delete_feedback.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadFeedbacks();
                    alert('フィードバックを削除しました');
                }
            });
    }
}

function filterFeedbacks() {
    const input = document.getElementById('feedbackSearch');
    const filter = input.value.toLowerCase();
    const tbody = document.getElementById('feedbackTableBody');
    const rows = tbody.getElementsByTagName('tr');

    let hasVisibleRows = false;

    // 検索キーワードに対する特別なフィルター条件を追加
    const isReadFilter = filter.includes('既読');
    const isImportantFilter = filter.includes('重要');
    const searchText = filter
        .replace('既読', '')
        .replace('重要', '')
        .trim();

    for (let row of rows) {
        // Skip the "no results" row if it exists
        if (row.classList.contains('no-results-row')) {
            row.remove();
            continue;
        }

        const email = row.cells[1]?.textContent;
        const content = row.cells[4]?.textContent;
        const isRead = row.classList.contains('read');
        const isImportant = row.classList.contains('important');

        // フィルター条件をチェック
        const matchesText = !searchText || 
            email?.toLowerCase().includes(searchText) ||
            content?.toLowerCase().includes(searchText);
        
        const matchesRead = !isReadFilter || isRead;
        const matchesImportant = !isImportantFilter || isImportant;

        // すべての条件に一致する場合のみ表示
        if (matchesText && matchesRead && matchesImportant) {
            row.style.display = '';
            hasVisibleRows = true;
        } else {
            row.style.display = 'none';
        }
    }

    // 検索結果がない場合のメッセージを表示
    if (!hasVisibleRows) {
        const noResultsRow = document.createElement('tr');
        noResultsRow.classList.add('no-results-row');
        noResultsRow.innerHTML = `
            <td colspan="9" style="text-align: center;">
                検索結果はありません
            </td>
        `;
        tbody.appendChild(noResultsRow);
    }
}

function loadFeedbackData() {
    fetch('functions/get_feedback_stats.php')
        .then(response => response.json())
        .then(data => {
            console.log('Feedback data received:', data);
            updateSatisfactionChart(data);
        })
        .catch(error => console.error('Error loading feedback data:', error));
}

function updateSatisfactionChart(data) {
    const chart = window.satisfactionChart;
    if (!chart) return;

    // Convert 1-5 scale to percentage (0-100%)
    const uiuxPercent = (data.averages.uiux / 5) * 100;
    const contentPercent = (data.averages.content / 5) * 100;
    const overallPercent = (data.averages.overall / 5) * 100;

    chart.data.datasets[0].data = [
        uiuxPercent,
        contentPercent,
        overallPercent
    ];

    chart.update();
}

function initSatisfactionChart() {
    const ctx = document.getElementById('satisfactionChart').getContext('2d');
    window.satisfactionChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['UI/UX', 'Content', 'Overall'],
            datasets: [{
                label: 'Satisfaction Rate',
                data: [0, 0, 0],
                backgroundColor: [
                    '#2ecc71',
                    '#3498db',
                    '#9b59b6'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function (value) {
                            return value + '%';
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return `Satisfaction: ${context.raw.toFixed(1)}%`;
                        }
                    }
                }
            }
        }
    });

    // Load data right after initialization
    fetch('functions/get_feedback_stats.php')
        .then(response => response.json())
        .then(data => {
            const uiuxPercent = (data.averages.uiux / 5) * 100;
            const contentPercent = (data.averages.content / 5) * 100;
            const overallPercent = (data.averages.overall / 5) * 100;

            window.satisfactionChart.data.datasets[0].data = [
                uiuxPercent,
                contentPercent,
                overallPercent
            ];
            window.satisfactionChart.update();
        });
}
