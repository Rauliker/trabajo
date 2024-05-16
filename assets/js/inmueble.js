const toggleDescriptions = document.querySelectorAll(".toggle-description");

toggleDescriptions.forEach((toggle) => {
  toggle.addEventListener("click", (event) => {
    const item = event.currentTarget.dataset.item;
    const descriptionElement = document.getElementById(`description-${item}`);

    if (descriptionElement.classList.contains("expanded")) {
      descriptionElement.classList.remove("expanded");
      toggle.textContent = "Ver más";
    } else {
      descriptionElement.classList.add("expanded");
      toggle.textContent = "Ver menos";
    }
  });
});
