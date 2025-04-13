function initSubtaskStatus() {
  const body = document.body;

  body.addEventListener("click", (e) => {
    const cb = e.target.closest(".subtask-checkbox");
    if (!cb) return;

    const id = cb.getAttribute("data-id");
    if (!id) return;

    const isChecked = cb.checked;
    const status = isChecked ? "selesai" : "belum_selesai";
    const url = window.routes.subtaskStatus.replace(':id_subtask', id);

    fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
      },
      body: JSON.stringify({ status_subtask: status }),
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        localStorage.setItem(`subtask_${id}`, isChecked);
        updateStyle(cb, isChecked);

        Swal.fire({
          title: 'Berhasil!',
          text: `Subtask ditandai "${status.replace('_', ' ')}".`,
          icon: 'success',
          timer: 1800,
          showConfirmButton: false
        });
      } else {
        cb.checked = !isChecked;
        updateStyle(cb, !isChecked);

        Swal.fire({
          title: 'Gagal!',
          text: 'Gagal mengupdate status subtask.',
          icon: 'error',
          confirmButtonText: 'Oke'
        });
      }
    })
    .catch(err => {
      console.error("Fetch error:", err);
      Swal.fire({
        title: 'Error!',
        text: 'Terjadi kesalahan saat mengirim permintaan.',
        icon: 'error',
        confirmButtonText: 'Tutup'
      });
    });
  });

  document.querySelectorAll(".subtask-checkbox").forEach(cb => {
    const id = cb.getAttribute("data-id");
    const saved = localStorage.getItem(`subtask_${id}`);
    cb.checked = saved === "true";
    updateStyle(cb, cb.checked);
  });

  function updateStyle(cb, checked) {
    const li = cb.closest("li");
    if (!li) return;

    const label = li.querySelector("label");
    const desc = li.querySelector("p.subtask-desc");

    if (checked) {
      if (label) label.style.color = "gray";
      if (desc) desc.style.color = "gray";
      cb.disabled = true;
    } else {
      if (label) label.style.color = "";
      if (desc) desc.style.color = "";
    }
  }
}

document.addEventListener("DOMContentLoaded", function(){
  initSubtaskStatus();
});