@extends('layouts.global')

@section('body')
  {{-- Main Navbar --}}
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <!-- Branding Image -->
      <a class="navbar-brand" href="{{ url('/') }}">
        {{ config('app.name', 'Laravel') }}
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        {{-- Left Side Of Navbar --}}
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          @guest
            
          @else
            <button class="btn btn-success">{{ Auth::user()->role }}</button>
          @endguest
        </ul>

        {{-- Right Side Of Navbar --}}
        <ul class="navbar-nav my-2 my-lg-0">
          <!-- Authentication Links -->
          @guest
            <li class="nav-item active">
              <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
          @else
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }}
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ url(Auth::user()->role.'/profile') }}">
                  Profil saya
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  Logout
                </a>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </div>
            </li>
          @endguest            
        </ul>
      </div>
    </div>
  </nav>
@endsection