document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.save-button').forEach(button => {
        button.addEventListener('click', function() {
            const eventId = this.dataset.eventId;
            const saveIcon = this.querySelector('.save-icon');
            const saveText = this.querySelector('.save-text');
            const isCurrentlySaved = saveText.textContent === '保存を削除';

            fetch('functions/eventsave.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=updateSave&eventId=${eventId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update text
                    saveText.textContent = data.isSaved ? '保存を削除' : '保存する';
                    
                    // Update icon
                    if (data.isSaved) {
                        saveIcon.innerHTML = `<g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M16 8.98987V20.3499C16 21.7999 14.96 22.4099 13.69 21.7099L9.76001 19.5199C9.34001 19.2899 8.65999 19.2899 8.23999 19.5199L4.31 21.7099C3.04 22.4099 2 21.7999 2 20.3499V8.98987C2 7.27987 3.39999 5.87988 5.10999 5.87988H12.89C14.6 5.87988 16 7.27987 16 8.98987Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path opacity="0.4" d="M22 5.10999V16.47C22 17.92 20.96 18.53 19.69 17.83L16 15.77V8.98999C16 7.27999 14.6 5.88 12.89 5.88H8V5.10999C8 3.39999 9.39999 2 11.11 2H18.89C20.6 2 22 3.39999 22 5.10999Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path opacity="0.4" d="M7 12H11" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g>`;
                    } else {
                        saveIcon.innerHTML = `<g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16 8.98987V20.3499C16 21.7999 14.96 22.4099 13.69 21.7099L9.76001 19.5199C9.34001 19.2899 8.65999 19.2899 8.23999 19.5199L4.31 21.7099C3.04 22.4099 2 21.7999 2 20.3499V8.98987C2 7.27987 3.39999 5.87988 5.10999 5.87988H12.89C14.6 5.87988 16 7.27987 16 8.98987Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path opacity="0.4" d="M22 5.10999V16.47C22 17.92 20.96 18.53 19.69 17.83L16 15.77V8.98999C16 7.27999 14.6 5.88 12.89 5.88H8V5.10999C8 3.39999 9.39999 2 11.11 2H18.89C20.6 2 22 3.39999 22 5.10999Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><g opacity="0.4"><path d="M7 12H11" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M9 14V10" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></g></g>`;
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});