document.addEventListener("click", (e) => {
  const toggle = e.target.closest(".show-all-btn, .accordion-btn");
  if (toggle) {
    const body = toggle.nextElementSibling;
    const icon = toggle.querySelector(".show-all-icon, .accordion-icon");
    body.classList.toggle("hidden");
    if (icon) icon.textContent = body.classList.contains("hidden") ? "expand_more" : "expand_less";
    return;
  }

  const more = e.target.closest(".read-more-btn");
  if (more) {
    const expander = more.previousElementSibling;
    const fade = expander.querySelector(".tarjama-fade");
    expander.style.maxHeight = "none";
    fade?.remove();
    more.remove();
  }
});
