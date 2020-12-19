@extends('admin.layout')

@section('main')
  <div class="container">
    
    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light text-dark border-width-1 border-primary border-left-only rounded shadow-sm">
      <span class="h3 m-0">Data Siaran</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-lg-9">
        <div class="card shadow-sm">
          <div class="card-body">

            @include('components.flashession')
    
            <div class="card my-3 mx-3">
              <div class="card-body">
                <p class="card-text">{{ $broadcast->message }}</p>
                <p class="card-text float-right">{{ $broadcast->created_at }}</p>
              </div>
            </div>
    
          </div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <a class="btn btn-sm btn-primary" href="{{ route('admin.broadcast.edit',['id' => $broadcast->id]) }}" role="button">
              <i class="fa fa-edit"></i>
              Edit
            </a>
          </div>
          <div class="card-footer bg-light">
            <a class="btn btn-sm btn-secondary" href="{{ route('admin.broadcast') }}" >Kembali</a>
          </div>
        </div>
      </div>

    </div>

  </div>
@endsection