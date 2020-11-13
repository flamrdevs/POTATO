@extends('layouts.app')

@section('content')
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        @component('components.card')
          @slot('header')
            Login
          @endslot

          <form action="{{ route('login') }}" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
              <label for="email">E-Mail Address</label>
              <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email" value="{{ old('email') }}" aria-describedby="emailFeedback"  autofocus>
              @if ($errors->has('email') && $errors->has('password'))
                <div id="emailFeedback" class="invalid-feedback">
                  <strong>Email harus diisi</strong>
                </div>
              @else
                @if ($errors->has('email'))
                  <div id="emailFeedback" class="invalid-feedback">
                    <strong>Username atau Password salah</strong>
                  </div>
                @endif
              @endif
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" id="password" name="password" aria-describedby="passwordFeedback" >
              @if ($errors->has('password'))
                <div id="passwordFeedback" class="invalid-feedback">
                  <strong>Password harus diisi</strong>
                </div>
              @endif
            </div>

            <div class="form-group">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                  Remember Me
                </label>
              </div>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                Login
              </button>
              <a class="btn btn-link" href="{{ route('password.request') }}">
                Forgot Your Password?
              </a>
            </div>
          </form>
        @endcomponent
      </div>
    </div>
  </div>
@endsection