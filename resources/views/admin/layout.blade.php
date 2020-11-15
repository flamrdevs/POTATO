@extends('layouts.home')

@section('sidebar')
  <ul class="nav nav-pills flex-column">
    <li class="nav-item">
    <a class="nav-link {{ Request::is('admin') || Request::is('admin/profile') ? 'active' : 'text-dark' }}" href="{{ route('admin') }}">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ Request::is('admin/farmer*') ? 'active' : 'text-dark' }}" href="{{ route('admin.farmer') }}">Farmer</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ Request::is('admin/weather*') ? 'active' : 'text-dark' }}" href="{{ route('admin.weather') }}">Weather</a>
    </li>
  </ul>
@endsection

@section('main')
  @yield('main')
@endsection

@section('script')
  @yield('script')
@endsection