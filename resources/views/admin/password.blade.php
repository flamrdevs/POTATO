@extends('admin.layout')

@section('main')
  <div class="container">

    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light rounded text-dark shadow-sm">
      <span class="h3 m-0">Edit Profil Saya</span>
    </nav>

    <div class="spacer-2"></div>

    @if (session('password'))
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('password') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

    <div class="card shadow-sm">
      <div class="card-body">

        <form action="{{ route('admin.update.password') }}" method="POST">
          {{ csrf_field() }}
          {{ method_field('PUT') }}

          <div class="form-group">
            <label for="currentPassword">Password saat ini</label>
            <input type="password" class="form-control {{$errors->has('currentPassword') ? 'is-invalid' : ''}}" id="currentPassword" name="currentPassword" value="{{ old('currentPassword') }}" aria-describedby="currentPasswordFeedback">
            @if ($errors->has('currentPassword'))
              <div id="currentPasswordFeedback" class="invalid-feedback">
                <strong>{{ $errors->first('currentPassword') }}</strong>
              </div>
            @endif
          </div>

          <div class="form-group">
            <label for="password">Password baru</label>
            <input type="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" id="password" name="password" value="{{ old('password') }}" aria-describedby="passwordFeedback">
            @if ($errors->has('password'))
              <div id="passwordFeedback" class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
              </div>
            @endif
          </div>
    
          <div class="form-group">
            <label for="password-confirm">Konfirmasi password baru</label>
            <input type="password" class="form-control {{$errors->has('password_confirmation') ? 'is-invalid' : ''}}" id="password-confirm" name="password_confirmation" aria-describedby="passwordConfirmationFeedback">
            @if ($errors->has('password_confirmation'))
              <div id="passwordConfirmationFeedback" class="invalid-feedback">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
              </div>
            @endif
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