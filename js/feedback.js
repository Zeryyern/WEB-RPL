document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("feedbackFormElement");
  const successBox = document.getElementById("feedbackSuccess");
  const submitBtn = form?.querySelector("button[type='submit']");

  if (form && submitBtn) {
    form.addEventListener("submit", function (e) {
      e.preventDefault(); // ✅ Stop normal form submission

      // Show loading state
      submitBtn.disabled = true;
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...`;

      const formData = new FormData(form);

      fetch(form.action, {
        method: "POST",
        body: formData,
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            successBox.textContent = data.message || "✔️ Submitted!";
            successBox.style.display = "block";
            form.reset();
          } else {
            successBox.textContent = data.message || "❌ Something went wrong.";
            successBox.style.color = "red";
            successBox.style.display = "block";
          }
        })
        .catch(error => {
          console.error("Fetch error:", error);
          successBox.textContent = "❌ Network error. Please try again.";
          successBox.style.color = "red";
          successBox.style.display = "block";
        })
        .finally(() => {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;
        });
    });
  }
});
