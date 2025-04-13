<html lang="en">
  <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Login</title>
</head>
<body>
<div class="container my-5">
<div class="row justify-content-center">
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-header text-center">
        <h3>Update Password</h3>
      </div>
      <div class="card-body">
        <form id="ResetPw" action="/sesi/updatepw" method="post">
          @csrf
          <div class="mb-3">
            <label for="password" class="form-label">Password Baru</label>
            <input id="Password" type="password" name="password" class="form-control" placeholder="Masukkan Password Baru">
          </div>
          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input id="Password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
          </div>
          <button type="submit" class="btn btn-primary w-100">Konfirmasi</button>
        </form>
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
  const form = document.getElementById("ResetPw");

  form.addEventListener("submit", function(e) {
    let missingFields = [];
    let invalidFields = [];

    var fields = [
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
  /*document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");

    form.addEventListener("submit", function(e) {
      e.preventDefault();
      let missingFields = [];

      // Mendapatkan elemen input
      const password = document.querySelector("input[name='parseFloat']");
      const password_confirmation = document.querySelector("input[name='password_confirmation']");

      // Cek apakah masing-masing field sudah diisi
      if (!password.value.trim()) {
        missingFields.push("password");
      }
      if (!password_confirmation.value.trim()) {
        missingFields.push("konfirmasi password");
      }

      // Jika ada field yang kosong, batalkan pengiriman form dan tampilkan notifikasi
      if (missingFields.length > 0) {
        e.preventDefault();
        //alert("harap isi " + missingFields.join(", ") + " sebelum login");
        Swal.fire({
          icon: 'warning',
          title: 'Gagal mendaftarkan akun',
          text: "Harap isi " + missingFields.join(", ") + " sebelum melakukan reset password",
          confirmButtonText: 'Mengerti'
        });
      } else {
      this.submit();
      }
    });
  });*/
  </script>
  </body>
</html>
