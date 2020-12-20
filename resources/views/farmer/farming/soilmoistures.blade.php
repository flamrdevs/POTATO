@extends('admin.layout')

@section('main')
  <div class="container">
    
    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light text-dark border-width-1 border-primary border-left-only rounded shadow-sm">
      <span class="h3 m-0">Data Masa Bertani</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-lg-9">
        <div class="card shadow-sm">
          <div class="card-body">

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
                      <td>{{ $sm->value }}%</td>
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

      <div class="col-lg-3">
        <div class="card shadow-sm">
          <div class="card-footer bg-light">
            <a class="btn btn-sm btn-secondary" href="{{ route('farmer.farming') }}" >Kembali</a>
          </div>
        </div>
      </div>

    </div>

  </div>
@endsection