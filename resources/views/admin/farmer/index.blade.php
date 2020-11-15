@extends('admin.layout')

@section('main')
  <div class="container">
    
    <div class="d-flex justify-content-between my-3">
      <button type="button" class="btn btn-outline-light text-dark"><strong>Daftar Petani</strong></button>
      <div>
        <a class="btn btn-primary btn-sm" href="{{ route('admin.farmer.create') }}" role="button">Tambah akun</a>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <thead class="thead-light">
          <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col" class="text-center">Nama</th>
            <th scope="col" class="text-center">Email</th>
            <th scope="col" class="text-center">Password</th>
            <th scope="col" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($farmers as $farmer)
            <tr>
              <th scope="row" class="text-center">{{ $loop->iteration}}</th>
              <td>{{ $farmer->name }}</td>
              <td>{{ $farmer->email }}</td>
              <td>{{ $farmer->name }}</td>
              <td>
                <div class="d-flex justify-content-center">
                  <button type="button" class="btn btn-outline-info">Edit</button>
                </div>
              </td>
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
@endsection