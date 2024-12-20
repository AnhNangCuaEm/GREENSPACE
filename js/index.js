//tắt tạm trang loading lúc đang
//loading transition
// document.addEventListener("DOMContentLoaded", function () {
//    const loadingDiv = document.getElementById("loading");
//    const contentDiv = document.getElementById("content");

//    // Ẩn nội dung khi trang bắt đầu tải
//    contentDiv.style.display = "none";

//    // Bắt đầu thời gian tải tối thiểu
//    const minLoadTime = 1000; // 1 giây
//    const startTime = Date.now();

//    // Khi toàn bộ nội dung đã tải xong
//    window.onload = function () {
//       const elapsedTime = Date.now() - startTime;
//       const remainingTime = minLoadTime - elapsedTime;

//       // Đảm bảo loading hiển thị tối thiểu 1 giây
//       setTimeout(() => {
//          // Ẩn div loading
//          loadingDiv.style.display = "none";

//          // Hiển thị nội dung chính
//          contentDiv.style.display = "block";
//       }, Math.max(remainingTime, 0));
//    };
// });
//loading transition


document.addEventListener("DOMContentLoaded", () => {
   const parkContainer = document.querySelector(".park-container");
   const viewMoreBtn = document.querySelector(".view-more-btn");

   viewMoreBtn.addEventListener("click", () => {
      parkContainer.classList.toggle("expanded");
      parkContainer.style.transition = "max-height 0.8s ease-in-out";
      viewMoreBtn.textContent = parkContainer.classList.contains("expanded")
         ? "閉じる"
         : "もっと見る";

         if (parkContainer.classList.contains("expanded")) {
            parkContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
         }
   });
});
