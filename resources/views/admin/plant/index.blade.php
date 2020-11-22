@extends('admin.layout')

@section('main')
  <div class="container">
    
    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light rounded text-dark shadow-sm">
      <span class="h3 m-0">Data Tanaman</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="card shadow-sm">
      <div class="card-body">

        <h1>Data Tanaman</h1>

        @foreach ($plants as $plant)
          <div class="card my-3 mx-3">
            <div class="card-body">
              <p class="card-text">{{ $plant->name }}</p>
              <p class="card-text">{{ $plant->minHumidity }}</p>
            </div>
          </div>
        @endforeach

      </div>
    </div>

  </div>
@endsection