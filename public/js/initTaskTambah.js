function formatTanggalIndo(waktu) {
  return new Date(waktu).toLocaleString("id-ID", {
    day: "2-digit",
    month: "long",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
    hour12: false,
  });
}

function initTaskForm() {
  const form = document.getElementById("tambahhtask");
  if (!form) return;

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const kosong = [];
    const tidakValid = [];

    const inputList = [
      {
        id: "task",
        label: "Judul Task",
        regex: /^[a-zA-Z0-9 @]+$/,
        pesan: "Task hanya boleh berisi huruf, angka, spasi, dan @"
      },
      {
        id: "keterangan",
        label: "Keterangan Task",
        regex: /^[a-zA-Z0-9 @]+$/,
        pesan: "Keterangan hanya boleh berisi huruf, angka, spasi, dan @"
      },
      {
        id: "deadline",
        label: "Deadline",
        regex: /.+/,
        pesan: "Deadline harus diisi"
      },
      {
        id: "prioritas",
        label: "Prioritas",
        regex: /.+/,
        pesan: "Prioritas harus diisi"
      }
    ];

    inputList.forEach((f) => {
      const el = form.querySelector("#" + f.id);
      const val = el?.value.trim();
      if (!val) {
        kosong.push(f.label);
      } else if (f.regex && !f.regex.test(val)) {
        tidakValid.push(f.pesan);
      }
    });

    if (kosong.length > 0) {
      Swal.fire({
        icon: "warning",
        title: "Field belum terisi!",
        html: "<strong>Field kosong:</strong><br>" + kosong.join(", "),
        confirmButtonText: "Mengerti"
      });
      return;
    } else if (tidakValid.length > 0) {
      Swal.fire({
        icon: "warning",
        title: "Field tidak valid!",
        html: "<strong>Field tidak valid:</strong><br>" + tidakValid.join("<br>"),
        confirmButtonText: "Mengerti"
      });
      return;
    }

    const data = new FormData(form);

    fetch(window.routes.taskStore, {
      method: "POST",
      body: data,
      headers: {
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        "Accept": "application/json"
      }
    })
      .then((res) => res.json())
      .then((res) => {
        if (res.success) {
          const t = res.task;

          const html = `
          <div class="col-12 col-md-6 mb-3">
            <div class="card priority-${t.prioritas} todo-card"
                 data-priority="${t.prioritas}"
                 data-deadline="${t.deadline}"
                 data-task-id="${t.id_task}"
                 data-created="${t.created_at}"
                 data-status-task="${t.status_task}">
              <div class="card-header bg-primary text-white">
                <div class="row w-100">
                  <div class="col-12">
                    <h3 class="task-title mb-0"><span class="task-text">${t.judul_task}</span></h3>
                  </div>
                  <div class="col-6">
                    <small class="task-date text-light">Tanggal Pembuatan: ${formatTanggalIndo(t.created_at)}</small>
                  </div>
                  <div class="col-6 text-end">
                    <span class="badge bg-priority-medium">Prioritas: ${t.prioritas}</span>
                  </div>
                </div>
              </div>
              <div class="card-body bg-light">
                <div class="subtask-info mb-3">
                  <h6 class="mb-2">Subtask:</h6>
                  <ul class="list-group list-group-flush overflow-auto" style="max-height: 200px;"></ul>
                </div>
                <hr>
                <div class="due-date">
                  <span class="d-block mb-2">Waktu Tenggat: ${formatTanggalIndo(t.deadline)}</span>
                  <span class="d-block mb-2">Prioritas: ${t.prioritas}</span>
                  <span class="d-block mb-2">Status Task: ${t.status_task}</span>
                </div>
              </div>
              <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                <div class="btn-group gap-2">
                  <button type="button" class="btn btn-outline-primary btn-sm tambah-subtask" data-id="${t.id_task}">Tambah Subtask</button>
                  <form class="update-status-form" action="/dashboard/updateStatus/${t.id_task}" method="POST">
                    <input type="hidden" name="status_task" value="…">
                    <button type="button" class="btn btn-primary btn-sm done-btn" data-id="…">Selesai</button>
                  </form>
                  <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="${t.id_task}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash2-fill" viewBox="0 0 16 16">
                      <path d="M2.037 3.225A.7.7 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2a.7.7 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671zm9.89-.69C10.966 2.214 9.578 2 8 2c-1.58 0-2.968.215-3.926.534-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466-.18-.14-.498-.307-.975-.466z"/>
                    </svg>
                  </button>
                </div>
                <button type="button" class="btn btn-primary btn-sm edit-btn"
                        data-task="${t.judul_task}"
                        data-keterangan="${t.keterangan_task}"
                        data-deadline="${t.deadline}"
                        data-task-id="${t.id_task}"
                        data-status="${t.status_task}">
                  ✎
                </button>
              </div>
            </div>
          </div>`;

          const list = document.getElementById("todo-list");
          if (list) {
            list.insertAdjacentHTML("beforeend", html);
            if (typeof initBadge === "function") initBadge();
            if (typeof initDatetimeLocal === "function") initDatetimeLocal();
            if (typeof initTaskSort === "function") initTaskSort();
            if (typeof initTaskStatusUpdater === "function") initTaskStatusUpdater();
          }

          if (res.subtask) {
            const card = list.querySelector(`.todo-card[data-task-id="${t.id_task}"]`);
            const ul = card.querySelector(".subtask-info ul");
            ul.insertAdjacentHTML("beforeend", `
              <li class="list-group-item listSubtask">
                <label>
                  <input type="checkbox" class="subtask-checkbox" data-id="${res.subtask.id_subtask}" ${res.subtask.status_subtask === 'selesai' ? 'checked' : ''}>
                  ${res.subtask.judul_subtask}
                </label>
                <p class="subtask-desc mb-0">Keterangan: ${res.subtask.keterangan_subtask}</p>
                <button type="button" class="btn btn-outline-primary btn-sm update-subtask">Edit Subtask</button>
                <button type="button" class="btn btn-outline-danger btn-sm delete-subtask" data-id="${res.subtask.id_subtask}">Hapus Subtask</button>
              </li>`);
          }

          form.reset();
          const modal = bootstrap.Modal.getInstance(document.getElementById("tambahTaskModal"));
          if (modal) modal.hide();

          Swal.fire({
            icon: "success",
            title: "Berhasil!",
            text: "Task berhasil ditambahkan.",
            confirmButtonText: "Oke"
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Gagal!",
            text: "Terjadi kesalahan saat menambah task.",
            confirmButtonText: "Mengerti"
          });
        }
      })
      .catch((err) => {
        Swal.fire({
          icon: "error",
          title: "Error!",
          text: "Terjadi kesalahan: " + err,
          confirmButtonText: "Mengerti"
        });
      });
  });
}

document.addEventListener("DOMContentLoaded", function () {
  initTaskForm();
});