document.addEventListener("DOMContentLoaded", () => {
  const notifContainer = document.getElementById("notif-items");
  const notifDropdown = document.getElementById("notifDropdown");

  // Fetch notifications
  function loadNotifications() {
    fetch("php/get_notifications.php")
      .then(res => res.json())
      .then(data => {
        if (!notifContainer) return;

        if (!data.length) {
          notifContainer.innerHTML = `<div class="px-3 small text-muted">No notifications.</div>`;
          return;
        }

        notifContainer.innerHTML = "";
        data.forEach(item => {
          // Use bg-light for read, bg-secondary-subtle (or bg-dark) for unread
          const bgClass = item.read_by_user == 1 ? "bg-light" : "bg-secondary-subtle";
          notifContainer.innerHTML += `
            <div class="dropdown-item text-wrap small ${bgClass}">
              <strong>Admin replied:</strong><br>
              ${item.response}<br>
              <small class="text-muted">${new Date(item.responded_at).toLocaleString()}</small>
            </div>
            <hr class="my-1">
          `;
        });
      })
      .catch(error => console.error("Notification fetch error:", error));
  }

  // Load on page load
  loadNotifications();

  // Mark as read when dropdown is opened
  if (notifDropdown) {
    notifDropdown.addEventListener("click", () => {
      fetch("php/mark_notifications_read.php", { method: "POST" })
        .then(() => {
          loadNotifications();
        });
    });
  }
});