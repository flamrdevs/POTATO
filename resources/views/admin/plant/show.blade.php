@extends('admin.layout')

@section('main')
  <div class="container">
    
    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light rounded text-dark shadow-sm">
      <span class="h3 m-0">Data Tanaman</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-sm-9">
        <div class="card shadow-sm">
          <div class="card-body">

            @include('components.flashession')

            <div class="form-group">
              <label for="name">Nama</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ $plant->name }}" disabled>
            </div>
    
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <a class="btn btn-sm btn-primary" href="{{ route('admin.plant.edit',['id' => $plant->id]) }}" role="button">Edit</a>
          </div>
          <div class="card-footer bg-light">
            <a class="btn btn-sm btn-secondary" href="{{ route('admin.plant') }}" >Kembali</a>
          </div>
        </div>
      </div>

    </div>

  </div>
@endsection