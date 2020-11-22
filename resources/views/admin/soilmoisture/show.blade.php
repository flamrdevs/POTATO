@extends('admin.layout')

@section('main')
  <div class="container">
    
    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light rounded text-dark shadow-sm">
      <span class="h3 m-0">Data Kelembaban Tanah</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="card shadow-sm">
      <div class="card-body">

        <div class="d-flex justify-content-between my-3">
          <h4 class="card-title">Id mesin = {{ $soilmoistures[0]->machine_id }}</h4>
        </div>

        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead class="thead-light">
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Tanggal</th>
                <th scope="col" class="text-center">Nilai</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($soilmoistures as $sm)
                <tr>
                  <th scope="row" class="text-center">{{ $loop->iteration}}</th>
                  <td>{{ $sm->timestamp }}</td>
                  <td>{{ $sm->value }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-between">
          <p>Menampilkan {{ $soilmoistures->count() }} dari {{ $soilmoistures->total() }} data kelembaban tanah</p>
          <nav aria-label="Page navigation example">
            {{ $soilmoistures->links('vendor.pagination.bootstrap') }}
          </nav>
        </div>

      </div>
    </div>

  </div>
@endsection