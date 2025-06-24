const scrollingRecipes = document.querySelector('.scrolling-recipes');
    if (scrollingRecipes) {
        document.querySelectorAll('.recipe-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                scrollingRecipes.style.animationPlayState = 'paused';
            });
            card.addEventListener('mouseleave', () => {
                scrollingRecipes.style.animationPlayState = 'running';
            });
        });
    }

const buttons = document.querySelectorAll('.btn[data-target]');
    const sections = document.querySelectorAll('#content-area > div');

    function showSection(id) {
        sections.forEach(section => {
            section.classList.remove('active');
            if (section.id === id) section.classList.add('active');
        });
    }

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const target = button.getAttribute('data-target');
            showSection(target);
        });
    });

    function toggleDetails(button) {
        const card = button.closest('.card, .recipe-card');
        if (!card) return;

        const cardBody = button.closest('.card-body');
        if (!cardBody) return;

        const details = cardBody.querySelector('.food-details');
        if (!details) return;

        // Hide all other details and reset their buttons
        document.querySelectorAll('.card, .recipe-card').forEach(otherCard => {
            if (otherCard !== card) {
                const otherBody = otherCard.querySelector('.card-body');
                const otherDetails = otherBody ? otherBody.querySelector('.food-details') : null;
                const otherButton = otherBody ? otherBody.querySelector('button[onclick^="toggleDetails"]') : null;
                if (otherDetails) {
                    otherDetails.classList.remove('show');
                    otherDetails.style.display = 'none';
                }
                if (otherButton) otherButton.textContent = 'View Details';
            }
        });

        // Toggle this card's details
        const isShowing = details.classList.contains('show') || details.style.display === 'block';
        if (isShowing) {
            details.classList.remove('show');
            details.style.display = 'none';
            button.textContent = 'View Details';
        } else {
            details.classList.add('show');
            details.style.display = 'block';
            button.textContent = 'Hide Details';
        }
    }

  //video carousel
   const videoCarousel = document.querySelector('#videoCarousel');
if (videoCarousel) {
  videoCarousel.addEventListener('slide.bs.carousel', () => {
    const videos = videoCarousel.querySelectorAll('video');
    videos.forEach(video => {
      video.pause();
      video.currentTime = 0;
    });
  });

  videoCarousel.addEventListener('slid.bs.carousel', () => {
    const activeVideo = videoCarousel.querySelector('.carousel-item.active video');
    if (activeVideo) {
      activeVideo.play();
    }
  });
}

document.addEventListener("DOMContentLoaded", () => {
  console.log("✅ DOM loaded");

  const form = document.getElementById("bmiForm");
  if (form && !form.dataset.bound) {
    form.dataset.bound = "true";
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      calculateBMI();
    });
  }

  loadBMIHistory(); // ✅ Call only once at page load
});

// ✅ BMI Calculator
function calculateBMI() {
  const height = parseFloat(document.getElementById('height').value);
  const weight = parseFloat(document.getElementById('weight').value);
  if (!height || !weight) return;

  const bmi = (weight / ((height / 100) ** 2)).toFixed(1);
  let status, food, exercise, catalogue;

  if (bmi < 18.5) {
    status = 'Underweight';
    food = 'High-protein foods like eggs, nuts, dairy';
    exercise = 'Light strength training, yoga';
    catalogue = '<ul><li>Peanut Butter Smoothie</li><li>Cheese Omelette</li><li>Whole Milk Yogurt</li></ul>';
  } else if (bmi < 25) {
    status = 'Normal weight';
    food = 'Balanced diet with fruits, grains, proteins';
    exercise = 'Regular cardio and moderate strength training';
    catalogue = '<ul><li>Grilled Chicken Bowl</li><li>Quinoa Salad</li><li>Fruit Platter</li></ul>';
  } else if (bmi < 30) {
    status = 'Overweight';
    food = 'Low-carb meals with lean proteins';
    exercise = 'Cardio, jogging, interval training';
    catalogue = '<ul><li>Grilled Fish with Veggies</li><li>Keto Chicken Wrap</li><li>Green Smoothie</li></ul>';
  } else {
    status = 'Obese';
    food = 'Low-fat, high-fiber meals';
    exercise = 'Walking, swimming, light aerobics';
    catalogue = '<ul><li>Steamed Broccoli & Brown Rice</li><li>Vegetable Soup</li><li>Tofu Stir Fry</li></ul>';
  }

  const result = `Your BMI is ${bmi} (${status})`;

  // Show result
  document.getElementById('bmiValue').innerText = result;
  document.getElementById('recommendations').innerHTML = `
    <h5>Recommended Foods:</h5><p>${food}</p>
    <h5>Suggested Exercises:</h5><p>${exercise}</p>
    <h5>Catalogue:</h5>${catalogue}
  `;
  document.getElementById('bmiResult').style.display = 'block';

  // Save to PHP
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "php/save_bmi.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      console.log("✅ BMI saved");
      // ❌ Do NOT call loadBMIHistory() here — already called on page load
    }
  };
  xhr.send(
    "height=" + encodeURIComponent(height) +
    "&weight=" + encodeURIComponent(weight) +
    "&bmi=" + encodeURIComponent(bmi) +
    "&status=" + encodeURIComponent(status) +
    "&food=" + encodeURIComponent(food) +
    "&exercise=" + encodeURIComponent(exercise)
  );
}

// ✅ History loader — called once at startup
function loadBMIHistory() {
  const historyBody = document.getElementById("historyBody");
  if (!historyBody) return;

  fetch("php/fetch_history.php")
    .then(res => res.json())
    .then(data => {
      historyBody.innerHTML = ""; // clear old rows

      if (!Array.isArray(data) || data.length === 0) {
        historyBody.innerHTML = `<tr><td colspan="7">No history found.</td></tr>`;
        return;
      }

      data.forEach(item => {
        const row = `
          <tr>
            <td>${new Date(item.created_at).toLocaleString()}</td>
            <td>${item.height}</td>
            <td>${item.weight}</td>
            <td>${item.bmi}</td>
            <td>${item.status}</td>
            <td>${item.food}</td>
            <td>${item.exercise}</td>
          </tr>`;
        historyBody.innerHTML += row;
      });
    })
    .catch(err => {
      console.error("Failed to load history:", err);
      historyBody.innerHTML = `<tr><td colspan="7">Failed to load history.</td></tr>`;
    });
}