document.getElementById('myForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');

    submitButton.disabled = true;

    fetch('functions/getfeedback.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.text())
        .then(data => {
            const resultPopup = document.getElementById('result');
            resultPopup.innerHTML = data;
            resultPopup.classList.add('slidedown');

            //Set timeout to hide popup after 3 seconds
            setTimeout(() => {
                resultPopup.classList.remove('slidedown');
                resultPopup.classList.add('slideup');

                // Reset animation classes after slideup completes
                setTimeout(() => {
                    resultPopup.classList.remove('slideup');
                    resultPopup.innerHTML = ''; // Clear the content
                }, 300);
            }, 4000);

            this.reset();
            submitButton.disabled = false;
        })
        .catch(error => {
            console.error('Error:', error);
            submitButton.disabled = false;
        });
});



