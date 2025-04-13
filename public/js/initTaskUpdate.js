function initTaskUpdate() {
  document.addEventListener("submit", function (e) {
    const form = e.target.closest("#formUpdateTask");
    if (!form) return;

    e.preventDefault();

    const id = document.getElementById("updateTaskId").value;
    const url = `/dashboard/update/${id}`;
    const data = new FormData(form);

    fetch(url, {
      method: "POST",
      body: data,
      headers: {
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        "Accept": "application/json",
      },
    })
      .then((res) => {
        if (!res.ok) throw new Error(`HTTP error ${res.status}`);
        return res.json();
      })
      .then((res) => {
        if (!res.success) {
          return Swal.fire("Gagal!", res.message || "Task gagal diperbarui", "warning");
        }

        const task = res.task;
        const card = document.querySelector(`.todo-card[data-task-id='${id}']`);

        if (card) {
          const judul = card.querySelector(".task-title .task-text");
          if (judul) judul.textContent = task.judul_task;

          const ket = card.querySelector(".task-description");
          if (ket) ket.textContent = `Keterangan: ${task.keterangan_task}`;

          const ddl = card.querySelector(".task-deadline");
          if (ddl) ddl.textContent = `Deadline: ${task.deadline}`;

          const stat = card.querySelector(".due-date .status-task");
          if (stat) stat.textContent = `Status Task: ${task.status_task}`;

          const btn = card.querySelector(`.done-btn[data-id='${id}']`);
          if (btn) {
            btn.dataset.status = task.status_task;
            btn.classList.toggle("btn-primary", task.status_task !== "selesai");
            btn.classList.toggle("btn-warning", task.status_task === "selesai");
            btn.textContent = task.status_task === "selesai" ? "Batalkan" : "Selesai";
          }
        }

        const modal = bootstrap.Modal.getInstance(document.getElementById("modalUpdateTask"));
        if (modal) modal.hide();

        Swal.fire("Berhasil!", "Task berhasil diperbarui.", "success");
      })
      .catch((err) => {
        console.error("Error:", err);
        Swal.fire("Error!", "Terjadi kesalahan: " + err.message, "error");
      });
  });
}

document.addEventListener("DOMContentLoaded", function(){
  initTaskUpdate();
});