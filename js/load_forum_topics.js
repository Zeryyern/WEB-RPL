document.addEventListener("DOMContentLoaded", () => {
  fetch("php/get_topics.php")
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById("forumTopicsBody");
      tbody.innerHTML = "";

      data.forEach(topic => {
        tbody.innerHTML += `
          <tr>
            <td class="text-center">
              <span class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                <i class="bi bi-chat-dots fs-4 text-primary"></i>
              </span>
            </td>
            <td>
              <h5 class="mb-1">
                <a href="php/forum_topic.php?id=${topic.id}" class="text-decoration-none text-dark fw-semibold">
                  ${topic.title}
                </a>
              </h5>
              <div class="text-muted small">${topic.description}</div>
            </td>
            <td class="text-center d-none d-sm-table-cell"><span class="badge rounded-pill bg-secondary">0</span></td>
            <td class="text-center d-none d-sm-table-cell"><span class="badge rounded-pill bg-secondary">0</span></td>
            <td class="d-none d-md-table-cell">
              <div class="d-flex align-items-center gap-2">
                <div>No replies yet</div>
              </div>
            </td>
          </tr>
        `;
      });
    });
});
