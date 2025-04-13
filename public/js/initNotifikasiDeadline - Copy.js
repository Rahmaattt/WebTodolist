/*function initDeadlineChecker() {
  const now = new Date();
  const todoCards = document.querySelectorAll('.todo-card');

  todoCards.forEach(card => {
    let deadlineStr = card.getAttribute('data-deadline');
    const taskId = card.getAttribute('data-task-id');

    if (deadlineStr && taskId) {
      // Format tanggal agar kompatibel dengan objek Date
      if (deadlineStr.includes(' ')) {
        deadlineStr = deadlineStr.replace(' ', 'T');
      }

      const deadline = new Date(deadlineStr);
      const diffMs = deadline - now;
      const diffHours = diffMs / (1000 * 60 * 60);

      // Kirim notifikasi jika deadline dalam 24 jam ke depan
      if (diffHours > 0 && diffHours <= 24) {
        fetch(`/send-notification/${taskId}`)
          .then(res => res.text())
          .then(result => console.log(`Notifikasi dikirim untuk task ${taskId}: ${result}`))
          .catch(err => console.error("Error:", err));
      }

      // Nonaktifkan elemen jika deadline sudah lewat
      if (now > deadline) {
        card.classList.add('disabled-task');

        const subtaskInfos = card.querySelectorAll('.subtask-info');
        subtaskInfos.forEach(info => info.classList.add('disabled-task'));

        const updateButtons = card.querySelectorAll('.update-subtask');
        updateButtons.forEach(btn => {
          btn.classList.add('disabled-task');
          btn.disabled = true;
        });

        const actionButtons = card.querySelectorAll('#editz, #tambah-subtasks');
        actionButtons.forEach(btn => {
          btn.disabled = true;
        });
      }
    }
  });

  /**
   * Modul: Deadline Checker
   * Memeriksa deadline setiap .todo-card dan:
   * - Mengirim notifikasi jika deadline mendekati (kurang dari 24 jam).
   * - Menonaktifkan elemen jika deadline telah lewat.
   *
}*/

function initDeadlineChecker() {
  const now = new Date();
  const cards = document.querySelectorAll('.todo-card');

  cards.forEach(card => {
    let deadlineStr = card.getAttribute('data-deadline');
    const taskId = card.getAttribute('data-task-id');

    if (deadlineStr && taskId) {
      // Format tanggal agar kompatibel dengan objek Date
      if (deadlineStr.includes(' ')) {
        deadlineStr = deadlineStr.replace(' ', 'T');
      }

      const deadline = new Date(deadlineStr);
      const diffMs = deadline - now;
      const diffHours = diffMs / (1000 * 60 * 60);

      // Notifikasi jika deadline mendekati (kurang dari 24 jam)
      if (diffHours > 0 && diffHours <= 24) {
        fetch(`/send-notification/${taskId}`)
          .then(response => response.text())
          .then(result => {
            console.log("Notifikasi dikirim untuk task " + taskId + ": " + result);
            Swal.fire({
              title: 'Deadline Hampir Tiba!',
              text: `Task ID ${taskId} memiliki deadline kurang dari 24 jam.`,
              icon: 'warning',
              confirmButtonText: 'Oke'
            });
          })
          .catch(error => console.error("Error:", error));
      }

      // Deadline sudah lewat
      if (now > deadline) {
        card.classList.add('disabled-task');

        const subtaskInfos = card.querySelectorAll('.subtask-info');
        subtaskInfos.forEach(info => info.classList.add('disabled-task'));

        const updateButtons = card.querySelectorAll('.update-subtask');
        updateButtons.forEach(btn => {
          btn.classList.add('disabled-task');
          btn.disabled = true;
        });

        const buttons = card.querySelectorAll('#editz, #tambah-subtasks');
        buttons.forEach(btn => {
          btn.disabled = true;
        });
      }
    }
  });

  /**
   * Modul: Deadline Checker
   * Memeriksa deadline setiap .todo-card dan mengirim notifikasi jika deadline mendekati.
   * Jika deadline sudah lewat, nonaktifkan tombol pada card tersebut.
   */
}


document.addEventListener("DOMContentLoaded", function(){
  initDeadlineChecker();
  setInterval(initDeadlineChecker, 1 * 60 * 1000);
});