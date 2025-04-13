<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile</title>
  <!-- Menggunakan Bootstrap 5 dari CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .profile-img {
      width: 150px;
      height: 150px;
      object-fit: cover;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="row g-4">
          <!-- Kolom foto profil dan informasi dasar -->
          <div class="col-md-4 text-center border-end">
            @if($user->profile_photo)
              <!--<img src="{{ asset('uploads/' . $user->profile_photo) }}" alt="Foto Profil" class="rounded-circle profile-img mb-3">-->
              <img src="{{ asset($user->profile_photo) }}" alt="Foto Profil" class="rounded-circle profile-img mb-3" />
            @else
              <!--<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle text-secondary" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>-->
            @endif
            <h5>{{ $user->name }}</h5>
            <p class="text-muted">{{ $user->email }}</p>
          </div>
          <!-- Kolom form update profile -->
          <div class="col-md-8">
            <h4>Update Profil</h4>
            <!-- Notifikasi jika ada pesan sukses -->
            @if(session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
            @endif
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <!-- Field ganti foto profil -->
              <div class="mb-3">
                <label for="profile_photo" class="form-label">Ganti Foto Profil</label>
                <input type="file" class="form-control" name="profile_photo" id="profile_photo">
                @if($errors->has('profile_photo'))
                  <small class="text-danger">{{ $errors->first('profile_photo') }}</small>
                @endif
              </div>
              <!-- Field update nama -->
              <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}">
              </div>
              <!-- Tambahkan field lain sesuai kebutuhan -->
              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
          </div>
        </div> <!-- end row -->
      </div> <!-- end card-body -->
    </div> <!-- end card -->
  </div> <!-- end container -->

  <!-- Script Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
