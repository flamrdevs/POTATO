@extends('layouts.app')

@section('content')
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        @component('components.card')
          @slot('header')
            daftar petani
          @endslot

          <ul>
            @foreach ($farmers as $farmer)
              <li>
                nama : {{ $farmer->name }}
              </li>
            @endforeach
          </ul>
        @endcomponent
      </div>
    </div>
  </div>
@endsection