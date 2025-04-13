function initTaskStatus() {
  const list = document.getElementById("todo-list");
  if (!list) return;

  document.querySelectorAll(".todo-card").forEach(card => {
    const id = card.getAttribute("data-task-id");
    const savedStatus = localStorage.getItem("card_status_" + id);
    if (!savedStatus) return;

    const form = card.querySelector(".update-status-form");
    const btn = card.querySelector(".done-btn");
    const input = form?.querySelector("input[name='status_task']");

    if (input) input.value = savedStatus;
    if (btn) updateBtn(btn, savedStatus);
  });

  list.addEventListener("click", e => {
    const el = e.target;
    if (!el.closest(".done-btn")) return;

    e.preventDefault();

    const form = el.closest(".update-status-form");
    if (!form) return;

    const card = form.closest(".todo-card");
    if (!card) return;

    const id = card.getAttribute("data-task-id");
    const input = form.querySelector("input[name='status_task']");
    let status = input.value;

    const incomplete = card.querySelectorAll(".subtask-checkbox:not(:checked)");
    if (incomplete.length > 0 && status !== "selesai") {
      Swal.fire({
        title: "Subtask belum selesai!",
        text: "Silakan selesaikan semua subtask terlebih dahulu.",
        icon: "warning",
        confirmButtonText: "Mengerti"
      });
      return;
    }

    const deadlineStr = card.getAttribute("data-deadline");
    const deadline = deadlineStr ? new Date(deadlineStr.replace(" ", "T")) : null;
    const now = new Date();

    let newStatus;
    if (deadline && now > deadline && status !== "selesai") {
      newStatus = "terlambat";
    } else {
      newStatus = status === "selesai" ? "belum_selesai" : "selesai";
    }

    input.value = newStatus;

    const token = document.querySelector('meta[name="csrf-token"]').content;
    const data = new FormData();
    data.append("_token", token);
    data.append("status_task", newStatus);

    const url = window.routes.updateTaskStatus.replace(":id_task", id);

    fetch(url, {
      method: "POST",
      body: data
    })
      .then(res => res.json())
      .then(res => {
        if (res.success) {
          updateBtn(el, res.new_status);
          localStorage.setItem("card_status_" + id, res.new_status);

          Swal.fire({
            title: "Berhasil!",
            text: `Task diperbarui ke status "${res.new_status}".`,
            icon: "success",
            timer: 1600,
            showConfirmButton: false
          });
        } else {
          Swal.fire({
            title: "Gagal!",
            text: "Status task gagal diperbarui.",
            icon: "error"
          });
        }
      })
      .catch(err => {
        console.error(err);
        Swal.fire({
          title: "Error!",
          text: "Terjadi kesalahan saat update status.",
          icon: "error"
        });
      });
  });
}

function updateBtn(btn, status) {
  const card = btn.closest(".todo-card");
  if (!card) return;

  const header = card.querySelector(".card-header");

  btn.classList.remove("btn-primary", "btn-success", "btn-danger", "btn-warning");
  header.classList.remove("bg-primary", "bg-success", "bg-danger", "bg-warning");

  if (status === "terlambat") {
    btn.textContent = "Terlambat";
    btn.classList.add("btn-danger");
    btn.disabled = true;
    header.classList.add("bg-danger");
  } else if (status === "selesai") {
    btn.textContent = "Selesai";
    btn.classList.add("btn-success");
    btn.disabled = true;
    header.classList.add("bg-success");
  } else if (status === "belum_selesai") {
    btn.textContent = "Selesai";
    btn.classList.add("btn-primary");
    btn.disabled = false;
    header.classList.add("bg-primary");
  }
}

document.addEventListener("DOMContentLoaded", function () {
  initTaskStatus();
});