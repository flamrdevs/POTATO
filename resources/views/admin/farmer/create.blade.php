@extends('admin.layout')

@section('main')
  <div class="container">

    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light rounded text-dark shadow-sm">
      <span class="h3 m-0">Buat Akun Petani</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-lg-9">

        <div class="card shadow-sm">
          <div class="card-body">
    
            <form id="create-form" action="{{ route('admin.farmer.store') }}" method="POST">
              {{ csrf_field() }}
        
              <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name" value="{{ old('name') }}" aria-describedby="nameFeedback" autofocus>
                @if ($errors->has('name'))
                  <div id="nameFeedback" class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                  </div>
                @endif
              </div>
        
              <div class="form-group">
                <label for="email">E-Mail / Username</label>
                <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email" value="{{ old('email') }}" aria-describedby="emailFeedback">
                @if ($errors->has('email'))
                  <div id="emailFeedback" class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                  </div>
                @endif
              </div>
    
              <div class="form-group">
                <label for="phone">No Telepon</label>
                <input type="text" class="form-control {{$errors->has('phone') ? 'is-invalid' : ''}}" id="phone" name="phone" value="{{ old('phone') }}" aria-describedby="phoneFeedback" autofocus>
                @if ($errors->has('phone'))
                  <div id="phoneFeedback" class="invalid-feedback">
                    <strong>{{ $errors->first('phone') }}</strong>
                  </div>
                @endif
              </div>
    
              <div class="form-group">
                <label for="address">Alamat</label>
                <input type="text" class="form-control {{$errors->has('address') ? 'is-invalid' : ''}}" id="address" name="address" value="{{ old('address') }}" aria-describedby="addressFeedback" autofocus>
                @if ($errors->has('address'))
                  <div id="addressFeedback" class="invalid-feedback">
                    <strong>{{ $errors->first('address') }}</strong>
                  </div>
                @endif
              </div>
    
              <div class="form-group">
                <label for="birthDate">Tanggal Lahir</label>
                <input type="date" class="form-control {{$errors->has('birthDate') ? 'is-invalid' : ''}}" id="birthDate" name="birthDate" value="{{ old('birthDate') }}" aria-describedby="birthDateFeedback">
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
                    <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                    <label class="form-check-label" for="male">Laki-laki</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                    <label class="form-check-label" for="female">Perempuan</label>
                  </div>
                </div>
              </div>
        
              <div class="form-group">
                <label for="password">Password</label>
                <input type="text" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" id="password" name="password" value="{{ old('password') }}" aria-describedby="passwordFeedback">
                @if ($errors->has('password'))
                  <div id="passwordFeedback" class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                  </div>
                @endif
              </div>
        
              <div class="form-group">
                <label for="password-confirm">Konfirmasi Password</label>
                <input type="password" class="form-control {{$errors->has('password_confirmation') ? 'is-invalid' : ''}}" id="password-confirm" name="password_confirmation" aria-describedby="passwordConfirmationFeedback">
                @if ($errors->has('password_confirmation'))
                  <div id="passwordConfirmationFeedback" class="invalid-feedback">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                  </div>
                @endif
              </div>
              
            </form>
    
          </div>
        </div>

      </div>

      <div class="col-lg-3">

        <div class="card shadow-sm">
          <div class="card-body">
            <a class="btn btn-sm btn-primary" role="button" onclick="event.preventDefault(); document.getElementById('create-form').submit();">Simpan</a>
          </div>
          <div class="card-footer bg-light">
            <a class="btn btn-sm btn-secondary" href="{{ route('admin.farmer') }}" >Batal</a>
          </div>
        </div>

      </div>

    </div>

  </div>
@endsection