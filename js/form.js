document.getElementById('myForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]'); // Lấy nút submit

    submitButton.disabled = true; // Vô hiệu hóa nút submit trong khi gửi

    fetch('functions/getfeedback.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.text()) // Xử lý phản hồi dưới dạng văn bản
        .then(data => {
            const resultPopup = document.getElementById('result');
            resultPopup.innerHTML = data; // Hiển thị kết quả
            resultPopup.classList.add('slidedown'); // Thêm lớp để hiển thị animation

            // Đặt thời gian để ẩn popup sau 3 giây
            setTimeout(() => {
                resultPopup.classList.remove('slidedown'); // Xóa lớp slidedown
                resultPopup.classList.add('slideup'); // Thêm lớp để ẩn animation

                // Reset animation classes after slideup completes
                setTimeout(() => {
                    resultPopup.classList.remove('slideup'); // Xóa lớp slideup để có thể hiển thị lại
                }, 300); // Thời gian cần thiết để hoàn thành animation
            }, 4000); // 3 giây

            this.reset(); // Làm sạch form sau khi gửi
            submitButton.disabled = false; // Kích hoạt lại nút submit
        })
        .catch(error => {
            console.error('Error:', error);
            submitButton.disabled = false; // Kích hoạt lại nút submit nếu có lỗi
        });
});



