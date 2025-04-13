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
        <h3>Lupa Password</h3>
      </div>
      <div class="card-body">
        <form id="LupaPw" action="/sesi/lupapw" method="post">
          @csrf
          <div class="mb-3">
            <label for="Username" class="form-label">Username</label>
            <input id="Username" type="text" name="name" class="form-control" placeholder="Masukkan Username Anda">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="Email" type="text" name="email" class="form-control" placeholder="Masukkan Email Anda">
          </div>
          <button type="submit" class="btn btn-primary w-100">Selanjutnya</button>
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
  const form = document.getElementById("LupaPw");

  form.addEventListener("submit", function(e) {
    let missingFields = [];
    let invalidFields = [];

    var fields = [
      { id: "Username", label: "Username", regex: /^[a-zA-Z0-9 ]+$/, errorMsg: "Harap masukkan username yang valid, tanpa simbol." },
      { id: "Email", label: "Email", regex: /^[a-zA-Z0-9@.]+$/, errorMsg: "Harap masukkan email yang valid." }
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
      let missingFields = [];

      // Mendapatkan elemen input
      const name = document.querySelector("input[name='name']");
      const email = document.querySelector("input[name='email']");

      // Cek apakah masing-masing field sudah diisi
      if (!name.value.trim()) {
        missingFields.push("Username");
      }
      if (!email.value.trim()) {
        missingFields.push("Email");
      }

      // Jika ada field yang kosong, batalkan pengiriman form dan tampilkan notifikasi
      if (missingFields.length > 0) {
        e.preventDefault();
        //alert("harap isi " + missingFields.join(", ") + " sebelum login");
        Swal.fire({
          icon: 'warning',
          title: 'Gagal mendaftarkan akun',
          text: "Harap isi " + missingFields.join(", ") + " sebelum register",
          confirmButtonText: 'Mengerti'
        });
      } else {
      // Jika semua field sudah terisi, submit form ke database
      this.submit();
      }
    });
  });*/
  </script>
  </body>
</html>
