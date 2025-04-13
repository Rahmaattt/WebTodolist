function initTaskSort() {
  const sortByBtn = document.getElementById("sortTasksDropdown");
  const sortByOptions = document.querySelectorAll("#sortTasksDropdown + .dropdown-menu .dropdown-item");
  const orderByBtn = document.getElementById("sortOrderDropdown");
  const orderByOptions = document.querySelectorAll("#sortOrderDropdown + .dropdown-menu .dropdown-item");
  const list = document.getElementById("todo-list");

  if (!sortByBtn || !orderByBtn || !list || sortByOptions.length === 0 || orderByOptions.length === 0) return;

  let sortBy = "title";
  let order = "asc";

  // Listener pilihan urut berdasarkan
  sortByOptions.forEach(option => {
    option.addEventListener("click", function(e) {
      e.preventDefault();
      sortBy = this.getAttribute("data-value");
      sortByBtn.setAttribute("title", "Sort: " + this.textContent);
      sortList();
    });
  });

  // Listener pilihan urutan naik/turun
  orderByOptions.forEach(option => {
    option.addEventListener("click", function(e) {
      e.preventDefault();
      order = this.getAttribute("data-value");
      orderByBtn.setAttribute("title", "Order: " + this.textContent);
      sortList();
    });
  });

  function sortList() {
    const emptyMsg = document.getElementById("no-task-msg");
    if (emptyMsg) emptyMsg.remove();

    const items = Array.from(list.children).filter(item => item.id !== "no-task-msg");

    items.sort((a, b) => {
      const cardA = a.querySelector(".todo-card");
      const cardB = b.querySelector(".todo-card");
      if (!cardA || !cardB) return 0;

      let result = 0;

      if (sortBy === "title") {
        const textA = (a.querySelector(".task-text") || {}).textContent?.trim().toLowerCase() || "";
        const textB = (b.querySelector(".task-text") || {}).textContent?.trim().toLowerCase() || "";
        result = textA.localeCompare(textB);
      } else if (sortBy === "priority") {
        const priorityMap = { "tinggi": 1, "sedang": 2, "rendah": 3 };
        const pA = (cardA.getAttribute("data-priority") || "").toLowerCase();
        const pB = (cardB.getAttribute("data-priority") || "").toLowerCase();
        result = (priorityMap[pA] || 99) - (priorityMap[pB] || 99);
      } else if (sortBy === "deadline") {
        const dA = new Date(cardA.getAttribute("data-deadline"));
        const dB = new Date(cardB.getAttribute("data-deadline"));
        result = dA - dB;
      } else if (sortBy === "created") {
        const cA = new Date(cardA.getAttribute("data-created"));
        const cB = new Date(cardB.getAttribute("data-created"));
        result = cA - cB;
      }

      return order === "asc" ? result : -result;
    });

    list.innerHTML = "";
    items.forEach(item => list.appendChild(item));

    if (items.length === 0 || items.every(i => i.style.display === "none")) {
      const msg = document.createElement("p");
      msg.id = "no-task-msg";
      msg.textContent = "Task yang anda cari tidak ada";
      msg.classList.add("text-center", "mt-3", "text-muted");
      list.appendChild(msg);
    }
  }
}

document.addEventListener("DOMContentLoaded", function () {
  initTaskSort();
});
