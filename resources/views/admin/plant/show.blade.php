@extends('admin.layout')

@section('main')
  <div class="container">
    
    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light text-dark border-width-1 border-primary border-left-only rounded shadow-sm">
      <span class="h3 m-0">Data Tanaman</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-lg-9">
        <div class="card shadow-sm">
          <div class="card-body">

            @include('components.flashession')

            <div class="form-group">
              <label for="name">Nama</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ $plant->name }}" disabled>
            </div>

            <div class="form-group">
              <label for="minHumidity">Kelembaban minimal</label>
              <input type="number" class="form-control" id="minHumidity" name="minHumidity" value="{{ $plant->minHumidity }}" disabled>
            </div>
    
          </div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <a class="btn btn-sm btn-primary" href="{{ route('admin.plant.edit',['id' => $plant->id]) }}" role="button">
              <i class="fa fa-edit"></i>
              Edit
            </a>
          </div>
          <div class="card-footer bg-light">
            <a class="btn btn-sm btn-secondary" href="{{ route('admin.plant') }}" >Kembali</a>
          </div>
        </div>
      </div>

    </div>

  </div>
@endsection