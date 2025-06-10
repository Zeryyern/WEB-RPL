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
    document.getElementById('feedbackForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = e.target;
        var formData = new FormData(form);

        fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                var msg = document.getElementById('feedbackMessage');
                if (data.success) {
                    form.style.display = 'none';
                    msg.className = 'alert alert-success';
                    msg.style.display = 'block';
                    msg.innerText = data.message || 'Thank you for your feedback!';
                } else {
                    msg.className = 'alert alert-danger';
                    msg.style.display = 'block';
                    msg.innerText = data.message ||
                        'There was a problem submitting your feedback.';
                }
            })
            .catch(() => {
                var msg = document.getElementById('feedbackMessage');
                msg.className = 'alert alert-danger';
                msg.style.display = 'block';
                msg.innerText = 'An error occurred. Please try again.';
            });
    });

function calculateBMI() {
    const height = parseFloat(document.getElementById('height').value);
    const weight = parseFloat(document.getElementById('weight').value);
    if (!height || !weight) return;

    const bmi = (weight / ((height / 100) ** 2)).toFixed(1);
    let result = `Your BMI is ${bmi}`;
    let food, exercise, catalogue;

    if (bmi < 18.5) {
      food = 'High-protein foods like eggs, nuts, dairy';
      exercise = 'Light strength training, yoga';
      catalogue = '<ul><li>Peanut Butter Smoothie</li><li>Cheese Omelette</li><li>Whole Milk Yogurt</li></ul>';
      result += ' (Underweight)';
    } else if (bmi >= 18.5 && bmi < 25) {
      food = 'Balanced diet with fruits, grains, proteins';
      exercise = 'Regular cardio and moderate strength training';
      catalogue = '<ul><li>Grilled Chicken Bowl</li><li>Quinoa Salad</li><li>Fruit Platter</li></ul>';
      result += ' (Normal weight)';
    } else if (bmi >= 25 && bmi < 30) {
      food = 'Low-carb meals with lean proteins';
      exercise = 'Cardio, jogging, interval training';
      catalogue = '<ul><li>Grilled Fish with Veggies</li><li>Keto Chicken Wrap</li><li>Green Smoothie</li></ul>';
      result += ' (Overweight)';
    } else {
      food = 'Low-fat, high-fiber meals';
      exercise = 'Walking, swimming, light aerobics';
      catalogue = '<ul><li>Steamed Broccoli & Brown Rice</li><li>Vegetable Soup</li><li>Tofu Stir Fry</li></ul>';
      result += ' (Obese)';
    }

    document.getElementById('bmiValue').innerText = result;
    document.getElementById('recommendations').innerHTML = `
      <h5>Recommended Foods:</h5>
      <p>${food}</p>
      <h5>Suggested Exercises:</h5>
      <p>${exercise}</p>
      <h5>Recommended Food Catalogue:</h5>
      ${catalogue}
    `;
    document.getElementById('bmiResult').style.display = 'block';

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "php/save_bmi.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Optionally handle response, e.g., show a message
        // alert(xhr.responseText);
      }
    };
    xhr.send(
      "bmi=" + encodeURIComponent(bmi) +
      "&status=" + encodeURIComponent(result.match(/\((.*?)\)/)[1]) +
      "&food=" + encodeURIComponent(food) +
      "&exercise=" + encodeURIComponent(exercise)
    );
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


