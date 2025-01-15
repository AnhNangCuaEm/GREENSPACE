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
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Role</th>
                            <th>Status</th>
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

// Placeholder functions for parks and events
function loadParks() {
    document.getElementById('parks-section').innerHTML = '<h2>Park Management Coming Soon</h2>';
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
                        <i class="fas fa-plus"></i> Add New Event
                    </button>
                </div>
                <table class="events-table">
                    <thead>
                        <tr>
                            <th>Thumbnail</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Actions</th>
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
                            <button onclick="editEvent(${event.id})" class="edit-btn">Edit</button>
                            <button onclick="deleteEvent(${event.id})" class="delete-btn">Delete</button>
                        </td>
                    </tr>
                `;
            });
            
            html += `</tbody></table>`;
            eventsSection.innerHTML = html;
        });
}

function showAddEventModal() {
    const modal = `
        <div class="modal" id="eventModal">
            <div class="modal-content">
                <h2>Add New Event</h2>
                <form id="eventForm">
                    <input type="text" name="name" placeholder="Event Name" required>
                    <input type="text" name="location" placeholder="Location" required>
                    <input type="text" name="date" placeholder="Date" required>
                    <input type="text" name="time" placeholder="Time" required>
                    <input type="text" name="price" placeholder="Price" required>
                    <input type="url" name="thumbnail" placeholder="Thumbnail URL" required>
                    <textarea name="description" placeholder="Description" required></textarea>
                    <div class="modal-buttons">
                        <button type="submit">Save</button>
                        <button type="button" onclick="closeModal()">Cancel</button>
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
    const modal = `
        <div class="modal" id="eventModal">
            <div class="modal-content">
                <h2>Edit Event</h2>
                <form id="eventForm">
                    <input type="hidden" name="id" value="${event.id}">
                    <input type="text" name="name" value="${event.name}" placeholder="Event Name">
                    <input type="text" name="location" value="${event.location}" placeholder="Location">
                    <input type="text" name="date" value="${event.date}" placeholder="Date">
                    <input type="text" name="time" value="${event.time}" placeholder="Time">
                    <input type="text" name="price" value="${event.price}" placeholder="Price">
                    <input type="url" name="thumbnail" value="${event.thumbnail}" placeholder="Thumbnail URL">
                    <textarea name="description" placeholder="Description">${event.description}</textarea>
                    <div class="modal-buttons">
                        <button type="submit">Update</button>
                        <button type="button" onclick="closeModal()">Cancel</button>
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
    const modal = document.getElementById('eventModal');
    if (modal) {
        modal.remove();
    }
}
