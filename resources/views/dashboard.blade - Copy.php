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
<style>
  .priority-tinggi { background-color: #ffcccc; }
  .priority-sedang { background-color: #fff3cd; }
  .priority-rendah { background-color: #d4edda; }
  .disabled-tak {
    background-color: grey;
    opacity: 0.7;
  }
  .todo-card:hover {
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  transform: translateY(-2px);
  }
  .bg-priority-high {
  background-color: #fd7e14;
  color: black;
  }

  .bg-priority-medium {
    background-color: #c9b037;
    color: black;
  }

  .bg-priority-low {
    background-color: #adb5bd;
    color: black;
  }
  
</style>
<body class="bg-light">
<div class="dashboard">
<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">To Do List</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
      aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
      <div class="row w-100 d-flex justify-content-between align-items-center">
        <!-- Kolom untuk form pencarian -->
        <div class="col-md-4">
          <form id="todo-form" action="{{ route('dashboard') }}" method="get" class="d-flex">
            <input type="text" class="form-control me-2" name="search" value="{{ request('search') }}" placeholder="Masukkan kata kunci">
            <button class="btn btn-secondary" type="submit">Cari</button>
          </form>
        </div>
        <!-- Kolom untuk filter, sorting, dan profil -->
        <div class="col-md-8 d-flex justify-content-end align-items-center gap-2">
  <!-- Dropdown Filter Priority -->
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Filter Task">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter-square-fill" viewBox="0 0 16 16">
  <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm.5 5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1 0-1M4 8.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m2 3a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5"/>
</svg>
    </button>
    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
      <li><a class="dropdown-item" href="#" data-value="all">Semua Prioritas</a></li>
      <li><a class="dropdown-item" href="#" data-value="tinggi">Tinggi</a></li>
      <li><a class="dropdown-item" href="#" data-value="sedang">Sedang</a></li>
      <li><a class="dropdown-item" href="#" data-value="rendah">Rendah</a></li>
    </ul>
  </div>

  <!-- Dropdown Sort Tasks -->
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="sortTasksDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Sort Task">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-down" viewBox="0 0 16 16">
  <path d="M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z"/>
</svg>
    </button>
    <ul class="dropdown-menu" aria-labelledby="sortTasksDropdown">
      <li><a class="dropdown-item" href="#" data-value="title">Judul Task</a></li>
      <li><a class="dropdown-item" href="#" data-value="priority">Prioritas</a></li>
      <li><a class="dropdown-item" href="#" data-value="deadline">Deadline</a></li>
      <li><a class="dropdown-item" href="#" data-value="created">Tanggal Pembuatan</a></li>
    </ul>
  </div>

  <!-- Dropdown Sort Order -->
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="sortOrderDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Sort Order">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371zm1.57-.785L11 2.687h-.047l-.652 2.157z"/>
  <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293z"/>
</svg>
    </button>
    <ul class="dropdown-menu" aria-labelledby="sortOrderDropdown">
      <li><a class="dropdown-item" href="#" data-value="asc">Ascending</a></li>
      <li><a class="dropdown-item" href="#" data-value="desc">Descending</a></li>
    </ul>
  </div>

          <!-- Dropdown Profil -->
          <div class="dropdown">
            <a class="nav-link dropdown-toggle p-0" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              @if<!--(Auth::user()->profile_photo && file_exists(public_path('uploads/' . Auth::user()->profile_photo)))-->
              <img src="{{ asset($user->profile_photo) }}" alt="Profile" class="rounded-circle" width="30" height="30">
              @else
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle text-secondary" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>
                @endif
              </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
              <li><a class="dropdown-item" href="{{ route('profile') }}">Profil</a></li>
              <li>
                <form action="{{ url('/sesi/logout') }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="dropdown-item">Logout</button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>






  
<div class="container mt-4">
  <!-- 01. Content-->
  <div class="row justify-content-center">
    <!--<h1>Selamat datang, {{ Auth::user()->name }}!</h1>-->
    <div class="mb-3">
    <div class="col-md-12">
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
  <div class="row mb-4 mt-5">
    <div class="col-md-4">
      <div class="card text-white bg-warning mb-3">
        <div class="card-header">Belum Selesai</div>
        <div class="card-body">
          <h5 class="card-title">{{ $belumSelesai }}</h5>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-success mb-3">
        <div class="card-header">Selesai</div>
        <div class="card-body">
          <h5 class="card-title">{{ $selesai }}</h5>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-danger mb-3">
        <div class="card-header">Terlambat</div>
        <div class="card-body">
          <h5 class="card-title">{{ $terlambat }}</h5>
        </div>
      </div>
    </div>
  </div>
  <!-- Bagian Laporan dalam bentuk chart -->
  <!--<div class="row mb-4">
    <div class="col-md-12">
      <canvas id="reportChart" width="400" height="150"></canvas>
    </div>
  </div>-->
  <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahTaskModal">
  Tambah Task
</button>
        </div>
      </div>
    </div>
    <div class="container task-container col-md-12">
  <div class="row" id="todo-list">
    @foreach ($data as $item)
      <div class="col-12 col-md-6 mb-3">
        <div class="card 
                    @if($item->prioritas == 'tinggi') priority-tinggi
                    @elseif($item->prioritas == 'sedang') priority-sedang
                    @elseif($item->prioritas == 'rendah') priority-rendah
                    @endif 
                    todo-card"
             data-priority="{{ $item->prioritas }}"
             data-deadline="{{ $item->deadline}}"
             data-task-id="{{ $item->id_task }}"
             data-created="{{ $item->created_at }}"
             data-status-task="{{ $item->status_task }}">
          <div class="card-header bg-primary text-white">
  <div class="row w-100">
    <!-- Baris pertama: Judul -->
    <div class="col-12">
      <h3 class="task-title mb-0">
        <span class="task-text">{{ $item->judul_task }}</span>
      </h3>
    </div>
    <!-- Baris kedua: Waktu dibuat & Badge -->
    <div class="col-6">
      <!--<small class="task-date text-light">Tanggal Pembuatan: {{ $item->created_at }}</small>-->
      <small class="task-date text-light" data-date="{{ $item->created_at }}">Tanggal Pembuatan: <span class="tanggal-format"></span>
</small>
    </div>
    <div class="col-6 text-end">
      <span class="badge bg-priority-medium">Prioritas: {{ $item->prioritas }}</span>
    </div>
  </div>
</div>


          <div class="card-body">
            <div class="subtask-info mb-3">
              <h6 class="mb-2">Subtask:</h6>
              <ul class="list-group list-group-flush overflow-auto" style="max-height: 200px;">
                @foreach ($item->subtasks as $subtask)
                
              
                  <li class="list-group-item listSubtask">
                    <label>
                      <input type="checkbox" class="subtask-checkbox" data-id="{{ $subtask->id_subtask }}"
                        @if($subtask->status_subtask == 'selesai') checked 
                        @endif>
                      {{ $subtask->judul_subtask }}
                    </label>
                    <p class="subtask-desc mb-0">
                      Keterangan: {{ $subtask->keterangan_subtask }}
                    </p>
                    <button id="update-subtasks" type="button" class="btn btn-outline-primary btn-sm update-subtask">Edit Subtask</button>
                    <button type="button" class="btn btn-outline-danger btn-sm delete-subtask" data-id="{{ $subtask->id_subtask }}">Hapus Subtask</button>
                  </li>
                @endforeach
              </ul>
            </div>
            <hr>
            <div class="due-date">
              <!--<span class="d-block mb-2">
                Waktu Tenggat: {{ $item->deadline }}
              </span>-->
              <span class="d-block mb-2" data-date="{{ $item->deadline }}">Waktu Tenggat: <span class="tanggal-format"></span></span>
              <span class="d-block mb-2">
                Prioritas: {{ $item->prioritas }}
              </span>
              <span class="d-block mb-2">
                Status Task: {{ $item->status_task }}
              </span>
            </div>
          </div>
          <div class="card-footer bg-light d-flex justify-content-between align-items-center">
            <div class="btn-group gap-2">
              <button id="tambah-subtasks" type="button" class="btn btn-outline-primary btn-sm tambah-subtask">
                Tambah Subtask
              </button>
              <form class="update-status-form" data-action="{{ route('dashboard.updateStatus', ['id_task' => $item->id_task]) }}" method="POST">
                  @csrf
                  <input type="hidden" name="status_task" data-id="{{ $item->id_task }}" value="{{ $item->status_task === 'selesai' ? 'belum_selesai' : 'selesai' }}">
                  <button id="selesaiii" type="button" class="btn btn-sm done-btn {{ $item->status_task === 'selesai' ? 'btn-warning' : 'btn-primary' }}" data-id="{{ $item->id }}">
                    {{ $item->status_task === 'selesai' ? 'Batalkan' : 'Selesai' }}
                  </button>
                </form>
              <form class="formDilet" >
                @csrf
                <!--@method('delete')-->
                <button id="dilet" type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $item->id_task }}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash2-fill" viewBox="0 0 16 16">
  <path d="M2.037 3.225A.7.7 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2a.7.7 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671zm9.89-.69C10.966 2.214 9.578 2 8 2c-1.58 0-2.968.215-3.926.534-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466-.18-.14-.498-.307-.975-.466z"/>
</svg></button>
<!-- ✕ -->
              </form>
            </div>
            <button id="editz" type="button" class="btn btn-primary btn-sm edit-btn" 
  data-task="{{ $item->judul_task }}"
  data-keterangan="{{ $item->keterangan_task }}"
  data-deadline="{{ date('Y-m-d\TH:i', strtotime($item->deadline)) }}"
  data-task-id="{{ $item->id_task }}"
  data-status="{{ $item->status_task->value }}">
  ✎
</button>

          </div>
        </div>
      </div>
    @endforeach
  </div>
    </div>
    </div>
  </div>
<!-- Modal Tambah Task -->
<div class="modal fade" id="tambahTaskModal" tabindex="-1" aria-labelledby="tambahTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="tambahhtask">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="tambahTaskModalLabel">Tambah task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="task" class="form-label">Judul task</label>
            <input type="text" class="form-control" name="task" id="task" placeholder="Judul task" value="{{ old('task') }}">
          </div>
          <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan task</label>
            <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan task" value="{{ old('keterangan_task') }}">
          </div>
          <div class="mb-3">
            <label for="subtask" class="form-label">Judul subtask</label>
            <input type="text" class="form-control" name="subtask" id="subtask" placeholder="Tambah subtask" value="{{ old('subtask') }}">
          </div>
          <div class="mb-3">
            <label for="keterangan_subtask" class="form-label">Keterangan subtask</label>
            <input type="text" class="form-control" name="keterangan_subtask" id="keterangan_subtask" placeholder="Tambahkan keterangan subtask" value="{{ old('keterangan_subtask') }}">
          </div>
          <div class="mb-3">
            <label for="prioritas" class="form-label">Prioritas</label>
            <select class="form-select" id="prioritas" name="prioritas">
              <option value="rendah">Rendah</option>
              <option value="sedang" selected>Sedang</option>
              <option value="tinggi">Tinggi</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="deadline" class="form-label">Deadline</label>
            <input type="datetime-local" class="form-control" id="deadline" name="deadline">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Tambahkan task</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal update task -->
<div class="modal fade" id="modalUpdateTask" tabindex="-1" aria-labelledby="modalUpdateTaskLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formUpdateTask">
          @csrf
          <input type="hidden" name="id_task" id="updateTaskId">
          <input type="hidden" name="status_task" id="updateTaskStatus">

          <div class="mb-3">
            <label class="form-label">Judul Task</label>
            <input type="text" class="form-control" name="task" id="updateTaskTitle" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Keterangan Task</label>
            <input type="text" class="form-control" name="keterangan" id="updateTaskDescription">
          </div>

          <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input type="datetime-local" class="form-control" name="deadline" id="updateTaskDeadline">
          </div>

          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Subtask -->
<div class="modal fade" id="modalTambahSubtask" tabindex="-1" aria-labelledby="modalTambahSubtaskLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formTambahSubtask" method="post">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahSubtaskLabel">Tambah subtask</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id_task" name="id_task">
          <div class="mb-3">
            <label for="judul_subtask" class="form-label">Judul subtask</label>
            <input type="text" class="form-control" id="judul_subtask" name="judul_subtask">
          </div>
          <div class="mb-3">
            <label for="keterangan_subtask" class="form-label">Keterangan subtask</label>
            <textarea class="form-control" id="keterangan_subtask" name="keterangan_subtask"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Tambahkan subtask</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Update Subtask -->
<div class="modal fade" id="modalUpdateSubtask" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formUpdateSubtask">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Edit subtask</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_task">
          <input type="hidden" name="id_subtask">
          <div class="mb-3">
            <label class="form-label">Judul subtask</label>
            <input type="text" name="judul_subtask" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Keterangan subtask</label>
            <textarea name="keterangan_subtask" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Edit subtask</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
  </div>
</div>

<!-- Bootstrap JS Bundle (popper.js included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Muat Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  (function() {
    "use strict";
    
    /**
     * Modul: Subtask Modal
     * Menangani klik tombol dengan kelas "tambah-subtask" untuk menampilkan modal tambah subtask.
     */
    function initSubtaskModal() {
      document.addEventListener("click", function(event) {
        var tambahBtn = event.target.closest(".tambah-subtask");
        if (!tambahBtn) return;
        event.preventDefault();
        var taskElement = tambahBtn.closest(".todo-card");
        if (!taskElement) {
          alert("Task element tidak ditemukan!");
          return;
        }
        var taskId = taskElement.getAttribute("data-task-id");
        if (!taskId) {
          alert("ID Task tidak ditemukan!");
          return;
        }
        // Set nilai id_task pada modal
        var idTaskInput = document.getElementById("id_task");
        if (idTaskInput) {
          idTaskInput.value = taskId;
        }
        // Tampilkan modal (pastikan elemen modal dengan id "modalTambahSubtask" ada)
        var modalEl = document.getElementById("modalTambahSubtask");
        if (modalEl) {
          var modal = new bootstrap.Modal(modalEl);
          modal.show();
        }
      });
    }
    

    /**
     * Modul: Validasi Form Utama (tambah task)
     */
    /*****function initMainFormValidation() {
  var modalTask = document.getElementById("tambahTaskModal");
  if (!modalTask) return;

  // Cari form khusus di dalam modal
  var todoForm = modalTask.querySelector("#todo-form");
  if (!todoForm) return;

  todoForm.addEventListener("submit", function (e) {
    var missingFields = [];
    var invalidFields = [];

    var fields = [
      { id: "task", label: "Judul Task", regex: /^[a-zA-Z0-9 ]+$/, errorMsg: "Task hanya boleh berisi huruf, angka, spasi, dan @" },
      { id: "keterangan", label: "Keterangan Task", regex: /^[a-zA-Z0-9 ]+$/, errorMsg: "Keterangan hanya boleh berisi huruf, angka, spasi, dan @" },
      { id: "subtask", label: "Judul Subtask", regex: /^[a-zA-Z0-9 ]+$/, errorMsg: "Subtask hanya boleh berisi huruf, angka, dan spasi" },
      { id: "keterangan_subtask", label: "Keterangan Subtask", regex: /^[a-zA-Z0-9 ]+$/, errorMsg: "Keterangan Subtask hanya boleh berisi huruf, angka, dan spasi" },
      { id: "prioritas", label: "Prioritas", regex: /.+/, errorMsg: "Pilih prioritas yang tersedia" },
      { id: "deadline", label: "Deadline" }
    ];

    fields.forEach(function (field) {
      // Batasi pencarian elemen hanya dalam form todoForm
      var input = todoForm.querySelector('#' + field.id);
      if (input) {
        var value = input.value.trim();
        if (value === "") {
          missingFields.push(field.label);
        } else if (field.regex && !field.regex.test(value)) {
          invalidFields.push(field.errorMsg);
        }
      }
    });

    // Tampilkan pesan kesalahan jika ada
    if (missingFields.length > 0) {
      e.preventDefault();
      Swal.fire({
        icon: "warning",
        title: "Field belum terisi!",
        html: "<strong>Field kosong:</strong><br>" + missingFields.join(", "),
        confirmButtonText: "Mengerti"
      });
    } else if (invalidFields.length > 0) {
      e.preventDefault();
      Swal.fire({
        icon: "warning",
        title: "Field tidak valid!",
        html: "<strong>Field tidak valid:</strong><br>" + invalidFields.join("<br>"),
        confirmButtonText: "Mengerti"
      });
    }
  });
}*/
  
    function initLaporan () {
      const ctx = document.getElementById('reportChart').getContext('2d');
      const reportChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Belum Selesai', 'Selesai', 'Terlambat'],
          datasets: [{
            label: 'Jumlah Task',
            data: [{{ $belumSelesai }}, {{ $selesai }}, {{ $terlambat }}],
            backgroundColor: [
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(255, 99, 132, 1)'
            ],borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }


function initUpdateSubtaskModal() {
  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('update-subtask')) {
      e.preventDefault();
      const button = e.target;

      const listItem = button.closest('.listSubtask');
      if (!listItem) return;

      const subtaskCheckbox = listItem.querySelector('.subtask-checkbox');
      const idSubtask = subtaskCheckbox ? subtaskCheckbox.getAttribute('data-id') : null;

      const labelEl = listItem.querySelector('label');
      const judulSubtask = labelEl ? labelEl.innerText.trim() : '';

      const subtaskDescEl = listItem.querySelector('.subtask-desc');
      const keteranganSubtask = subtaskDescEl ? subtaskDescEl.innerText.replace('Keterangan:', '').trim() : '';

      const card = button.closest('.todo-card');
      const idTask = card ? card.getAttribute('data-task-id') : null;

      Swal.fire({
        title: 'Ingin update subtask?',
        text: "Data subtask akan dimuat ke form update.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Edit subtask!',
        cancelButtonText: 'Tidak'
      }).then(function(result) {
        if (result.isConfirmed) {
          const modalEl = document.getElementById('modalUpdateSubtask');
          if (modalEl) {
            const form = modalEl.querySelector('form');
            if (form) {
              form.querySelector('input[name="id_subtask"]').value = idSubtask;
              form.querySelector('input[name="id_task"]').value = idTask;
              form.querySelector('input[name="judul_subtask"]').value = judulSubtask;
              form.querySelector('textarea[name="keterangan_subtask"]').value = keteranganSubtask;
            }

            const modal = new bootstrap.Modal(modalEl);
            modal.show();

            Swal.fire({
              icon: "success",
              title: "Edit subtask",
              text: "Silakan edit data subtask."
            });
          } else {
            Swal.fire("Modal update subtask tidak ditemukan.", "", "error");
          }
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            icon: "info",
            title: "Update dibatalkan",
            text: "Subtask tidak jadi diupdate.",
            showConfirmButton: false
          });
        }
      });
    }
  });
}

function initUpdateTaskModal() {
  document.addEventListener("click", function (event) {
    const button = event.target.closest(".edit-btn");
    if (!button) return;

    const taskId = button.dataset.taskId;
    const taskTitle = button.dataset.task;
    const taskDescription = button.dataset.keterangan;
    const taskDeadline = button.dataset.deadline;
    const taskStatus = button.dataset.status;
    
    document.getElementById("updateTaskStatus").value = taskStatus;
    document.getElementById("updateTaskId").value = taskId;
    document.getElementById("updateTaskTitle").value = taskTitle;
    document.getElementById("updateTaskDescription").value = taskDescription;
    document.getElementById("updateTaskDeadline").value = taskDeadline;

    const modal = new bootstrap.Modal(document.getElementById("modalUpdateTask"));
    modal.show();
  });
}


document.addEventListener("DOMContentLoaded", function () {
  initUpdateTaskModal();
});


function initTaskUpdateForm() {
  var formUpdateTask = document.getElementById("formUpdateTask");
  if (!formUpdateTask) return;

  formUpdateTask.addEventListener("submit", function(e) {
    e.preventDefault();

    var formData = new FormData(formUpdateTask);
    var taskId = document.getElementById("updateTaskId").value;

    fetch(`/dashboard/update/${taskId}`, {
      method: "POST",
      body: formData,
      headers: {
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        "X-HTTP-Method-Override": "PUT",
        "Accept": "application/json"
      }
    })
    .then(response => response.json())
    .then(function(data) {
      if (data.success) {
        Swal.fire(data.message, "", "success");

        // Perbarui data pada tombol edit agar tidak perlu refresh
        var button = document.querySelector(`.edit-btn[data-task-id='${taskId}']`);
        if (button) {
          button.dataset.task = data.task.judul_task;
          button.dataset.keterangan = data.task.keterangan_task;
          button.dataset.deadline = data.task.deadline;
        }

        // Tutup modal
        var modalEl = document.getElementById("modalUpdateTask");
        var modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
      } else {
        Swal.fire(data.message, "", "warning");
      }
    })
    .catch(function(error) {
      Swal.fire("Terjadi kesalahan!", error, "error");
    });
  });
}


function initTaskModal() {
  // Gunakan event delegation untuk mendeteksi klik pada tombol tambah task
  document.addEventListener("click", function(event) {
    var tambahTaskBtn = event.target.closest(".tambah-task");
    if (!tambahTaskBtn) return;
    
    event.preventDefault();
    
    // Tampilkan modal dengan id "tambahTaskModal"
    var modalEl = document.getElementById("tambahTaskModal");
    if (modalEl) {
      var modal = new bootstrap.Modal(modalEl);
      modal.show();
    }
  });
}


    document.addEventListener("DOMContentLoaded", function() {
      try { initSubtaskModal(); } catch (e) { console.error("Error in initSubtaskModal:", e); }
      try { initLaporan(); } catch (e) { console.error("error ini initTema:", e); }
      try { initUpdateSubtaskModal(); } catch (e) { console.error("error ini initTema:", e); }
      try { initupdateTaskModal(); } catch (e) { console.error("error ini initTema:", e); }
      try { initTaskModal(); } catch (e) { console.error("error ini initTema:", e); }
    });
  })();
</script>
<script>
  window.routes = {
    subtaskStore: "{{ route('subtask.store') }}",
    subtaskUpdate: "{{ route('subtask.updateStatussub', ':id_subtask') }}",
    subtaskStatus: "{{ route('subtask.status', ':id_subtask') }}",
    updateSubtaskForm: "{{ route('subtask.updateSubtask') }}",
    deleteSubtask: "{{ route('subtask.deleteSubtask') }}",
    taskStore: "{{ route('dashboard.store') }}",
    updateTask: "{{ route('dashboard.update', ':id_task') }}",
    deleteTask: "{{ route('dashboard.delete', ':id_task') }}",
    updateTaskStatus: "{{ url('/dashboard/updateStatus/:id_task') }}",
  };
  </script>
<script type="module" src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/initTaskStatusUpdater.js') }}"></script>
<script src="{{ asset('js/initTaskForm.js') }}"></script>
<script src="{{ asset('js/initTaskUpdateForm.js') }}"></script>
<script src="{{ asset('js/initSubtaskUpdateForm.js') }}"></script>
<script src="{{ asset('js/initDeleteSubtask.js') }}"></script>
<script src="{{ asset('js/initDeleteTask.js') }}"></script>
<script src="{{ asset('js/initSubtaskForm.js') }}"></script>
<script src="{{ asset('js/initSubtaskCheckboxes.js') }}"></script>
<script src="{{ asset('js/initDeadlineChecker.js') }}"></script>
<script src="{{ asset('js/initBadge.js') }}"></script>
<script src="{{ asset('js/initDatetimeLocal.js') }}"></script>
<script src="{{ asset('js/initNavbarAdjustment.js') }}"></script>
<script src="{{ asset('js/initToastNotification.js') }}"></script>
<script src="{{ asset('js/initTaskSort.js') }}"></script>
<script src="{{ asset('js/initTaskFilter.js') }}"></script>
<script>
  // Fungsi untuk konversi waktu ke format lokal Indonesia
  function formatTanggalIndo(datetimeStr) {
    const options = {
      day: "2-digit",
      month: "long",
      year: "numeric",
      hour: "2-digit",
      minute: "2-digit",
      hour12: false,
    };
    const date = new Date(datetimeStr);
    if (isNaN(date)) return datetimeStr; // Jika gagal parse, tampilkan apa adanya
    return date.toLocaleString("id-ID", options);
  }

  // Jalankan saat halaman selesai dimuat
  document.addEventListener("DOMContentLoaded", function () {
    // Cari semua elemen yang punya atribut data-date
    document.querySelectorAll("[data-date]").forEach(function (el) {
      const rawDate = el.getAttribute("data-date");

      // Jika elemen memiliki <span class="tanggal-format"> di dalamnya
      const span = el.querySelector(".tanggal-format");
      if (span) {
        span.textContent = formatTanggalIndo(rawDate);
      } else {
        // Jika tidak ada span, ganti isi elemen langsung
        el.textContent = formatTanggalIndo(rawDate);
      }
    });
  });
</script>
</body>
</html>