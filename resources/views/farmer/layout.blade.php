@extends('layouts.home')

@section('sidebar')
  <div class="container">
    <ul class="nav nav-pills flex-column">

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('farmer') || Request::is('farmer/profile*') ? 'active' : 'text-dark' }}" href="{{ route('farmer') }}">Beranda</a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('farmer/farmer*') ? 'active' : 'text-dark' }}" href="{{ route('farmer.farmer') }}">Petani</a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('farmer/soilmoisture*') ? 'active' : 'text-dark' }}" href="{{ route('farmer.soilmoisture') }}">Kelembaban Tanah</a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('farmer/plant*') ? 'active' : 'text-dark' }}" href="{{ route('farmer.plant') }}">Tanaman</a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('farmer/weather*') ? 'active' : 'text-dark' }}" href="{{ route('farmer.weather') }}">Cuaca</a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('farmer/broadcast*') ? 'active' : 'text-dark' }}" href="{{ route('farmer.broadcast') }}">Siaran</a>
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