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
  }

function toggleDetails(button) {
  const details = button.nextElementSibling;

  function toggleDetails(button) {
  const details = button.nextElementSibling;

  if (details.classList.contains("show")) {
    details.classList.remove("show");
    button.innerText = "View Details";
  } else {
    details.classList.add("show");
    button.innerText = "Hide Details";
  }
}
}
  //video carousel
   const videoCarousel = document.querySelector('#videoCarousel');

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

  
