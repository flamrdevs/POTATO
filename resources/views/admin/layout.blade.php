@extends('layouts.home')

@section('sidebar')
  <div class="container">
    <ul class="nav nav-pills flex-column">
      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin') || Request::is('admin/profile*') ? 'active' : 'text-dark' }}" href="{{ route('admin') }}">Home</a>
      </li>
      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin/farmer*') ? 'active' : 'text-dark' }}" href="{{ route('admin.farmer') }}">Petani</a>
      </li>
      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin/weather*') ? 'active' : 'text-dark' }}" href="{{ route('admin.weather') }}">Cuaca</a>
      </li>
    </ul>
  </div>
@endsection

@section('main')
  @yield('main')
@endsection

@section('script')
  @yield('script')
@endsection