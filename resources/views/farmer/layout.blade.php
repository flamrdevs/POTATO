@extends('layouts.home')

@section('sidebar')
  <ul class="nav nav-pills flex-column">
    <li class="nav-item">
    <a class="nav-link {{ Request::is('farmer') || Request::is('farmer/profile') ? 'active' : 'text-dark' }}" href="{{ route('farmer') }}">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ Request::is('farmer/weather*') ? 'active' : 'text-dark' }}" href="{{ route('farmer.weather') }}">Weather</a>
    </li>
  </ul>
@endsection

@section('main')
  @yield('main')
@endsection

@section('script')
  @yield('script')
@endsection