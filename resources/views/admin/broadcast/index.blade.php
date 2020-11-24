@extends('admin.layout')

@section('main')
  <div class="container">
    
    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light rounded text-dark shadow-sm">
      <span class="h3 m-0">Data Siaran</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-sm-9">
        <div class="card shadow-sm">
          <div class="card-body">

            @include('components.flashession')
    
            @foreach ($broadcasts as $broadcast)
              <div class="card my-3 mx-3">
                <div class="card-body">
                  <p class="card-text text-wrap text-truncate">
                    {{ str_limit($broadcast->message, 150) }}
                    @if (strlen($broadcast->message) > 150)
                      <a class="btn btn-sm btn-link" href="{{ route('admin.broadcast.show',['id' => $broadcast->id]) }}" role="button">Detail</a>
                    @endif
                  </p>
                  <p class="card-text float-right">{{ $broadcast->created_at }}</p>

                  <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.broadcast.edit',['id' => $broadcast->id]) }}" role="button">Edit</a>
                </div>
              </div>
            @endforeach
    
            <div class="d-flex justify-content-between">
              <p>Menampilkan {{ $broadcasts->count() }} dari {{ $broadcasts->total() }} siaran</p>
              <nav aria-label="Page navigation example">
                {{ $broadcasts->links('vendor.pagination.bootstrap') }}
              </nav>
            </div>
    
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">

            <a class="btn btn-primary btn-sm" href="{{ route('admin.broadcast.create') }}" role="button">Siaran baru</a>
            
          </div>
        </div>
      </div>

    </div>

  </div>
@endsection