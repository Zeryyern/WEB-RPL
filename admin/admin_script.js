function fetchBMIRecommendations() {
  fetch('./manage_bmi.php', {
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
            <td>
              ${rec.image ? `<img src="../${rec.image}" style="max-width:100px; border-radius:6px;" />` : ''}
            </td>
            <td>${rec.exercise}</td>
            <td class="table-actions">
              <button class="btn btn-sm btn-danger" onclick="deleteBMIRecommendation(${rec.id})" title="Delete">
                <i class="bi bi-trash"></i>
              </button>
            </td>
          </tr>
        `;
      });
    }
  });
}

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

  fetch('./manage_bmi.php', {
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

window.deleteBMIRecommendation = function(id) {
  Swal.fire({
    title: 'Delete this recommendation?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes',
    cancelButtonText: 'No'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('./manage_bmi.php', {
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
};
