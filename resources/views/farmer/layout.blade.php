@extends('layouts.home')

@section('sidebar')
  <div class="container">
    <ul class="nav nav-pills flex-column">

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('farmer') || Request::is('farmer/profile*') ? 'active' : 'text-dark' }}" href="{{ route('farmer') }}">
          <i class="fa fa-home"></i>
          Beranda
        </a>
      </li>

      {{-- <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('farmer/farmer*') ? 'active' : 'text-dark' }}" href="{{ route('farmer.farmer') }}">Petani</a>
      </li> --}}

      {{-- <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('farmer/soilmoisture*') ? 'active' : 'text-dark' }}" href="{{ route('farmer.soilmoisture') }}">Kelembaban Tanah</a>
      </li> --}}

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('farmer/farming*') ? 'active' : 'text-dark' }}" href="{{ route('farmer.farming') }}">
          <i class="fa fa-business-time"></i>
          Masa Bertani
        </a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('farmer/plant*') ? 'active' : 'text-dark' }}" href="{{ route('farmer.plant') }}">
          <i class="fa fa-leaf"></i>
          Tanaman
        </a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('farmer/weather*') ? 'active' : 'text-dark' }}" href="{{ route('farmer.weather') }}">
          <i class="fa fa-cloud"></i>
          Cuaca
        </a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('farmer/broadcast*') ? 'active' : 'text-dark' }}" href="{{ route('farmer.broadcast') }}">
          <i class="fa fa-broadcast-tower"></i>
          Siaran
        </a>
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