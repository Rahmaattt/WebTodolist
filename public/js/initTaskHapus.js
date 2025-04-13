function initTaskHapus() {
  document.addEventListener("click", function (e) {
    if (e.target.closest(".delete-btn")) {
      e.preventDefault();
      const btn = e.target.closest(".delete-btn");
      const taskId = btn.getAttribute("data-id");

      Swal.fire({
        title: "Ingin hapus task?",
        text: "Anda tidak akan bisa mengembalikannya",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus task!",
        cancelButtonText: "Tidak",
      }).then((result) => {
        if (result.isConfirmed) {
          const url = window.routes.deleteTask.replace(":id_task", taskId);

          fetch(url, {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
              Accept: "application/json",
            },
            body: JSON.stringify({
              id_task: taskId,
            }),
          })
            .then((response) => response.json())
            .then((data) => {
              if (data.success) {
                Swal.fire("Terhapus!", data.message, "success");
                const card = btn.closest(".todo-card");
                if (card) {
                  card.parentElement.remove(); // hapus wrapper kolom
                }
              } else {
                Swal.fire("Gagal!", "Task gagal dihapus.", "error");
              }
            })
            .catch((error) => {
              Swal.fire("Error!", "Terjadi error: " + error, "error");
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            title: "Batal",
            text: "Task tidak jadi dihapus.",
            icon: "info",
            showConfirmButton: false,
          });
        }
      });
    }
  });
}

document.addEventListener("DOMContentLoaded", function(){
  initTaskHapus();
});