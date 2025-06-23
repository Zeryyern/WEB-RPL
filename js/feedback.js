document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("feedbackFormElement");
  const successBox = document.getElementById("feedbackSuccess");
  const submitBtn = form?.querySelector("button[type='submit']");

  if (form && submitBtn) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();

      // Show loading state
      submitBtn.disabled = true;
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...`;

      const formData = new FormData(form);

      fetch(form.action, {
        method: "POST",
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            successBox.style.display = "block";
            form.reset();
          } else {
            alert(data.message || "Something went wrong. Please try again.");
          }
        })
        .catch(error => {
          console.error("Error:", error);
          alert("An error occurred. Please try again later.");
        })
        .finally(() => {
          // Restore button state
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;
        });
    });
  }
});
