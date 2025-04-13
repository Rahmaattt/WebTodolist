function initBadge() {
  const cards = document.querySelectorAll(".todo-card");
  cards.forEach(function(card) {
    const badge = card.querySelector(".badge");
    const prioritas = card ? card.getAttribute("data-priority") : null;
    if (prioritas === "tinggi") {
      badge.classList.remove("bg-priority-medium", "bg-priority-low");
      badge.classList.add("bg-priority-high");
    } else if (prioritas === "sedang") {
      badge.classList.remove("bg-priority-high", "bg-priority-low");
      badge.classList.add("bg-priority-medium");
    } else {
      badge.classList.remove("bg-priority-high", "bg-priority-medium");
      badge.classList.add("bg-priority-low");
    }
  });
}

document.addEventListener("DOMContentLoaded", function () {
  initBadge();
});