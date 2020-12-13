@extends('farmer.layout')

@section('main')
  <div class="container">

    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light text-dark border-width-1 border-primary border-left-only rounded shadow-sm">
      <span class="h3 m-0">Profil Saya</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">
      <div class="col-lg-9">
        
        <div class="card shadow-sm">
          <div class="card-body">

            @include('components.flashession')
    
            <div class="form-group">
              <label for="name">Nama</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" disabled>
            </div>
      
            <div class="form-group">
              <label for="email">E-Mail / Username</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" disabled>
            </div>
    
            <div class="form-group">
              <label for="phone">No Telepon</label>
              <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" disabled>
            </div>
    
            <div class="form-group">
              <label for="address">Alamat</label>
              <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}" disabled>
            </div>
    
            <div class="form-group">
              <label for="birthDate">Tanggal Lahir</label>
              <input type="date" class="form-control" id="birthDate" name="birthDate" value="{{ $user->birthDate }}" disabled>
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
    
          </div>
        </div>

      </div>

      <div class="col-lg-3">

        <div class="card shadow-sm">
          <div class="card-body">
            <a class="btn btn-sm btn-primary" href="{{ route('farmer.edit') }}" role="button">Edit</a>
            <a class="btn btn-sm btn-outline-primary" href="{{ route('farmer.password') }}" >Ubah Password</a>
          </div>
          <div class="card-footer bg-light">
            <a class="btn btn-sm btn-secondary" href="{{ route('farmer') }}" >Kembali</a>
          </div>
        </div>

      </div>
      
    </div>

  </div>
@endsection