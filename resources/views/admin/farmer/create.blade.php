@extends('layouts.app')

@section('content')
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        @component('components.card')
          @slot('header')
            Tambah akun petani
          @endslot

          <form action="{{ route('admin.farmer.store') }}" method="POST">
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
              <label for="email">E-Mail Address</label>
              <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email" value="{{ old('email') }}" aria-describedby="emailFeedback">
              @if ($errors->has('email'))
                <div id="emailFeedback" class="invalid-feedback">
                  <strong>{{ $errors->first('email') }}</strong>
                </div>
              @endif
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" id="password" name="password" value="{{ old('password') }}" aria-describedby="passwordFeedback">
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

            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                Tambah
              </button>
            </div>
            
          </form>
        @endcomponent
      </div>
    </div>
  </div>
@endsection