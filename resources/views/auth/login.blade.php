@extends('layouts.app')

@section('bodyStyle')
  {!! "class='bg-primary'" !!}
@endsection

@section('body')
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand p-0 my-0" href="{{ route('welcome') }}">{{ config('app.name') }}</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('welcome') }}">Welcome</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">

    <div class="spacer-5"></div>

    <div class="row">
      <div class="col-sm-6">

        <div class="spacer-5"></div>

        <div class="jumbotron jumbotron-fluid bg-transparent text-light rounded">
          <div class="container">
            <h1 class="display-4">Potato</h1>
            <p class="lead">Smart Farmer Soil Moisture System</p>
          </div>
        </div>

      </div>

      <div class="col-sm-5 offset-sm-1">

        <div class="text-center mb-4">
          <h1 class="text-light">Login</h1>
        </div>

        <div class="card shadow-lg">
          <div class="card-body">

            {{-- Session Flash --}}
            @if (Session::has('failure'))
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>{{ Session::get('failure') }}</strong>
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
              
              <div class="spacer-2"></div>

              <div class="form-group">
                <div class="d-flex justify-content-center">
                  <button type="submit" class="btn btn-primary">Login</button>
                </div>
              </div>
              
            </form>
            
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
