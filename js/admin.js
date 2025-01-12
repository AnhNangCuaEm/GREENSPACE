document.addEventListener('DOMContentLoaded', function() {
    // Load initial content (users section)
    loadUsers();

    // Add click handlers to navigation buttons
    document.querySelectorAll('.nav-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons and sections
            document.querySelectorAll('.nav-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.content-section').forEach(section => section.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
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
                    <tr data-status="${user.status}">
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
            alert('User role updated successfully');
        } else {
            alert('Error updating user role');
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
            alert('User status updated successfully');
        } else {
            alert('Error updating user status');
        }
    });
}

// Placeholder functions for parks and events
function loadParks() {
    document.getElementById('parks-section').innerHTML = '<h2>Park Management Coming Soon</h2>';
}

function loadEvents() {
    document.getElementById('events-section').innerHTML = '<h2>Event Management Coming Soon</h2>';
}
