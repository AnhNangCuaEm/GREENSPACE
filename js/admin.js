document.addEventListener('DOMContentLoaded', function() {
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
        }
    }

    // Add click event listeners to nav buttons
    document.querySelectorAll('.nav-btn').forEach(button => {
        button.addEventListener('click', function() {
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
                    <tbody>
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
                    <button class="add-event-btn" onclick="showAddParkModal()">
                        <i class="fas fa-plus"></i> 新公園追加
                    </button>
                </div>
                <table class="events-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>img</th>
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
                    <tbody>
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
                    <button class="add-event-btn" onclick="showAddEventModal()">
                        <i class="fas fa-plus"></i> 新イベント追加
                    </button>
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
                    <tbody>
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
    console.log('Park ID:', parkId); // Debug log
    fetch(`../functions/comment.php?parkId=${parkId}`)
        .then(response => {
            console.log('Response:', response); // Debug log
            return response.json();
        })
        .then(comments => {
            console.log('Comments:', comments); // Debug log
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
    console.log('Attempting to delete comment:', { commentId, userEmail }); // Debug log

    if (confirm('このコメントを削除しますか？')) {
        const data = new URLSearchParams();
        data.append('commentId', commentId);
        data.append('email', userEmail);

        console.log('Request data:', data.toString()); // Debug log

        fetch('../functions/comment.php', {
            method: 'DELETE',
            body: data
        })
            .then(response => {
                console.log('Response status:', response.status); // Debug log
                return response.text().then(text => {
                    console.log('Raw response:', text); // Debug log
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('JSON parse error:', e); // Debug log
                        throw new Error('Invalid JSON response');
                    }
                });
            })
            .then(data => {
                console.log('Parsed response data:', data); // Debug log
                if (data.success) {
                    const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
                    console.log('Found comment element:', commentElement); // Debug log
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
            <!-- Traffic Analysis -->
            <div class="dashboard-row">
                <div class="dashboard-card">
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
            </div>

            <!-- Statistics Cards -->
            <div class="dashboard-row">
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

                <div class="dashboard-card">
                    <h3>Device Distribution</h3>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-label">Desktop</span>
                            <span class="stat-value" id="desktopVisits">-</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Mobile</span>
                            <span class="stat-value" id="mobileVisits">-</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Tablet</span>
                            <span class="stat-value" id="tabletVisits">-</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page and Visitor Stats -->
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

    // Initialize Chart.js
    initTrafficChart();

    // Load initial data
    loadTrafficData('7days');

    // Add event listeners to period buttons
    document.querySelectorAll('.period-btn').forEach(button => {
        button.addEventListener('click', function () {
            document.querySelectorAll('.period-btn').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            loadTrafficData(this.dataset.period);
        });
    });
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
    document.getElementById('desktopVisits').textContent = stats.desktop_visits;
    document.getElementById('mobileVisits').textContent = stats.mobile_visits;
    document.getElementById('tabletVisits').textContent = stats.tablet_visits;
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
