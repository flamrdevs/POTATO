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

            @include('components.flashession')
    
            <div class="card my-3 mx-3 shadow-sm">
              <div class="card-body">

                <div class="row mb-5">

                  <div class="col-lg-6">
                    <div class="card mb-2">
                      <div class="card-body">
                        Today Line Chart
                      </div>
                    </div>
                    <a class="btn btn-outline-primary btn-sm btn-block" href="{{ route('admin.farming.soilmoistures', ['id' => $farming->id]) }}" role="button">Detail Kelembaban Tanah</a>
                  </div>

                  <div class="col-lg-6">
                    <div class="card mb-2">
                      <div class="card-body">
                        Today Line Chart
                      </div>
                    </div>
                    <a class="btn btn-outline-primary btn-sm btn-block" href="{{ route('admin.farming.waterings', ['id' => $farming->id]) }}" role="button">Detail Penyiraman Otomatis</a>
                  </div>

                </div>

                <table class="table">
                  <tbody>
                    <tr>
                      <td>Petani</td>
                      <td>:</td>
                      <td>{{ $farming->user['name'] }}</td>
                    </tr>

                    <tr>
                      <td>Tanaman</td>
                      <td>:</td>
                      <td>{{ $farming->plant['name'] }}</td>
                    </tr>

                    <tr>
                      <td>Kode mesin</td>
                      <td>:</td>
                      <td>{{ !is_null($farming->machine_code) ? $farming->machine_code : 'tanpa mesin' }}</td>
                    </tr>

                    <tr>
                      <td>Mulai</td>
                      <td>:</td>
                      <td>{{ date_format(date_create($farming->start), "Y-M-d") }}</td>
                    </tr>

                    <tr>
                      <td>Selesai</td>
                      <td>:</td>
                      <td>{{ !is_null($farming->end) ? date_format(date_create($farming->end), "Y-M-d") : '-' }}</td>
                    </tr>

                    <tr>
                      <td>Status</td>
                      <td>:</td>
                      <td>
                        <span class="badge p-1 {{ $farming->status ? 'badge-success' : 'badge-danger' }}">{{ $farming->status ? 'berlangsung' : 'selesai' }}</span>
                      </td>
                    </tr>
                  </tbody>
                </table>

              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="card shadow-sm">
          @if ($farming->status)
            <div class="card-body">
              <a class="btn btn-sm btn-primary" href="{{ route('admin.farming.edit',['id' => $farming->id]) }}" role="button">Edit</a>
            </div>
          @endif
          <div class="card-footer bg-light">
            <a class="btn btn-sm btn-secondary" href="{{ route('admin.farming') }}" >Kembali</a>
          </div>
        </div>
      </div>

    </div>

  </div>
@endsection