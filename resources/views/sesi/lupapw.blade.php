@extends('layout/aplikasi')

@section('konten')
<div>
  <h1>Login</h1>
<div class="row justify-content-center">
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <form action="/sesi/lupapw" method="post">
          @csrf
          <div>
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control mb-2">
            </div>
            <div>
              <label for="name">username</label>
              <input type="text" name="name" class="form-control mb-2">
              </div>
              <div>
                <button name="submit" type="submit" class="btn btn-primary">Selanjutnya</button>
              </div>
            </form>
          </div>
        </div>
    </div>
</div>
@endsection