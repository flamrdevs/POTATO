@extends('layouts.home')

@section('head')
  @yield('head')
@endsection

@section('sidebar')
  <div class="container">
    <ul class="nav nav-pills flex-column">

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin') || Request::is('admin/profile*') ? 'active' : 'text-dark' }}" href="{{ route('admin') }}">Beranda</a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin/farming*') ? 'active' : 'text-dark' }}" href="{{ route('admin.farming') }}">Masa Bertani</a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin/farmer*') ? 'active' : 'text-dark' }}" href="{{ route('admin.farmer') }}">Petani</a>
      </li>

      {{-- Sembunyikan kelembaban tanah sementara --}}
      {{-- <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin/soilmoisture*') ? 'active' : 'text-dark' }}" href="{{ route('admin.soilmoisture') }}">Kelembaban Tanah</a>
      </li> --}}

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin/plant*') ? 'active' : 'text-dark' }}" href="{{ route('admin.plant') }}">Tanaman</a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin/machine*') ? 'active' : 'text-dark' }}" href="{{ route('admin.machine') }}">Mesin</a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin/weather*') ? 'active' : 'text-dark' }}" href="{{ route('admin.weather') }}">Cuaca</a>
      </li>

      <li class="nav-item my-1">
        <a class="nav-link {{ Request::is('admin/broadcast*') ? 'active' : 'text-dark' }}" href="{{ route('admin.broadcast') }}">Siaran</a>
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