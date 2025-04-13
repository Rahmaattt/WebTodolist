function initSubtaskHapus() {
  document.addEventListener("click", function (e) {
    if (e.target.classList.contains("delete-subtask")) {
      e.preventDefault();
      const btn = e.target;
      const subtaskId = btn.getAttribute("data-id");

      Swal.fire({
        title: "Hapus subtask?",
        text: "Data tidak dapat dikembalikan",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Tidak",
      }).then((res) => {
        if (res.isConfirmed) {
          fetch(window.routes.deleteSubtask, {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
              Accept: "application/json",
            },
            body: JSON.stringify({ id_subtask: subtaskId }),
          })
            .then((res) => res.json())
            .then((data) => {
              if (data.success) {
                Swal.fire("Terhapus!", "Subtask berhasil dihapus.", "success");
                const item = btn.closest(".listSubtask");
                if (item) item.remove();
              } else {
                Swal.fire("Gagal!", "Subtask gagal dihapus.", "error");
              }
            })
            .catch((err) => {
              Swal.fire("Error!", "Terjadi kesalahan: " + err, "error");
            });
        } else if (res.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            title: "Batal",
            text: "Subtask batal dihapus.",
            icon: "info",
            showConfirmButton: false,
          });
        }
      });
    }
  });
}

document.addEventListener("DOMContentLoaded", function () {
  initSubtaskHapus();
});
