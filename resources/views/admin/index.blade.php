@extends('layouts.app')

@section('content')
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        @component('components.card')
          @slot('header')
            admin home
          @endslot

          You are logged in!
        @endcomponent
      </div>
    </div>
  </div>
@endsection