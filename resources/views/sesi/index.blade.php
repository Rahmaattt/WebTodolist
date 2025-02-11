@extends('layout/aplikasi')

@section('konten')
<div>
  <h1>Login</h1>
<div class="row justify-content-center">
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <form action="/sesi/login" method="post">
          @csrf
          <div>
            <input type="text" value="{{ old('name') }}" name="name" class="form-control mb-2">
            <label for="email">Email</label>
            <!--<input type="email" value="{{ Session::get('email') }}" name="email">-->
            <input type="email" value="{{ old('email') }}" name="email" class="form-control mb-2">
            </div>
            <div>
              <label for="password">Password</label>
              <input type="password" name="password" class="form-control mb-2">
              </div>
              <div>
                <button name="submit" type="submit" class="btn btn-primary">Login</button>
                <p>Atau</p>
              </div>
            </form>
            <form action="/sesi/lupapw" method="get">
              <div>
                <button name="submit" type="submit" class="btn btn-primary">lupa password</button>
              </div>
            </form>
            <form action="/sesi/register" method="get">
              <div>
                <button name="submit" type="submit" class="btn btn-primary">Register</button>
              </div>
            </form>
          </div>
        </div>
    </div>
</div>
@endsection