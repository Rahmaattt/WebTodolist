<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- csrf untuk json -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>To Do List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
  <!-- CSS untuk Warna Prioritas -->
<style>
  .priority-tinggi { background-color: #ffcccc; }
  .priority-sedang { background-color: #fff3cd; }
  .priority-rendah { background-color: #d4edda; }
  .disabled-task {
    background-color: grey;
    opacity: 0.7;
  }
</style>
<body class="bg-light">
  <!-- 00. Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid col-md-7">
      <div class="navbar-brand">To Do List</div>
      <form action="{{ url('/sesi/logout') }}" method="POST">
        @csrf
      <button type="submit">Logout</button>
    </form>
      </div>
    </div>
  </nav>
  
  
  <div class="container mt-4">
  <!-- 01. Content-->
  <h1 class="text-center mb-4">To Do List</h1>
  <div class="row justify-content-center">
    <h1>Selamat datang, {{ Auth::user()->name }}!</h1>
    <div class="col-md-8">
      <div class="card mb-3">
        <div class="card-body">
          @if (session('sukses'))
            <div class="alert alert-success">
              {{ session('sukses')}}
            </div>
          @endif
          @if($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
             </ul>
           </div>
          @endif
          <!-- 02. Form input data -->
          <form id="todo-form" action="/dashboard/add" method="post">
  @csrf
  <!-- Field untuk Task -->
  <div class="mb-3">
    <label for="task" class="form-label">Task</label>
    <input type="text" class="form-control" name="task" id="task" placeholder="Tambah task baru" value="{{ old('task') }}" required>
  </div>
  
  <!-- Field untuk Keterangan Task -->
  <div class="mb-3">
    <label for="keterangan" class="form-label">Keterangan Task</label>
    <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Tambahkan keterangan task" value="{{ old('keterangan') }}" required>
  </div>
  
  <!-- Field untuk Subtask -->
  <div class="mb-3">
    <label for="subtask" class="form-label">Subtask</label>
    <input type="text" class="form-control" name="subtask" id="subtask" placeholder="Tambah subtask" value="{{ old('subtask') }}" required>
  </div>
  
  <!-- Field untuk Keterangan Subtask -->
  <div class="mb-3">
    <label for="keterangan_subtask" class="form-label">Keterangan Subtask</label>
    <input type="text" class="form-control" name="keterangan_subtask" id="keterangan_subtask" placeholder="Tambahkan keterangan subtask" value="{{ old('keterangan_subtask') }}" required>
  </div>
  
  <!-- Field untuk Prioritas -->
  <div class="mb-3">
    <label for="prioritas" class="form-label">Prioritas</label>
    <select class="form-select" id="prioritas" name="prioritas" required>
      <option value="kecil">Kecil</option>
      <option value="sedang" selected>Sedang</option>
      <option value="tinggi">Tinggi</option>
    </select>
  </div>
  
  <!-- Field untuk Deadline -->
  <div class="mb-3">
    <label for="deadline" class="form-label">Deadline</label>
    <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
  </div>
  
  <!-- Tombol Submit -->
  <button class="btn btn-primary" type="submit">Simpan</button>
</form>

          <!--<form id="todo-form" action="/dashboard/add" method="post">
            @csrf
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="task" id="todo-input" placeholder="Tambah task baru" value="{{ old('task') }}" required>
              <input type="text" class="form-control" name="keterangan" id="todo-input" placeholder="Tambahkan keterangan task" value="{{ old('keterangan') }}" required>
              
              
              <input type="text" class="form-control" name="subtask" id="todo-input" placeholder="Tambah task baru" value="{{ old('subtask') }}" required>
              <input type="text" class="form-control" name="keterangan_subtask" id="todo-input" placeholder="Tambahkan keterangan task" value="{{ old('keterangan_subtask') }}" required>
              
              
              <div class="mb-3">
                <label for="priority" class="form-label">Prioritas</label>
                <select class="form-control" id="prioritas" name="prioritas" required>
                  <option value="kecil">Kecil</option>
                  <option value="sedang" selected>Sedang</option>
                  <option value="tinggi">Tinggi</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
                </div>
    
              
              
              <button class="btn btn-primary" type="submit">Simpan
              </button>
            </div>
          </form>-->
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <!-- 03. Searching -->
          <form id="todo-form" action="{{ route('dashboard') }}" method="get">
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="masukkan kata kunci">
              <button class="btn btn-secondary" type="submit">Cari
              </button>
            </div>
          </form>
          <!-- Filter Prioritas -->
          <div class="mb-3">
            <label for="filter-priority" class="form-label">Filter Prioritas:</label>
            <select id="filter-priority" class="form-select">
              <option value="all">Semua Prioritas</option>
              <option value="tinggi">Tinggi</option>
              <option value="sedang">Sedang</option>
              <option value="rendah">Rendah</option>
            </select>
          </div>
          <ul class="list-group mb-4" id="todo-list">
            @foreach ($data as $item)
            <!-- 04. Display Data -->
            <li class="list-group-item d-flex justify-content-between align-items-center ">
              <div class="card w-100 
              @if($item->prioritas == 'tinggi') priority-tinggi
              @elseif($item->prioritas == 'sedang') priority-sedang
              @elseif($item->prioritas == 'rendah') priority-rendah
              @endif todo-card" data-priority="{{ $item->prioritas }}" data-deadline="{{ $item->deadline}}" data-task-id="{{ $item->id_task }}">
              <div class="card-header">
                <h3 class="task-title">
                <span class="task-text">
                  {!! $item->status_task == 'selesai'?'<del>':'' !!}
              
                  {{$item->judul_task}}
                
                  {!! $item->status_task == 'selesai'?'</del>':'' !!}
                </span>
                </h3>
                <span class="task-date">Tanggal Pembuatan: {{ $item->created_at}}
                </span>
              </div>
              <!--<div class="card-body">
                <span class="task-text">
                  {!! $item->status_task == 'selesai'?'<del>':'' !!}
                
                    {{$item->keterangan_task}}
                  
                  {!! $item->status_task == 'selesai'?'</del>':'' !!}
                </span>-->
                <div class="subtask-info">
  <h4>Subtask:</h4>
  <ul>
    @foreach ($item->subtasks as $subtask)
    <li>
      <label>
        <input type="checkbox" class="subtask-checkbox" data-id="{{ $subtask->id_subtask }}"
          @if($subtask->status_subtask == 'selesai') checked @endif> 
        {{ $subtask->judul_subtask }}
      </label>
      <p class="subtask-desc">Keterangan: {{ $subtask->keterangan_subtask }}</p>
    </li>
    @endforeach
  </ul>
</div>

                <!--<div class="subtask-info">
                  @foreach ($item->subtasks as $subtask)
                  <h4>Subtask:</h4>
                  <ul>
                    <li>
                      <label>
                        <input type="checkbox"> {{ $subtask->judul_subtask }}
                      </label>
                      <p>Keterangan: Membuat desain tampilan form login dengan elemen input dan tombol login.</p>
                    </li>
                  </ul>
                  @endforeach
                </div>-->
                <!--<div class="subtasks">
                  <label>
                    <span class="task-text">
                      {!! $item->status_subtask == '1'?'<del>':'' !!}
                      {{$item->judul_subtask}}
                      {!! $item->status_subtask == '1'?'</del>':'' !!}
                    </span>
                    <input type="checkbox" class="form-control edit-input subtask-checkbox" style="display: none;" value="{{$item->judul_subtask}}">
                  </label>
                  <label>
                  <input type="checkbox" class="subtask-checkbox">Subtask 2</label>
                  <label>
                  <input type="checkbox" class="subtask-checkbox">Subtask 3</label>
                </div> -->
                <div class="due-date">
                  <span class="d-block mb-2">Waktu Tenggat: {{$item->deadline}}
                  </span>
                  <span class="data-priority d-block mb-2">
                    prioritas: {{$item->prioritas}}
                  </span>
                  <span class="d-block mb-2">Status task: {{$item->status_task}}
                  </span>
                  <!--diluar card-->
              
              
                  <span class="task-text">
                    {!! $item->status_subtask == 'selesai'?'<del>':'' !!}
              
                    {{$item->judul_subtask}}
                
                    {!! $item->status_subtask == 'selesai'?'</del>':'' !!}
                  </span>
                  <div class="btn-group">
                    <!--<form class="update-status-form" action="{{ route('dashboard.updateStatus', ['id_task' => $item->id_task]) }}" method="POST">
                      @csrf
                      <input type="hidden" name="status_task" value="{{ $item->status_task === 'selesai' ? 'belum_selesai' : 'selesai' }}">
                      <button type="submit" class="btn btn-success btn-sm done-btn">
                        {{ $item->status_task === 'selesai' ? 'Batalkan' : 'Selesai' }}
                      </button>
                    </form>-->
                    <form class="tambah-subtask" method="post">
                      <button type="button">tambah subtask</button>
                    </form>
                    
                    
                    <!-- Modal Tambah Subtask -->
<div class="modal fade" id="modalTambahSubtask" tabindex="-1" aria-labelledby="modalTambahSubtaskLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTambahSubtaskLabel">Tambah Subtask</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formTambahSubtask" method="POST">
          @csrf
          <input type="hidden" id="id_task" name="id_task">
          <div class="mb-3">
            <label for="judul_subtask" class="form-label">Judul Subtask</label>
            <input type="text" class="form-control" id="judul_subtask" name="judul_subtask" required>
          </div>
          <div class="mb-3">
            <label for="keterangan_subtask" class="form-label">Keterangan</label>
            <textarea class="form-control" id="keterangan_subtask" name="keterangan_subtask"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

                    
                    
                    
                    
                    
                    
                    <form class="update-status-form" data-action="{{ route('dashboard.updateStatus', ['id_task' => $item->id_task]) }}" method="POST">
                      @csrf
                      <input type="hidden" name="status_task" value="{{ $item->status_task === 'selesai' ? 'belum_selesai' : 'selesai' }}">
                      <button type="button" class="btn btn-sm done-btn {{ $item->status_task === 'selesai' ? 'btn-warning' : 'btn-success' }}">
                        {{ $item->status_task === 'selesai' ? 'Batalkan' : 'Selesai' }}
                      </button>
                    </form>

                    
                    
                    <form action="{{ route('dashboard.delete', ['id_task'=>$item->id_task]) }}" method="post" onsubmit="return confirm('Apakah akan dihapus')">
                    @csrf
                    @method ('delete')
                    <button id="dilet" class="btn btn-danger btn-sm delete-btn">✕
                    </button>
                  </form>
                  <button id="editz"class="btn btn-primary btn-sm edit-btn" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->index }}" aria-expanded="false">✎
                  </button>
                </div>
              </li>
              <!-- 05. Update Data -->
              <li class="list-group-item collapse" id="collapse-{{ $loop->index }}">
              <form action="{{ route('dashboard.update', ['id_task'=>$item]) }}" method="POST">
                @csrf
                @method('put')
                <div>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" name="task" value="{{$item->judul_task}}">
                    <button class="btn btn-outline-primary" type="submit">Update</button>
                  </div>
                  <div class="input-group mb-3">
                    </div>
                  </div>
                </form>
                </li>
                @endforeach
                </div>
              </div>
            </div>
            

          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS Bundle (popper.js included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js">
</script>
    <!-- JavaScript untuk Filter Prioritas -->
  <!--<script>
    /* document.getElementById('filter-priority').addEventListener('change', function() {
      const selectedPriority = this.value;
      document.querySelectorAll('.todo-card').forEach(card => {
        const taskPriority = card.getAttribute('data-priority');
        card.style.display = (selectedPriority === 'all' || taskPriority === selectedPriority) ? 'flex' : 'none';
      });
    }); */
    
    document.getElementById('filter-priority').addEventListener('change', function() {
    const selectedPriority = this.value;
    const cards = document.querySelectorAll('.todo-card');

    cards.forEach(function(card) {
        // Ambil nilai atribut data-priority dari card
        const cardPriority = card.getAttribute('data-priority');

        // Jika filter kosong (Semua) atau sesuai dengan data-priority, tampilkan card
        if (selectedPriority === "" || cardPriority === selectedPriority) {
            card.style.display = "";
        } else if (selectedPriority === "all" ) {
          card.style.display = "";
        } else {
            card.style.display = "none";
        }
    });
    
    
    document.addEventListener("DOMContentLoaded", function() {
      const now = new Date();

      const cards = document.querySelectorAll('.todo-card');
      cards.forEach(function(card) {
        const deadlineStr = card.getAttribute('data-deadline');
        if (deadlineStr) {
          // Pastikan deadline dalam format yang bisa diparsing (misalnya ISO)
          const deadline = new Date(deadlineStr);
          if (now > deadline) {
            card.classList.add('disabled-task');
            card.style.display = "none";
          }
        }
      });
    });

});
    
</script>-->
<script>
// Fungsi untuk memeriksa deadline saat halaman dimuat
document.addEventListener("DOMContentLoaded", function() {
  const now = new Date();
  const cards = document.querySelectorAll('.todo-card');
  
  cards.forEach(function(card) {
    let deadlineStr = card.getAttribute('data-deadline');
    if (deadlineStr) {
      // Jika format tanggal berupa "YYYY-MM-DD HH:mm:ss", ganti spasi dengan "T"
      if (deadlineStr.indexOf(' ') > -1) {
        deadlineStr = deadlineStr.replace(' ', 'T');
      }
      const deadline = new Date(deadlineStr);
      if (now > deadline) {
        card.classList.add('disabled-task');
        document.getElementById("dilet").disabled = true;
        document.getElementById("editz").disabled = true;
      }
    }
  });
});

// Event listener untuk filter prioritas (tidak berhubungan langsung dengan deadline)
document.getElementById('filter-priority').addEventListener('change', function() {
  const selectedPriority = this.value;
  const cards = document.querySelectorAll('.todo-card');

  cards.forEach(function(card) {
    const cardPriority = card.getAttribute('data-priority');

    // Tampilkan card jika filter adalah "all" atau jika card memiliki prioritas yang sesuai
    if (selectedPriority === "all" || cardPriority === selectedPriority || selectedPriority === "") {
      card.style.display = "";
    } else {
      card.style.display = "none";
    }
  });
});




/*document.addEventListener("DOMContentLoaded", function() {
  // Event listener untuk tombol "Selesai" pada setiap card
  document.querySelectorAll('.done-btn').forEach(function(button) {
    button.addEventListener('click', function() {
      // Ambil elemen card terdekat
      let card = this.closest('.todo-card');
      let taskId = card.getAttribute('data-task-id');
      let deadlineStr = card.getAttribute('data-deadline');

      // Pastikan format deadline valid (misal, ganti spasi dengan "T" bila perlu)
      if (deadlineStr.indexOf(' ') > -1) {
        deadlineStr = deadlineStr.replace(' ', 'T');
      }
      let deadline = new Date(deadlineStr);
      let now = new Date();

      // Logika penentuan status: default "selesai", namun jika sudah melewati deadline, maka "terlambat"
      let newStatus = now > deadline ? 'terlambat' : 'selesai';

      // Kirim update ke server melalui fetch API (pastikan route di Laravel telah disiapkan)
      fetch(`/dashboard/updateStatus/${taskId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          // CSRF token harus disertakan
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status_task: newStatus })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Ubah tampilan card jika diperlukan, misalnya beri style khusus atau update teks status
          alert('Task telah diperbarui ke status: ' + newStatus);
          // Contoh: Anda bisa menambahkan class atau mengubah konten dalam card
        } else {
          alert('Gagal memperbarui task.');
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
    });
  });
});*/

/*document.addEventListener("DOMContentLoaded", function() {
  // Tambahkan listener untuk setiap form update-status
  document.querySelectorAll('.update-status-form').forEach(function(form) {
    form.addEventListener('submit', function(e) {
      // Ambil elemen card terdekat yang memiliki data deadline
      let card = form.closest('.todo-card');
      let deadlineStr = card.getAttribute('data-deadline');
      // Pastikan format deadline kompatibel (misal, ganti spasi dengan 'T' jika perlu)
      if (deadlineStr.indexOf(' ') > -1) {
          deadlineStr = deadlineStr.replace(' ', 'T');
      }
      let deadline = new Date(deadlineStr);
      let now = new Date();

      // Tentukan status: jika sudah melewati deadline maka 'terlambat', jika belum 'selesai'
      let newStatus = now > deadline ? 'terlambat' : 'selesai';

      // Set nilai input tersembunyi status_task sesuai logika di atas
      form.querySelector('input[name="status_task"]').value = newStatus;
    });
  });
});
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".done-btn").forEach(function (button) {
        button.addEventListener("click", function (event) {
            //event.preventDefault(); // Mencegah submit langsung

            let form = this.closest("form");
            let hiddenInput = form.querySelector("input[name='status_task']");

            if (hiddenInput.value === "selesai") {
                hiddenInput.value = "belum_selesai"; // Ubah ke belum selesai
                this.textContent = "Batalkan"; // Ubah teks tombol
                this.classList.remove("btn-success");
                this.classList.add("btn-warning"); // Ubah warna tombol
            } else {
                hiddenInput.value = "selesai"; // Ubah ke selesai
                this.textContent = "Selesai"; // Ubah teks tombol
                this.classList.remove("btn-warning");
                this.classList.add("btn-success"); // Ubah warna tombol
            }

            form.submit(); // Kirim form setelah perubahan
        });
    });
});*/
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  document.querySelectorAll(".update-status-form").forEach(function(form) {
    let button = form.querySelector(".done-btn");
    let hiddenInput = form.querySelector("input[name='status_task']");
    let card = form.closest(".todo-card"); // Ambil elemen card yang punya deadline
        
    button.addEventListener("click", function (e) {
        e.preventDefault(); // Cegah form reload

        // Ambil deadline dari atribut data
        let deadlineStr = card.getAttribute("data-deadline");
        if (deadlineStr.indexOf(" ") > -1) {
          deadlineStr = deadlineStr.replace(" ", "T"); // Sesuaikan format
        }
        let deadline = new Date(deadlineStr);
        let now = new Date();

        // Tentukan status baru berdasarkan deadline
        let newStatus = now > deadline ? "terlambat" : (hiddenInput.value === "selesai" ? "belum_selesai" : "selesai");
            hiddenInput.value = newStatus;

        // Kirim data dengan AJAX
        let formData = new FormData();
            formData.append("_token", document.querySelector('meta[name="csrf-token"]').content);
        formData.append("status_task", newStatus);

        fetch(form.dataset.action, {
          method: "POST",
          body: formData,
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Update tampilan tombol
            if (data.new_status === "terlambat") {
              button.textContent = "Terlambat";
              button.classList.remove("btn-success", "btn-warning");
              button.classList.add("btn-danger");
            } else if (data.new_status === "selesai") {
              button.textContent = "Batalkan";
              button.classList.remove("btn-success");
              button.classList.add("btn-warning");
              
            } else {
              button.textContent = "Selesai";
              button.classList.remove("btn-warning");
              button.classList.add("btn-success");
            }
          }
        })
      .catch(error => console.error("Error:", error));
    });
  });
});



/*document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".tambah-subtask").forEach(function(button) {
        button.addEventListener("click", function(event) {
            event.preventDefault();

            // Ambil ID task dari elemen terdekat
            let taskElement = button.closest(".todo-card");
            let taskId = taskElement.getAttribute("data-task-id");

            if (!taskId) {
                alert("ID Task tidak ditemukan!");
                return;
            }

            // Set ID task di input form
            document.getElementById("id_task").value = taskId;

            // Tampilkan modal
            let modal = new bootstrap.Modal(document.getElementById("modalTambahSubtask"));
            modal.show();
        });
    });

    // AJAX Submit
    document.getElementById("formTambahSubtask").addEventListener("submit", function(event) {
        event.preventDefault();
        let form = this;
        let formData = new FormData(form);

        fetch("{{ route('subtask.store') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Subtask berhasil ditambahkan!");
                form.reset();
                let modal = bootstrap.Modal.getInstance(document.getElementById("modalTambahSubtask"));
                modal.hide();
            } else {
                alert("Terjadi kesalahan.");
            }
        })
        .catch(error => console.error("Error:", error));
    });
});*/
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".tambah-subtask").forEach(function(button) {
      button.addEventListener("click", function(event) {
        event.preventDefault();
        let taskElement = button.closest(".todo-card");
        let taskId = taskElement.getAttribute("data-task-id");

        // Debugging pakai alert
        alert("ID Task yang dikirim: " + taskId);

        if (!taskId) {
          alert("ID Task tidak ditemukan!");
          return;
        }

        document.getElementById("id_task").value = taskId;

        let modal = new bootstrap.Modal(document.getElementById("modalTambahSubtask"));
        modal.show();
      });
    });

    document.getElementById("formTambahSubtask").addEventListener("submit", function(event) {
        event.preventDefault();
        let form = this;
        let formData = new FormData(form);

        alert("Data yang dikirim: " + JSON.stringify(Object.fromEntries(formData.entries())));
        
        fetch("{{ route('subtask.store') }}", {
          method: "POST",
          body: formData,
          headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Accept": "application/json"
        }
      })
      .then(response => response.text()) // ambil sebagai text dulu
      .then(text => {
          alert("Response mentah: " + text); // cek respons mentah
      try {
        let data = JSON.parse(text);
        alert("Response JSON: " + JSON.stringify(data));
        if (data.success) {
          alert("Subtask berhasil ditambahkan!");
          form.reset();
          let modal = bootstrap.Modal.getInstance(document.getElementById("modalTambahSubtask"));
        modal.hide();
        } else {
          alert("Terjadi kesalahan saat menambah subtask.");
        }
      } catch(e) {
        alert("Error parsing JSON: " + e);
      }
    })
  .catch(error => alert("Error AJAX: " + error));
  });
});





document.addEventListener("DOMContentLoaded", function() {
  // Ambil semua checkbox subtask
  const checkboxes = document.querySelectorAll(".subtask-checkbox");

  checkboxes.forEach(function(checkbox) {
    // Pada saat halaman dimuat, perbarui styling berdasarkan status (jika sudah dicentang, misalnya warnai abu)
    updateSubtaskStyle(checkbox, checkbox.checked);

    checkbox.addEventListener("change", function() {
      const subtaskId = checkbox.getAttribute("data-id");
      const isChecked = checkbox.checked;
      // Tentukan status baru: jika dicentang maka "selesai", jika tidak maka "belum_selesai"
      const newStatus = isChecked ? 'selesai' : 'belum_selesai';

      // Kirim AJAX request untuk mengupdate status di server
      /*fetch(`/subtask/update/${subtaskId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ status_subtask: newStatus })
      })
      .then(response => {
        // Jika server mengembalikan HTML (misalnya karena error) maka kita harus handle-nya
        if (!response.ok) {
          throw new Error("Server response not OK");
        }
        return response.json();
      })
      .then(data => {
        if (data.success) {
          // Update tampilan berdasarkan status baru
          updateSubtaskStyle(checkbox, isChecked);
        } else {
          alert("Gagal mengupdate status subtask");
          // Revert checkbox jika update gagal
          checkbox.checked = !isChecked;
          updateSubtaskStyle(checkbox, !isChecked);
        }
      })*/
      
      fetch(`/subtask/update/${subtaskId}`, {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
  },
  body: JSON.stringify({ status_subtask: newStatus })
})
.then(response => response.text())
.then(text => {
  alert("Response mentah: " + text);
  try {
    const data = JSON.parse(text);
    if (data.success) {
      updateSubtaskStyle(checkbox, checkbox.checked);
    } else {
      alert("Gagal mengupdate status subtask");
      checkbox.checked = !checkbox.checked;
      updateSubtaskStyle(checkbox, checkbox.checked);
    }
  } catch(e) {
    alert("Error parsing JSON: " + e);
  }
})
.catch(error => {
  alert("Error AJAX: " + error);
});

      
      /*.catch(error => {
        console.error("Error updating subtask:", error);
        alert("Terjadi kesalahan saat mengupdate subtask.");
        // Revert checkbox jika terjadi error
        checkbox.checked = !isChecked;
        updateSubtaskStyle(checkbox, !isChecked);
      });*/
    });
  });

  // Fungsi untuk mengubah styling (misalnya warna teks) berdasarkan status checkbox
  function updateSubtaskStyle(checkbox, isChecked) {
    const li = checkbox.closest("li");
    // Misalnya, jika dicentang, ubah warna label dan deskripsi menjadi abu
    if (isChecked) {
      li.querySelector("label").style.color = "gray";
      li.querySelector("p.subtask-desc").style.color = "gray";
    } else {
      li.querySelector("label").style.color = "";
      li.querySelector("p.subtask-desc").style.color = "";
    }
  }
});


</script>
</body>
</html>