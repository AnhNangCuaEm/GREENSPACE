document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".delete-save-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const eventId = this.dataset.eventId;
      const eventCard = this.closest(".event-card");

      fetch("functions/eventsave.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `action=updateSave&eventId=${eventId}`,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            //Remove event card
            eventCard.remove();

            //If no events left, display message
            const eventsBox = document.querySelector(".saved-events-box");
            if (!eventsBox.querySelector(".event-card")) {
              eventsBox.innerHTML =
                '<p class="no-events-message">保存したイベントがありません。</p>';
            }
          }
        })
        .catch((error) => console.error("Error:", error));
    });
  });
});
