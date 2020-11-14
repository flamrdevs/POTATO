@extends('layouts.app')

@section('body')
  <div class="left-side-home">
    <nav class="nav nav-pills flex-column">
      <a class="nav-link active" href="#">Active</a>
      <a class="nav-link" href="#">Link</a>
      <a class="nav-link" href="#">Link</a>
      <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
    </nav>
  </div>
  <div class="right-side-home">
    @for ($i = 0; $i < 20; $i++)
      
    @endfor
  </div>
@endsection