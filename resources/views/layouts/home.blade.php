@extends('layouts.app')

@section('head')
  @yield('head')
@endsection

@section('body')
  <nav class="navbar navbar-dark bg-primary sticky-top flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="{{ route(Auth::user()->role == 'admin' ? 'admin' : 'farmer') }}">{{ config('app.name') }}</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="btn-group mx-3">
      <button type="button" class="btn btn-outline-light btn-sm dropdown-toggle" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
        {{ Auth::user()->name }}
      </button>
      <div class="dropdown-menu dropdown-menu-left dropdown-menu-lg-right">
        <a class="dropdown-item" type="button" href="{{ route(Auth::user()->role == 'admin' ? 'admin.profile' : 'farmer.profile') }}">Profil</a>
        <a role="button" class="dropdown-item" data-toggle="modal" data-target="#logoutModal">Logout</a>
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

        <div class="spacer-5"></div>
      </main>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Keluar aplikasi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin ingin keluar ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
          <a class="btn btn-primary" role="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Ya</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  @yield('script')
@endsection