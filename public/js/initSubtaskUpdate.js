function initSubtaskUpdate() {
  const form = document.getElementById("formUpdateSubtask");
  if (!form) return;

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const data = new FormData(form);

    fetch(window.routes.updateSubtaskForm, {
      method: "POST",
      body: data,
      headers: {
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        "Accept": "application/json"
      }
    })
      .then(res => res.json())
      .then(res => {
        if (res.success) {
          Swal.fire({
            icon: "success",
            title: "Subtask berhasil diperbarui",
            confirmButtonText: "Mengerti"
          });

          const card = document.querySelector(`.todo-card[data-task-id="${res.subtask.id_task}"]`);
          if (card) {
            const checkbox = card.querySelector(`.listSubtask input.subtask-checkbox[data-id="${res.subtask.id_subtask}"]`);
            if (checkbox) {
              const item = checkbox.closest('.listSubtask');
              if (item) {
                const label = item.querySelector('label');
                const desc = item.querySelector('.subtask-desc');
                const edit = item.querySelector('.edit-subtask-btn');
                const update = item.querySelector('.update-subtask');

                if (label) {
                  label.innerHTML = `
                    <input type="checkbox" class="subtask-checkbox" data-id="${res.subtask.id_subtask}" ${res.subtask.status_subtask === 'selesai' ? 'checked' : ''}>
                    ${res.subtask.judul_subtask}
                  `;
                }
                if (desc) desc.textContent = 'Keterangan: ' + res.subtask.keterangan_subtask;
                if (edit) {
                  edit.dataset.judul = res.subtask.judul_subtask;
                  edit.dataset.keterangan = res.subtask.keterangan_subtask;
                }
                if (update) {
                  update.dataset.judul = res.subtask.judul_subtask;
                  update.dataset.keterangan = res.subtask.keterangan_subtask;
                }
              }
            }
          }

          form.reset();
          const modal = document.getElementById("modalUpdateSubtask");
          const modalInstance = bootstrap.Modal.getInstance(modal);
          if (modalInstance) modalInstance.hide();
        } else {
          Swal.fire({
            icon: "error",
            title: "Terjadi kesalahan saat mengupdate subtask.",
            confirmButtonText: "Mengerti"
          });
        }
      })
      .catch(err => {
        Swal.fire({
          icon: "error",
          title: "Error AJAX: " + err,
          confirmButtonText: "Mengerti"
        });
      });
  });
}

document.addEventListener("DOMContentLoaded", function () {
  initSubtaskUpdate();
});