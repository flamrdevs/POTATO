@extends('farmer.layout')

@section('head')
  <link rel="stylesheet" href="{{ asset('css/apexcharts.css') }}">
@endsection

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

                <div class="spacer-2"></div>

                <div class="card mb-2">
                  <div class="card-body">
                    <div id="soilMoisturesTodayChart"></div>
                    <div>
                      <a class="btn btn-outline-primary btn-sm float-right" href="{{ route('farmer.farming.soilmoistures', ['id' => $farming->id]) }}" role="button">Detail Kelembaban Tanah</a>
                    </div>
                  </div>
                </div>

                <div class="card mb-2">
                  <div class="card-body">
                    <div id="wateringsTodayChart"></div>
                    <div>
                      <a class="btn btn-outline-primary btn-sm float-right" href="{{ route('farmer.farming.waterings', ['id' => $farming->id]) }}" role="button">Detail Penyiraman Otomatis</a>
                    </div>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="card shadow-sm">
          @if ($farming->status)
            <div class="card-body">
              <a class="btn btn-sm btn-primary" href="{{ route('farmer.farming.edit',['id' => $farming->id]) }}" role="button">
                <i class="fa fa-edit"></i>
                Edit
              </a>
            </div>
          @endif
          <div class="card-footer bg-light">
            <a class="btn btn-sm btn-secondary" href="{{ route('farmer.farming') }}" >Kembali</a>
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
      var today = @json($today);
      var soilMoisturesToday = today.soilmoisture;
      var wateringsToday = today.watering;

      var soilMoisturesArrayValue = soilMoisturesToday.map(function(val) {
        return val.value;
      });

      var soilMoisturesArrayXAxis = soilMoisturesToday.map(function(val) {
        var date = new Date(val.timestamp);
        var hour = date.getHours();
        var minute = date.getMinutes();
        var formatedHour = hour < 10 ? '0' + hour.toString() : hour.toString() ;
        var formatedMinnute = minute < 10 ? '0' + hour.toString() : minute.toString();
        return formatedHour + ':' + formatedMinnute;
      });

      var wateringsArrayData = wateringsToday.filter(function(val) {
        return val.end !== null;
      }).map(function(val, index) {
        if (wateringsToday[index+1]) {
          return {
            x: 'watering',
            y: [ new Date(val.start).getTime(), new Date(val.end).getTime() ]
          }
        } else {
          return {
            x: 'watering',
            y: [ new Date(val.start).getTime(), new Date().getTime() ]
          }
        }
      });

      console.log(wateringsArrayData);

      var soilMoisturesOptions = {
        series: [ { name: "Humidity", data: soilMoisturesArrayValue } ],
        chart: { type: 'line', id: 'hu', group: 'threedaysweather', height: 200, toolbar: { show: false }, zoom: { enabled: false } },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        title: { text: 'Kelembaban tanah hari ini', align: 'left' },
        grid: { row: { colors: ['#f3f3f3', 'transparent'], opacity: 0.5 }, },
        xaxis: { categories: soilMoisturesArrayXAxis, }
      }

      var wateringOptions = {
        series: [
          {
            name: 'watering',
            data: wateringsArrayData
          }
        ],
        chart: {
          type: 'rangeBar',
          height: 200,
          toolbar: { show: false }
        },
        plotOptions: {
          bar: {
            horizontal: true,
            barHeight: '50%'
          }
        },
        xaxis: {
          type: 'datetime',
          labels: {
            formatter: function(value) {
              var date = new Date(value);
              var hour = date.getHours();
              var minute = date.getMinutes();
              var formatedHour = hour < 10 ? '0' + hour.toString() : hour.toString() ;
              var formatedMinnute = minute < 10 ? '0' + hour.toString() : minute.toString();
              return formatedHour + ':' + formatedMinnute;
            }
          }
        },
        tooltip: {
          x: {
            show: true,
            formatter: function(value) {
              var date = new Date(value);
              var hour = date.getHours();
              var minute = date.getMinutes();
              var formatedHour = hour < 10 ? '0' + hour.toString() : hour.toString() ;
              var formatedMinnute = minute < 10 ? '0' + hour.toString() : minute.toString();
              return formatedHour + ':' + formatedMinnute;
            }
          }
        }
      }

      var soilMoisturesTodayChart = new ApexCharts(document.querySelector("#soilMoisturesTodayChart"), soilMoisturesOptions);
      soilMoisturesTodayChart.render();

      var wateringsTodayChart = new ApexCharts(document.querySelector("#wateringsTodayChart"), wateringOptions);
      wateringsTodayChart.render();

    })();
  </script>
@endsection