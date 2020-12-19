@extends('admin.layout')

@section('head')
  <link rel="stylesheet" href="{{ asset('css/apexcharts.css') }}">
@endsection

@section('main')
  <div class="container">

    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light text-dark border-width-1 border-primary border-left-only rounded shadow-sm">
      <span class="h3 m-0">Beranda</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-sm-4 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-center flex-column">
              <div class="text-center h4 font-weight-bold mb-2">Bertani</div>
              <div id="farmingChart"></div>
              <h2 class="h5">Total <span id="totalFarming"></span></h2>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-4 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-center flex-column">
              <div class="text-center h4 font-weight-bold mb-2">Mesin</div>
              <div id="machineChart"></div>
              <h2 class="h5">Total <span id="totalMachine"></span></h2>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-4 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-center flex-column">
              <div class="text-center h4 font-weight-bold mb-2">Petani</div>
              <div id="farmerChart"></div>
              <h2 class="h5">Total <span id="totalFarmer"></span></h2>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="row">

      <div class="col-lg-8 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="h5 font-weight-bold mb-4">
              Bertani berlangsung
            </div>
            <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
              <table class="table table-sm">
                <tbody>
                  @foreach ($farmings as $farming)
                    <tr>
                      <td>
                        <div class="d-flex justify-content-between align-items-center">
                          <a class="btn btn-link btn-sm" href="{{ route('admin.farming.show', ['id' => $farming->id]) }}">
                            {{ $farming->user['name'] }}
                            @if (!is_null($farming->machine_code))
                              <span class="badge badge-info">{{ $farming->machine_code }}</span>
                            @endif
                          </a>
                          <span>
                            {{ date_diff(date_create($farming->start), date_create(now()))->format("%R%a hari") }}
                          </span>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="h5 font-weight-bold mb-4">
              Rata-rata hari ini
            </div>
            <div class="table-responsive">
              <table class="table">
                <tbody>
                  <tr>
                    <td>Kelembaban tanah</td>
                    <td>:</td>
                    <td>{{ $average['today']['soilMoisture'] }}%</td>
                  </tr>
                  <tr>
                    <td>Kelembaban udara</td>
                    <td>:</td>
                    <td>{{ $average['today']['whumidity'] }}%</td>
                  </tr>
                  <tr>
                    <td>Suhu udara</td>
                    <td>:</td>
                    <td>{{ $average['today']['wtemperature'] }}%</td>
                  </tr>
                </tbody>
              </table>
            </div>
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

      var farming = @json($count['farming']);
      var machine = @json($count['machine']);
      var farmer = @json($count['farmer']);

      var farmingOptions = {
        series: [farming.berlangsung, farming.selesai],
        labels: ['berlangsung', 'selesai'],
        colors: ['#4e73df', '#1cc88a'],
        chart: {type: 'donut', height: 150},
        dataLabels: {enabled: false,},
        legend: {show: false},
        plotOptions: {pie: {donut: {labels: {show: false,}}}}
      };
      document.querySelector('#totalFarming').innerHTML = farming.berlangsung + farming.selesai;
      var farmingChart = new ApexCharts(document.querySelector("#farmingChart"), farmingOptions);
      farmingChart.render();

      var machineOptions = {
        series: [machine.tersedia, machine.digunakan],
        labels: ['tersedia', 'digunakan'],
        colors: ['#1cc88a', '#e74a3b'],
        chart: {type: 'donut', height: 150},
        dataLabels: {enabled: false,},
        legend: {show: false},
        plotOptions: {pie: {donut: {labels: {show: false,}}}}
      };
      document.querySelector('#totalMachine').innerHTML = machine.tersedia + machine.digunakan;
      var machineChart = new ApexCharts(document.querySelector("#machineChart"), machineOptions);
      machineChart.render();

      var farmerOptions = {
        series: [farmer.bekerja, farmer.tidakbekerja],
        labels: ['bekerja', 'tidakbekerja'],
        colors: ['#1cc88a', '#e74a3b'],
        chart: {type: 'donut', height: 150},
        dataLabels: {enabled: false,},
        legend: {show: false},
        plotOptions: {pie: {donut: {labels: {show: false,}}}}
      };
      document.querySelector('#totalFarmer').innerHTML = farmer.bekerja + farmer.tidakbekerja;
      var farmerChart = new ApexCharts(document.querySelector("#farmerChart"), farmerOptions);
      farmerChart.render();

    })();
  </script>
@endsection