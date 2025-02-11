@extends('layout/aplikasi')

@section('konten')
<div class="row justify-content-center">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route ('kirim')}}">
                    @csrf
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control mb-2">
                    <label>Email Address</label>
                    <input type="text" name="email" class="form-control mb-2">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control mb-2">
                    <button class="btn btn-primary">REGISTER</button>
                    @if($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

                </form>
            </div>
        </div>
    </div>
</div>
@endsection