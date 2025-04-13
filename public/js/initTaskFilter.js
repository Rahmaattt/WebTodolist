function initTaskFilter() {
  const btn = document.getElementById("filterDropdown");
  const items = document.querySelectorAll("#filterDropdown + .dropdown-menu .dropdown-item");
  const list = document.getElementById("todo-list");

  if (!btn || !list || items.length === 0) return;

  let selected = "all";

  items.forEach(item => {
    item.addEventListener("click", function (e) {
      e.preventDefault();
      selected = this.getAttribute("data-value");
      btn.setAttribute("title", "Filter: " + this.textContent);
      apply();
    });
  });

  function apply() {
    const tasks = Array.from(list.children);
    let visible = 0;

    tasks.forEach(task => {
      if (task.id === "no-task-msg") return;

      const card = task.querySelector(".todo-card");
      const priority = card ? card.getAttribute("data-priority") : null;

      if (selected === "all" || priority === selected) {
        task.style.display = "";
        visible++;
      } else {
        task.style.display = "none";
      }
    });

    let msg = document.getElementById("no-task-msg");
    if (visible === 0) {
      if (!msg) {
        msg = document.createElement("p");
        msg.id = "no-task-msg";
        msg.textContent = "Task yang anda cari tidak ada";
        msg.classList.add("text-center", "mt-3", "text-muted");
        list.appendChild(msg);
      }
    } else {
      if (msg) msg.remove();
    }
  }
}

document.addEventListener("DOMContentLoaded", function () {
  initTaskFilter();
});