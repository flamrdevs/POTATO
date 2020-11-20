@extends('farmer.layout')

@section('main')
  <div class="container">
    
    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light rounded text-dark shadow-sm">
      <span class="h3 m-0">Data Petani</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="card shadow-sm">
      <div class="card-body">

        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead class="thead-light">
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Nama</th>
                <th scope="col" class="text-center">Email</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($farmers as $farmer)
                <tr>
                  <th scope="row" class="text-center">{{ $loop->iteration}}</th>
                  <td>{{ $farmer->name }}</td>
                  <td>{{ $farmer->email }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        
        <div class="d-flex justify-content-between">
          <p>Menampilkan {{ $farmers->count() }} dari {{ $farmers->total() }} petani</p>
          <nav aria-label="Page navigation example">
            {{ $farmers->links('vendor.pagination.bootstrap') }}
          </nav>
        </div>

      </div>
    </div>

  </div>
@endsection