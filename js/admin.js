document.addEventListener('DOMContentLoaded', function() {
    // Get active section from localStorage, default to 'users' if none saved
    const activeSection = localStorage.getItem('activeSection') || 'users';
    
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
        switch(activeSection) {
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

    // Add click handlers to navigation buttons
    document.querySelectorAll('.nav-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Skip if this is the "Back to Profile" button
            if (!this.dataset.section) return;
            
            // Remove active class from all buttons and sections
            document.querySelectorAll('.nav-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.content-section').forEach(section => section.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Save active section to localStorage
            localStorage.setItem('activeSection', this.dataset.section);
            
            // Show corresponding section
            const sectionId = this.dataset.section + '-section';
            document.getElementById(sectionId).classList.add('active');
            
            // Load content based on section
            switch(this.dataset.section) {
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
                            <th>img</th>
                            <th>公園名</th>
                            <th>場所</th>
                            <th>面積</th>
                            <th>料金</th>
                            <th>最寄り駅</th>
                            <th>特徴</th>
                            <th>説明</th>
                            <th>アクション</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            parks.forEach(park => {
                html += `
                    <tr>
                        <td><img src="${park.thumbnail}" alt="Park thumbnail" width="50" height="50" style="object-fit: cover;"></td>
                        <td>${park.name}</td>
                        <td>${park.location}</td>
                        <td>${park.area || 'N/A'}</td>
                        <td>${park.price}</td>
                        <td>${park.nearest}</td>
                        <td>${park.special}</td>
                        <td>${park.description ? park.description.substring(0, 50) + '...' : 'No description'}</td>
                        <td>
                            <button onclick="showParkDetails(${park.id})" class="details-btn">詳細</button>
                            <button onclick="editPark(${park.id})" class="edit-btn">編集</button>
                            <button onclick="deletePark(${park.id})" class="delete-btn">削除</button>
                            <button onclick="addParkImage(${park.id})" class="add-image-btn">写真追加</button>
                        </td>
                    </tr>
                `;
            });
            
            html += `</tbody></table>`;
            parksSection.innerHTML = html;
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
                        <input type="url" name="thumbnail" placeholder="サムネイルURL" required>
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
    
    document.getElementById('parkForm').addEventListener('submit', function(e) {
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
    
    document.getElementById('parkForm').addEventListener('submit', function(e) {
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
                alert('公園を削除できませんでした');
            }
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
                            <th>Thumb</th>
                            <th>イベント名</th>
                            <th>場所</th>
                            <th>日付</th>
                            <th>時間</th>
                            <th>料金</th>
                            <th>説明</th>
                            <th>アクション</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            events.forEach(event => {
                html += `
                    <tr>
                        <td><img src="${event.thumbnail}" alt="Event thumbnail" width="50" height="50" style="object-fit: cover;"></td>
                        <td>${event.name}</td>
                        <td>${event.location}</td>
                        <td>${event.date}</td>
                        <td>${event.time}</td>
                        <td>${event.price}</td>
                        <td>${event.description.substring(0, 50)}...</td>
                        <td>
                            <button onclick="editEvent(${event.id})" class="edit-btn">編集</button>
                            <button onclick="deleteEvent(${event.id})" class="delete-btn">削除</button>
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
    
    document.getElementById('eventForm').addEventListener('submit', function(e) {
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
    
    document.getElementById('eventForm').addEventListener('submit', function(e) {
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
                                <h3>Park Name</h3>
                                <p>漢字: ${park.name}</p>
                                <p>よみがな: ${park.name_yomi || 'Not available'}</p>
                                <p>ローマ字: ${park.name_romaji || 'Not available'}</p>
                            </div>

                            <div class="details-section">
                                <h3>Location</h3>
                                <p>漢字: ${park.location}</p>
                                <p>よみがな: ${park.location_yomi || 'Not available'}</p>
                                <p>ローマ字: ${park.location_romaji || 'Not available'}</p>
                            </div>

                            <div class="details-section">
                                <h3>Park Features</h3>
                                <p>${park.parkfeature || 'No features available'}</p>
                            </div>

                            <div class="details-section">
                                <h3>Full Description</h3>
                                <p>${park.description || 'No description available'}</p>
                            </div>

                            <div class="details-section">
                                <h3>Map</h3>
                                <div class="map-container">
                                    ${park.map || 'No map available'}
                                </div>
                            </div>
                            
                            <div class="details-section">
                                <h3>Images</h3>
                                <div class="park-images">
                                    ${park.images ? park.images.map(imageUrl => 
                                        `<img src="${imageUrl}" alt="Park image" width="150">`
                                    ).join('') : 'No images available'}
                                </div>
                            </div>

                            <div class="details-section">
                                <h3>Comments</h3>
                                <div class="comments-container">
                                    <!-- Add comments section here if needed -->
                                    <p>Comments feature coming soon...</p>
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
