@extends('admin.layout')

@section('main')
  <div class="container">

    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light rounded text-dark shadow-sm">
      <span class="h3 m-0">Edit Profil Saya</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-lg-9">

        <div class="card shadow-sm">
          <div class="card-body">

            @include('components.flashession')
    
            <form id="edit-form" action="{{ route('admin.updatePassword') }}" method="POST">
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
              
            </form>
    
          </div>
        </div>

      </div>

      <div class="col-lg-3">

        <div class="card shadow-sm">
          <div class="card-body">
            <a class="btn btn-sm btn-primary" role="button" onclick="event.preventDefault(); document.getElementById('edit-form').submit();">Simpan</a>
          </div>
          <div class="card-footer bg-light">
            <a class="btn btn-sm btn-secondary" href="{{ route('admin.profile') }}" >Batal</a>
          </div>
        </div>

      </div>

    </div>

  </div>
@endsection