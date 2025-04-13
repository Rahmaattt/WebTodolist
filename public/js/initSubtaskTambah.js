function initSubtaskTambah() {
  const form = document.getElementById("formTambahSubtask");
  if (!form) return;

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const missing = [];
    const invalid = [];

    const fields = [
      {
        id: "judul_subtask",
        label: "Judul Subtask",
        regex: /^[a-zA-Z0-9 ]+$/,
        errorMsg: "Judul Subtask hanya boleh berisi huruf, angka, dan spasi"
      },
      {
        id: "keterangan_subtask",
        label: "Keterangan Subtask",
        regex: /^[a-zA-Z0-9 ]+$/,
        errorMsg: "Keterangan hanya boleh berisi huruf, angka, dan spasi"
      }
    ];

    fields.forEach(function (field) {
      const input = form.querySelector('#' + field.id);
      if (input) {
        const value = input.value.trim();
        if (value === "") {
          missing.push(field.label);
        } else if (!field.regex.test(value)) {
          invalid.push(field.errorMsg);
        }
      }
    });

    if (missing.length > 0) {
      Swal.fire({
        icon: "warning",
        title: "Field belum terisi!",
        html: "<strong>Field kosong:</strong><br>" + missing.join(", "),
        confirmButtonText: "Mengerti"
      });
      return;
    } else if (invalid.length > 0) {
      Swal.fire({
        icon: "warning",
        title: "Field tidak valid!",
        html: "<strong>Field tidak valid:</strong><br>" + invalid.join("<br>"),
        confirmButtonText: "Mengerti"
      });
      return;
    }

    const formData = new FormData(form);

    fetch(window.routes.subtaskStore, {
      method: "POST",
      body: formData,
      headers: {
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        "Accept": "application/json"
      }
    })
      .then(response => response.json())
      .then(function (data) {
        if (data.success) {
          Swal.fire({
            icon: "success",
            title: "Berhasil!",
            text: "Subtask berhasil ditambahkan.",
            confirmButtonText: "Mengerti"
          });

          const card = document.querySelector('.todo-card[data-task-id="' + data.subtask.id_task + '"]');
          if (card) {
            const ul = card.querySelector('.subtask-info ul');
            if (ul) {
              const newSubtaskHtml = `
                <li class="list-group-item listSubtask">
                  <label>
                    <input type="checkbox" class="subtask-checkbox" data-id="${data.subtask.id_subtask}" ${data.subtask.status_subtask === 'selesai' ? 'checked' : ''}>
                    ${data.subtask.judul_subtask}
                  </label>
                  <p class="subtask-desc mb-0">Keterangan: ${data.subtask.keterangan_subtask}</p>
                  <button type="button" class="btn btn-outline-primary btn-sm update-subtask">Edit Subtask</button>
                  <button type="button" class="btn btn-outline-danger btn-sm delete-subtask" data-id="${data.subtask.id_subtask}">Hapus Subtask</button>
                </li>`;
              ul.insertAdjacentHTML('beforeend', newSubtaskHtml);
            }
          }

          form.reset();
          const modal = document.getElementById("modalTambahSubtask");
          const modalInstance = bootstrap.Modal.getInstance(modal);
          if (modalInstance) modalInstance.hide();
        } else {
          Swal.fire({
            icon: "error",
            title: "Gagal!",
            text: "Terjadi kesalahan saat menambah subtask.",
            confirmButtonText: "Mengerti"
          });
        }
      })
      .catch(function (error) {
        Swal.fire({
          icon: "error",
          title: "Error!",
          text: "Terjadi kesalahan pada AJAX: " + error,
          confirmButtonText: "Mengerti"
        });
      });
  });
}

document.addEventListener("DOMContentLoaded", function(){
  initSubtaskTambah();
});