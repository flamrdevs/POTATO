@extends('layouts.app')

@section('head')
  @yield('head')
@endsection

@section('body')
  <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="{{ route(Auth::user()->role == 'admin' ? 'admin' : 'farmer') }}">{{ config('app.name') }}</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="btn-group mx-3">
      <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
        {{ Auth::user()->name }}
      </button>
      <div class="dropdown-menu dropdown-menu-left dropdown-menu-lg-right">
        <a class="dropdown-item" type="button" href="{{ route(Auth::user()->role == 'admin' ? 'admin.profile' : 'farmer.profile') }}">Profil</a>
        <a class="dropdown-item" type="button" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
        </form>
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="sidebar-sticky pt-3">
          @yield('sidebar')
        </div>
      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        @yield('main')
      </main>
    </div>
  </div>
@endsection

@section('script')
  @yield('script')
@endsection