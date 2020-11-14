@extends('layouts.app')

@section('content')
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        @component('components.card')
          @slot('header')
            Login
          @endslot

          @if (Session::has('error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>{{ Session::get('error') }}</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif

          <form action="{{ route('login') }}" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
              <label for="email">Username</label>
              <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email" value="{{ old('email') }}" aria-describedby="emailFeedback"  autofocus>
              @if ($errors->has('email'))
                <div id="emailFeedback" class="invalid-feedback">
                  <strong>{{ $errors->first('email') }}</strong>
                </div>
              @endif
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" id="password" name="password" aria-describedby="passwordFeedback" >
              @if ($errors->has('password'))
                <div id="passwordFeedback" class="invalid-feedback">
                  <strong>{{ $errors->first('password') }}</strong>
                </div>
              @endif
            </div>

            {{-- <div class="form-group">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                  Remember Me
                </label>
              </div>
            </div> --}}

            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                Login
              </button>
              {{-- <a class="btn btn-link" href="{{ route('password.request') }}">
                Forgot Your Password?
              </a> --}}
            </div>
          </form>
        @endcomponent
      </div>
    </div>
  </div>
@endsection