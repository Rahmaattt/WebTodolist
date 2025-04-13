function initNotifikasiDeadline() {
  const now = new Date();
  const cards = document.querySelectorAll('.todo-card');

  cards.forEach(card => {
    let deadlineStr = card.getAttribute('data-deadline');
    const taskId = card.getAttribute('data-task-id');

    if (deadlineStr && taskId) {
      if (deadlineStr.includes(' ')) {
        deadlineStr = deadlineStr.replace(' ', 'T');
      }

      const deadline = new Date(deadlineStr);
      const diffMs = deadline - now;
      const diffHours = diffMs / (1000 * 60 * 60);

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
}


document.addEventListener("DOMContentLoaded", function(){
  initNotifikasiDeadline();
  setInterval(initDeadlineChecker, 1 * 60 * 1000);
});