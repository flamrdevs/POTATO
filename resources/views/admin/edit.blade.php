@extends('admin.layout')

@section('main')
  <div class="container">

    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light rounded text-dark shadow-sm">
      <span class="h3 m-0">Edit Profil Saya</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="card shadow-sm">
      <div class="card-body">

        <form action="{{ route('admin.update') }}" method="POST">
          {{ csrf_field() }}
          {{ method_field('PUT') }}
    
          <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name" value="{{ $user->name }}" aria-describedby="nameFeedback">
            @if ($errors->has('name'))
              <div id="nameFeedback" class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
              </div>
            @endif
          </div>
    
          <div class="form-group">
            <label for="email">E-Mail / Username</label>
            <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email" value="{{ $user->email }}" aria-describedby="emailFeedback">
            @if ($errors->has('email'))
              <div id="emailFeedback" class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
              </div>
            @endif
          </div>

          <div class="form-group">
            <label for="phone">No Telepon</label>
            <input type="text" class="form-control {{$errors->has('phone') ? 'is-invalid' : ''}}" id="phone" name="phone" value="{{ $user->phone }}" aria-describedby="phoneFeedback">
            @if ($errors->has('phone'))
              <div id="phoneFeedback" class="invalid-feedback">
                <strong>{{ $errors->first('phone') }}</strong>
              </div>
            @endif
          </div>

          <div class="form-group">
            <label for="address">Alamat</label>
            <input type="text" class="form-control {{$errors->has('address') ? 'is-invalid' : ''}}" id="address" name="address" value="{{ $user->address }}" aria-describedby="addressFeedback">
            @if ($errors->has('address'))
              <div id="addressFeedback" class="invalid-feedback">
                <strong>{{ $errors->first('address') }}</strong>
              </div>
            @endif
          </div>

          <div class="form-group">
            <label for="birthDate">Tanggal Lahir</label>
            <input type="date" class="form-control {{$errors->has('birthDate') ? 'is-invalid' : ''}}" id="birthDate" name="birthDate" value="{{ $user->birthDate }}" aria-describedby="birthDateFeedback">
            @if ($errors->has('birthDate'))
              <div id="birthDateFeedback" class="invalid-feedback">
                <strong>{{ $errors->first('birthDate') }}</strong>
              </div>
            @endif
          </div>

          <div class="form-group">
            <label>Jenis Kelamin</label>
            <div class="form-group">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ $user->gender == 'male' ? 'checked' : '' }}>
                <label class="form-check-label" for="male">Laki-laki</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ $user->gender == 'female' ? 'checked' : '' }}>
                <label class="form-check-label" for="female">Perempuan</label>
              </div>
            </div>
          </div>

          <div class="spacer-2"></div>
    
          <div class="form-group">
            <a class="btn btn-secondary" href="{{ route('admin.profile') }}" >Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          
        </form>

      </div>
    </div>

  </div>
@endsection