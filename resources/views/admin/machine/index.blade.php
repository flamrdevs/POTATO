@extends('admin.layout')

@section('head')
  <link rel="stylesheet" href="{{ asset('css/apexcharts.css') }}">
@endsection

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
              <table class="table table-hover table-bordered machine-table">
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
            <div class="d-flex align-items-center justify-content-center flex-column">
              <div id="chart"></div>
              <h2 class="h4">
                Total <span id="totalMachine"></span>
              </h2>
            </div>
          </div>
        </div>

        <div class="spacer-1"></div>

        <div class="card shadow-sm">
          <div class="card-body">
            <a class="btn btn-primary btn-sm" href="{{ route('admin.machine.create') }}" role="button">
              <i class="fa fa-plus"></i>
              Tambah
            </a>
          </div>
        </div>

      </div>

    </div>

  </div>
@endsection

@section('script')
  <script src="{{ asset('js/apexcharts.min.js') }}"></script>
  <script>
    (function () {
      var status = @json($status);

      document.querySelector('#totalMachine').innerHTML = status.used + status.ready;

      var options = {
        series: [status.used, status.ready],
        labels: ['digunakan', 'tersedia'],
        colors: ['#1cc88a', '#e74a3b'],
        chart: {
          type: 'donut',
        },
        dataLabels: {
          enabled: false,
        },
        legend: {
          show: false
        },
        plotOptions: {
          pie: {
            donut: {
              labels: {
                show: false,
              }
            }
          }
        }
      };

      var chart = new ApexCharts(document.querySelector("#chart"), options);
      chart.render();
    })();
  </script>

@endsection