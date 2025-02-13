document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".delete-like-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const parkId = this.dataset.parkId;
      const parkCard = this.closest(".park-card");

      fetch("functions/parklike.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `action=updateLike&parkId=${parkId}`,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            parkCard.remove();

            const parksBox = document.querySelector(".liked-parks-box");
            if (!parksBox.querySelector(".park-card")) {
              parksBox.innerHTML =
                '<p class="no-parks-message">お気に入りの公園がありません。</p>';
            }
          }
        })
        .catch((error) => console.error("Error:", error));
    });
  });
});
