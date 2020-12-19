@extends('layouts.home')

@section('head')
  @yield('head')
@endsection

@section('sidebar')
  <div class="container">
    <ul class="nav nav-pills flex-column">

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin') || Request::is('admin/profile*') ? 'active' : 'text-dark' }}" href="{{ route('admin') }}">
          <i class="fa fa-home"></i>
          Beranda
        </a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin/farming*') ? 'active' : 'text-dark' }}" href="{{ route('admin.farming') }}">
          <i class="fa fa-business-time"></i>
          Masa Bertani
        </a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin/farmer*') ? 'active' : 'text-dark' }}" href="{{ route('admin.farmer') }}">
          <i class="fa fa-users"></i>
          Petani
        </a>
      </li>

      {{-- Sembunyikan kelembaban tanah sementara --}}
      {{-- <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin/soilmoisture*') ? 'active' : 'text-dark' }}" href="{{ route('admin.soilmoisture') }}">Kelembaban Tanah</a>
      </li> --}}

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin/plant*') ? 'active' : 'text-dark' }}" href="{{ route('admin.plant') }}">
          <i class="fa fa-leaf"></i>
          Tanaman
        </a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin/machine*') ? 'active' : 'text-dark' }}" href="{{ route('admin.machine') }}">
          <i class="fa fa-microchip"></i>
          Mesin
        </a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin/weather*') ? 'active' : 'text-dark' }}" href="{{ route('admin.weather') }}">
          <i class="fa fa-cloud"></i>
          Cuaca
        </a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin/broadcast*') ? 'active' : 'text-dark' }}" href="{{ route('admin.broadcast') }}">
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