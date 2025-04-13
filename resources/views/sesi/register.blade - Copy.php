<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Register</title>
  </head>
  <body>
  <div class="container my-5">
    <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-header text-center">
          <h3>Register</h3>
        </div>
        <div id="Register" class="card-body">
          <form id="registerForm" method="POST" action="{{ route('kirim') }}">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Username</label>
              <input id="Username" type="text" name="name" class="form-control" placeholder="Masukkan Username">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input id="Email" type="text" name="email" class="form-control" placeholder="Masukkan Email">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input id="Password" type="password" name="password" class="form-control" placeholder="Masukkan Password">
            </div>
            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Konfirmasi password</label>
              <input id="Password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Masukkan konfirmasi password">
            </div>
            <button id="Register" type="submit" class="btn btn-primary w-100">Register</button>
          </form>
          @if($errors->any())
            <div class="alert alert-danger mt-3">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
        </div>
        <div class="card-footer text-center">
          <a href="/sesi/lupapw" class="btn btn-link">Lupa Password?</a>
          <a href="/sesi/register" class="btn btn-link">Register</a>
        </div>
      </div>
    </div>
  </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
  document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById("registerForm");

  form.addEventListener("submit", function(e) {
    let missingFields = [];
    let invalidFields = [];

    var fields = [
      { id: "Username", label: "Username", regex: /^[a-zA-Z0-9 ]+$/, errorMsg: "Harap masukkan username yang valid, tanpa simbol." },
      { id: "Email", label: "Email", regex: /^[a-zA-Z0-9@.]+$/, errorMsg: "Harap masukkan email yang valid." },
      { id: "Password", label: "Password", regex: /^[a-zA-Z0-9 ]+$/, errorMsg: "Password hanya boleh berisi huruf, angka, dan spasi." },
      { id: "Password_confirmation", label: "Konfirmasi password", regex: /^[a-zA-Z0-9 ]+$/, errorMsg: "Konfirmasi password hanya boleh berisi huruf, angka, dan spasi." }
    ];

    fields.forEach(function (field) {
      var input = document.getElementById(field.id);
      if (input) {
        var value = input.value.trim();

        // Cek apakah field kosong
        if (value === "") {
          missingFields.push(field.label);
        } 
        // Cek regex validitas
        else if (!field.regex.test(value)) {
          invalidFields.push(field.errorMsg);
        }
      }
    });

    if (missingFields.length > 0 || invalidFields.length > 0) {
      e.preventDefault();
      Swal.fire({
        icon: "warning",
        title: "Gagal mendaftarkan akun",
        html: 
          (missingFields.length > 0 ? "<strong>Field kosong:</strong><br>" + missingFields.join(", ") + "<br><br>" : "") +
          (invalidFields.length > 0 ? "<strong>Field tidak valid:</strong><br>" + invalidFields.join("<br>") : ""),
        confirmButtonText: "Mengerti"
      });
    }
  });
});

  </script>
  </body>
</html>
