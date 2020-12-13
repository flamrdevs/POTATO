@extends('admin.layout')

@section('main')
  <div class="container">
    
    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light text-dark border-width-1 border-primary border-left-only rounded shadow-sm">
      <span class="h3 m-0">Data Mesin</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-lg-9">
        <div class="card shadow-sm">
          <div class="card-body">

            @include('components.flashession')
    
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Kode</th>
                    <th scope="col" class="text-center">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($machines as $machine)
                    <tr>
                      <th scope="row" class="text-center">{{ $loop->iteration}}</th>
                      <td>{{ $machine->code }}</td>
                      <td>
                        @if ($machine->status == 'used')
                          <a class="badge p-1 badge-danger" href="{{ route('admin.farming.show', ['id' => $machine->farming['id']]) }}" role="button">Digunakan</a>
                        @else
                          <span id="status" class="badge p-1 badge-success">Tersedia</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            
            <div class="d-flex justify-content-between">
              <p>Menampilkan {{ $machines->count() }} dari {{ $machines->total() }} tanaman</p>
              <nav aria-label="Page navigation example">
                {{ $machines->links('vendor.pagination.bootstrap') }}
              </nav>
            </div>
    
          </div>
        </div>
      </div>

      <div class="col-lg-3">

        <div class="card shadow-sm">
          <div class="card-body">
            <a class="btn btn-primary btn-sm" href="{{ route('admin.machine.create') }}" role="button">Tambah</a>
          </div>
        </div>

      </div>

    </div>

  </div>
@endsection