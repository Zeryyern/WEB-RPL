console.log("Forum topic management script loaded");

document.addEventListener("DOMContentLoaded", () => {
  loadTopics();

  document.getElementById("forumForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const title = document.getElementById("forumTopic").value.trim();
    const description = document.getElementById("forumDescription").value.trim();

    fetch("../php/add_topic.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}`
    })
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      this.reset();
      loadTopics();
    });
  });
});

function loadTopics() {
  fetch("../php/fetch_topics.php")
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById("forumTableBody");
      tbody.innerHTML = "";
      data.forEach((topic, index) => {
        tbody.innerHTML += `
          <tr>
            <td>${index + 1}</td>
            <td>${topic.title}</td>
            <td>${topic.description}</td>
            <td>
              <button class="btn btn-sm btn-primary me-2" onclick="editTopic(${topic.id}, '${topic.title.replace(/'/g, "\\'")}', '${topic.description.replace(/'/g, "\\'")}')">
                <i class="bi bi-pencil"></i>
              </button>
              <button class="btn btn-sm btn-danger" onclick="deleteTopic(${topic.id})">
                <i class="bi bi-trash"></i>
              </button>
            </td>
          </tr>
        `;
      });
    });
}

function editTopic(id, title, description) {
  const newTitle = prompt("Edit topic title:", title);
  const newDesc = prompt("Edit description:", description);

  if (newTitle && newDesc) {
    fetch("../php/edit_topic.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `id=${id}&title=${encodeURIComponent(newTitle)}&description=${encodeURIComponent(newDesc)}`
    })
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      loadTopics();
    });
  }
}

function deleteTopic(id) {
  if (confirm("Are you sure you want to delete this topic?")) {
    fetch(`../php/delete_topic.php?id=${id}`, { method: "GET" })
      .then(res => res.text())
      .then(msg => {
        alert(msg);
        loadTopics();
      });
  }
}