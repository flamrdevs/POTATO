@extends('admin.layout')

@section('main')
  <div class="container">

    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light rounded text-dark shadow-sm">
      <span class="h3 m-0">Profil Saya</span>
    </nav>

    <div class="spacer-2"></div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

    <div class="card shadow-sm">
      <div class="card-body">

        <div class="form-group">
          <label for="name">Nama</label>
          <input type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name" value="{{ $user->name }}" disabled>
        </div>
  
        <div class="form-group">
          <label for="email">E-Mail / Username</label>
          <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email" value="{{ $user->email }}" disabled>
        </div>

        <div class="form-group">
          <label for="phone">No Telepon</label>
          <input type="text" class="form-control {{$errors->has('phone') ? 'is-invalid' : ''}}" id="phone" name="phone" value="{{ $user->phone }}" disabled>
        </div>

        <div class="form-group">
          <label for="address">Alamat</label>
          <input type="text" class="form-control {{$errors->has('address') ? 'is-invalid' : ''}}" id="address" name="address" value="{{ $user->address }}" disabled>
        </div>

        <div class="form-group">
          <label for="birthDate">Tanggal Lahir</label>
          <input type="date" class="form-control {{$errors->has('birthDate') ? 'is-invalid' : ''}}" id="birthDate" name="birthDate" value="{{ $user->birthDate }}" disabled>
        </div>

        <div class="form-group">
          <label>Jenis Kelamin</label>
          <div class="form-group">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ $user->gender == 'male' ? 'checked' : '' }} disabled>
              <label class="form-check-label" for="male">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ $user->gender == 'female' ? 'checked' : '' }} disabled>
              <label class="form-check-label" for="female">Perempuan</label>
            </div>
          </div>
        </div>

        <div class="spacer-2"></div>

        <div class="form-group">
          <div class="d-flex justify-content-between">
            <div>
              <a class="btn btn-secondary" href="{{ route('admin') }}" >Kembali</a>
            </div>
            <div>
              <a class="btn btn-outline-primary" href="{{ route('admin.password') }}" >Ubah Password</a>
              <a class="btn btn-primary" href="{{ route('admin.edit') }}" role="button">Edit</a>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
@endsection