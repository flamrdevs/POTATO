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
    
            <div class="table-responsive">
              <table class="table table-hover table-bordered plant-table">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Nama</th>
                    <th scope="col" class="text-center">Kelembaban Minimal</th>
                    <th scope="col" class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($plants as $plant)
                    <tr>
                      <th scope="row" class="text-center">{{ $loop->iteration}}</th>
                      <td>{{ $plant->name }}</td>
                      <td>{{ $plant->minHumidity }}%</td>
                      <td>
                        <div class="d-flex justify-content-center">
                        <a class="btn btn-outline-info btn-sm" href="{{ route('admin.plant.show',['id' => $plant->id]) }}" role="button">Detail</a>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            
            <div class="d-flex justify-content-between">
              <p>Menampilkan {{ $plants->count() }} dari {{ $plants->total() }} tanaman</p>
              <nav aria-label="Page navigation example">
                {{ $plants->links('vendor.pagination.bootstrap') }}
              </nav>
            </div>
    
          </div>
        </div>
      </div>

      <div class="col-lg-3">

        <div class="card shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-center flex-column">
              <div id="chart"></div>
              <h2 class="h4">
                Total {{ $total }}
              </h2>
            </div>
          </div>
        </div>

        <div class="spacer-1"></div>

        <div class="card shadow-sm">
          <div class="card-body">
            <a class="btn btn-primary btn-sm" href="{{ route('admin.plant.create') }}" role="button">
              <i class="fa fa-plus"></i>
              Tambah
            </a>
          </div>
        </div>

      </div>

    </div>

  </div>
@endsection