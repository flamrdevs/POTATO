@extends('layouts.app')

@section('content')
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        @component('components.card')
          @slot('header')
            Reset Password
          @endslot

          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif

          <form action="{{ route('password.email') }}" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
              <label for="email">E-Mail Address</label>
              <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email" value="{{ old('email') }}" aria-describedby="emailFeedback" required>
              @if ($errors->has('email'))
                <div id="emailFeedback" class="invalid-feedback">
                  <strong>{{ $errors->first('email') }}</strong>
                </div>
              @endif
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                Send Password Reset Link
              </button>
            </div>
          </form>
        @endcomponent
      </div>
    </div>
  </div>
@endsection