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
            <a class="nav-link" href="{{ route('login') }}">Masuk</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">

    <div class="spacer-5"></div>

    <div class="jumbotron bg-light">
      <h1 class="display-4">Selamat datang di POTATO</h1>

      <div class="spacer-2"></div>

      <div class="row">
        <div class="col-sm-5">
          <h5 class="lead"></h5>
          <div class="spacer-3"></div>
        </div>
        <div class="col-sm-2"></div>
        <div class="col-sm-5">
          <div class="card bg-light">
            <div class="card-body">
              <a class="btn btn-primary btn-block btn-lg" href="{{ route('login') }}" role="button">Masuk</a>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection