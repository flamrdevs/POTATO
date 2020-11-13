@extends('layouts.app')

@section('content')
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        @component('components.card')
          @slot('header')
            Reset Password
          @endslot

          <form action="{{ route('password.request') }}" method="POST">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
              <label for="email">E-Mail Address</label>
              <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email" value="{{ old('email') }}" aria-describedby="emailFeedback" required autofocus>
              @if ($errors->has('email'))
                <div id="emailFeedback" class="invalid-feedback">
                  <strong>{{ $errors->first('email') }}</strong>
                </div>
              @endif
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" id="password" name="password" aria-describedby="passwordFeedback" required>
              @if ($errors->has('password'))
                <div id="passwordFeedback" class="invalid-feedback">
                  <strong>{{ $errors->first('password') }}</strong>
                </div>
              @endif
            </div>

            <div class="form-group">
              <label for="password_confirmation">Confirm Password</label>
              <input type="password" class="form-control {{$errors->has('password_confirmation') ? 'is-invalid' : ''}}" id="password" name="password_confirmation" aria-describedby="password_confirmationFeedback" required>
              @if ($errors->has('password_confirmation'))
                <div id="password_confirmationFeedback" class="invalid-feedback">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                </div>
              @endif
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                Reset Password
              </button>
            </div>
          </form>
        @endcomponent
      </div>
    </div>
  </div>
@endsection