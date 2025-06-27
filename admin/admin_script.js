// Sidebar navigation logic
function showSection(sectionId) {
  document.querySelectorAll('.admin-section').forEach(sec => {
    sec.classList.add('d-none');
  });
  document.getElementById(sectionId).classList.remove('d-none');

  // Update active link
  document.querySelectorAll('#sidebar .nav-link').forEach(link => {
    link.classList.remove('active');
    if (link.getAttribute('href') === '#' + sectionId) {
      link.classList.add('active');
    }
  });
}

// Make showSection globally accessible
window.showSection = showSection;

// Manage BMI image preview
const foodImageInput = document.getElementById('foodImage');
const imgPreview = document.getElementById('imgPreview');

foodImageInput.addEventListener('change', () => {
  const file = foodImageInput.files[0];
  if (!file) {
    imgPreview.src = '';
    imgPreview.classList.add('d-none');
    return;
  }
  const reader = new FileReader();
  reader.onload = () => {
    imgPreview.src = reader.result;
    imgPreview.classList.remove('d-none');
  };
  reader.readAsDataURL(file);
});

// Feedback reply toggle and send (UI only)
document.querySelectorAll('.reply-btn').forEach(button => {
  button.addEventListener('click', () => {
    const replyBox = button.nextElementSibling;
    replyBox.classList.toggle('d-none');
  });
});

document.querySelectorAll('.send-reply-btn').forEach(button => {
  button.addEventListener('click', () => {
    Swal.fire('Sent!', 'Reply sent (UI only). Backend integration coming soon.', 'success');
    const replyBox = button.closest('.reply-box');
    replyBox.querySelector('textarea').value = '';
    replyBox.classList.add('d-none');
  });
});

// Fetch and render social links
function fetchSocialLinks() {
  fetch('../php/manage_social_links.php', {
    method: 'POST',
    body: new URLSearchParams({action: 'list'})
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      const tbody = document.getElementById('socialMediaTableBody');
      tbody.innerHTML = '';
      data.links.forEach((link, idx) => {
        tbody.innerHTML += `
          <tr>
            <td>${idx + 1}</td>
            <td>${link.platform}</td>
            <td><a href="${link.url}" target="_blank">${link.url}</a></td>
            <td class="table-actions">
              <button class="btn btn-sm btn-primary" onclick="editSocialLink(${link.id}, '${link.platform.replace(/'/g,"\\'")}', '${link.url.replace(/'/g,"\\'")}')"><i class="bi bi-pencil"></i></button>
              <button class="btn btn-sm btn-danger" onclick="deleteSocialLink(${link.id})"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
        `;
      });
    }
  });
}
fetchSocialLinks();

// Add new link
document.getElementById('socialMediaForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const platform = document.getElementById('platformName').value;
  const url = document.getElementById('platformURL').value;
  fetch('../php/manage_social_links.php', {
    method: 'POST',
    body: new URLSearchParams({action: 'add', platform, url})
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      Swal.fire('Success', 'Social media link added!', 'success');
      e.target.reset();
      fetchSocialLinks();
    } else {
      Swal.fire('Error', data.message || 'Failed to add link', 'error');
    }
  });
});

// Edit social link
window.editSocialLink = function(id, platform, url) {
  Swal.fire({
    title: 'Edit Platform',
    input: 'text',
    inputValue: platform,
    showCancelButton: true,
    confirmButtonText: 'Next',
    inputLabel: 'Platform'
  }).then((result) => {
    if (result.isConfirmed && result.value) {
      const newPlatform = result.value;
      Swal.fire({
        title: 'Edit URL',
        input: 'url',
        inputValue: url,
        showCancelButton: true,
        inputLabel: 'URL'
      }).then((result2) => {
        if (result2.isConfirmed && result2.value) {
          const newUrl = result2.value;
          fetch('../php/manage_social_links.php', {
            method: 'POST',
            body: new URLSearchParams({action: 'edit', id, platform: newPlatform, url: newUrl})
          })
          .then(r => r.json())
          .then(data => {
            if (data.success) {
              fetchSocialLinks();
              Swal.fire('Updated!', 'Social media link updated.', 'success');
            } else {
              Swal.fire('Error', data.message || 'Failed to edit link', 'error');
            }
          });
        }
      });
    }
  });
}

// Delete social link
window.deleteSocialLink = function(id) {
  Swal.fire({
    title: 'Are you sure?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes',
    cancelButtonText: 'No'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('../php/manage_social_links.php', {
        method: 'POST',
        body: new URLSearchParams({action: 'delete', id})
      })
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          fetchSocialLinks();
          Swal.fire('Deleted!', 'Social media link deleted.', 'success');
        } else {
          Swal.fire('Error', data.message || 'Failed to delete link', 'error');
        }
      });
    }
  });
}

// Fetch and render BMI recommendations
function fetchBMIRecommendations() {
  fetch('../php/manage_bmi.php', {
    method: 'POST',
    body: new URLSearchParams({action: 'list'})
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      const tbody = document.getElementById('recommendationsTableBody');
      tbody.innerHTML = '';
      data.recommendations.forEach((rec, idx) => {
        tbody.innerHTML += `
          <tr>
            <td>${idx + 1}</td>
            <td>${rec.category}</td>
            <td>${rec.food}</td>
            <td>${rec.calory} kcal</td>
            <td>${rec.image ? `<img src="../${rec.image}" style="max-width:100px; border-radius:6px;" />` : ''}</td>
            <td>${rec.exercise}</td>
            <td class="table-actions">
              <button class="btn btn-sm btn-danger" onclick="deleteBMIRecommendation(${rec.id})"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
        `;
      });
    }
  });
}
fetchBMIRecommendations();

// Add new BMI recommendation with image upload
document.getElementById('bmiForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const category = document.getElementById('bmiCategory').value;
  const food = document.getElementById('foodName').value;
  const calory = document.getElementById('calory').value;
  const exercise = document.getElementById('exercise').value;
  const imageInput = document.getElementById('foodImage');
  const formData = new FormData();
  formData.append('action', 'add');
  formData.append('category', category);
  formData.append('food', food);
  formData.append('calory', calory); 
  formData.append('exercise', exercise);
  if (imageInput.files[0]) {
    formData.append('image', imageInput.files[0]);
  }

  fetch('../php/manage_bmi.php', {
    method: 'POST',
    body: formData
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      Swal.fire('Success', 'Recommendation added!', 'success');
      e.target.reset();
      imgPreview.src = '';
      imgPreview.classList.add('d-none');
      fetchBMIRecommendations();
    } else {
      Swal.fire('Error', data.message || 'Failed to add recommendation', 'error');
    }
  });
});

// Delete BMI recommendation
window.deleteBMIRecommendation = function(id) {
  Swal.fire({
    title: 'Delete this recommendation?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes',
    cancelButtonText: 'No'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('../php/manage_bmi.php', {
        method: 'POST',
        body: new URLSearchParams({action: 'delete', id})
      })
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          fetchBMIRecommendations();
          Swal.fire('Deleted!', 'Recommendation deleted.', 'success');
        } else {
          Swal.fire('Error', data.message || 'Failed to delete', 'error');
        }
      });
    }
  });
}

// Toggle sidebar
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('active');
}
window.toggleSidebar = toggleSidebar;