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
                    <th scope="col" class="text-center">Mulai</th>
                    <th scope="col" class="text-center">Selesai</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($waterings as $w)
                    <tr>
                      <th scope="row" class="text-center">{{ $loop->iteration}}</th>
                      <td>{{ $w->start }}</td>
                      <td>{{ !is_null($w->end) ? $w->end : '-' }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
    
            <div class="d-flex justify-content-between">
              <p>Menampilkan {{ $waterings->count() }} dari {{ $waterings->total() }} data penyiraman otomatis</p>
              <nav aria-label="Page navigation example">
                {{ $waterings->links('vendor.pagination.bootstrap') }}
              </nav>
            </div>
    
          </div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="card shadow-sm">
          <div class="card-footer bg-light">
            <a class="btn btn-sm btn-secondary" href="{{ route('admin.farming') }}" >Kembali</a>
          </div>
        </div>
      </div>

    </div>

  </div>
@endsection