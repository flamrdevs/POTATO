@extends('admin.layout')

@section('main')
  <div class="container">
    
    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light rounded text-dark shadow-sm">
      <span class="h3 m-0">Data Siaran</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="card shadow-sm">
      <div class="card-body">

        <h1>Data Siaran</h1>

        @foreach ($broadcasts as $broadcast)
          <div class="card my-3 mx-3">
            <div class="card-body">
              <p class="card-text">{{ $broadcast->message }}</p>
              <p class="card-text float-right">{{ $broadcast->created_at }}</p>
            </div>
          </div>
        @endforeach

      </div>
    </div>

  </div>
@endsection