<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Halaman login resmi Aplikasi Tugas Siswa untuk manajemen tugas harian.">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <title>Login</title>
    <style>
      /* Mengatur card agar memiliki lebar tetap */
      .fixed-card {
        width: 400px;
        margin: auto;
      }
    </style>
  </head>
  <body>
    <div class="container my-5">
      <div class="row justify-content-center">
        <!-- Menggunakan class fixed-card untuk menjaga lebar tetap -->
        <div class="fixed-card">
          <div class="card shadow-sm">
            <div class="card-header text-center">
              <h3>Login website M4TT</h3>
            </div>
            <div class="card-body">
              <form action="/sesi/login" method="post">
                @csrf
                <div class="mb-3">
                  <label for="login" class="form-label">Email</label>
                  <input
                    type="text"
                    name="login"
                    value="{{ old('login') }}"
                    class="form-control"
                    placeholder="Masukkan Email"
                  />
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Masukkan Password"
                  />
                </div>
                <button id="Login" type="submit" class="btn btn-primary w-100">
                  Login
                </button>
              </form>
            </div>
            <div class="card-footer text-center">
              <a href="/sesi/lupapw" class="btn btn-link">Belum punya akun?</a>
              <a href="/sesi/register" class="btn btn-link">Register</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("form");

        form.addEventListener("submit", function (e) {
          let missingFields = [];

          // Mendapatkan elemen input
          const email = document.querySelector("input[name='login']");
          const password = document.querySelector("input[name='password']");

          // Validasi field kosong
          if (!email.value.trim()) {
            missingFields.push("Username/Email");
          }
          if (!password.value.trim()) {
            missingFields.push("Password");
          }

          // Jika ada field yang kosong, tampilkan notifikasi dengan format seperti halaman register
          if (missingFields.length > 0) {
            e.preventDefault();
            Swal.fire({
              icon: "warning",
              title: "Login tidak valid",
              html:
                "<strong>Field kosong:</strong><br>" +
                missingFields.join(", "),
              confirmButtonText: "Mengerti"
            });
          } else {
            this.submit();
          }
        });
      });
    </script>
  </body>
</html>
