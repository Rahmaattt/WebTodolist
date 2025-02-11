@extends('layout/aplikasi')

@section('konten')
<div>
  <h1>Login</h1>
<div class="row justify-content-center">
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <form action="/sesi/updatepw" method="post">
          @csrf
          <div>
            <label for="email">Email</label>
            <input type="text" name="password" class="form-control mb-2">
            </div>
            <div>
              <label for="password_confirmation">konfirmasi password</label>
              <input type="text" name="password_confirmation" class="form-control mb-2">
              </div>
              <div>
                <button name="submit" type="submit" class="btn btn-primary">konfirmasi</button>
              </div>
            </form>
          </div>
        </div>
    </div>
</div>
@endsection