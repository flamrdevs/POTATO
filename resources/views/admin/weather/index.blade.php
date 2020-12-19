@extends('admin.layout')

@section('head')
  <link rel="stylesheet" href="{{ asset('css/apexcharts.css') }}">
@endsection

@section('main')
  <div class="container">

    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light text-dark border-width-1 border-primary border-left-only rounded shadow-sm">
      <span class="h3 m-0">Data Cuaca</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="card shadow-sm border-width-1 border-info border-left-only">
      <div class="card-body">
        <div class="row">

          <div class="col-lg-3">
            <h5 class="card-title h3 user-select-none">{{ $humidity['@attributes']['description'] }}</h5>
            <div>
              @foreach ($humidity['timerange'] as $hu)
                @if (((int)date('H') - (int)$hu['@attributes']['h']) < 6)
                  <span class="btn btn-outline-light h-100 w-100">
                    <h1 class="text-center text-dark" style="font-size: 4rem">{{ $hu['value'] }}%</h1>
                  </span>
                  @break
                @endif
              @endforeach
            </div>
            <div>
              <span class="btn btn-outline-danger btn-sm btn-block">
                <i class="fas fa-long-arrow-alt-up text-light"></i>
                Max {{ $maxHumidity }}%
              </span>
              <span class="btn btn-outline-success btn-sm btn-block">
                <i class="fas fa-long-arrow-alt-down text-light"></i>
                Min {{ $minHumidity }}%
              </span>
            </div>
          </div>

          <div class="col-lg-9">
            <div id="humidityChart"></div>
          </div>

        </div>
      </div>
    </div>

    <div class="spacer-2"></div>

    <div class="card shadow-sm border-width-1 border-info border-left-only">
      <div class="card-body">
        <div class="row">

          <div class="col-lg-3">
            <h5 class="card-title h3 user-select-none">{{ $temperature['@attributes']['description'] }}</h5>
            <div>
              @foreach ($temperature['timerange'] as $t)
                @if (((int)date('H') - (int)$t['@attributes']['h']) < 6)
                  <span class="btn btn-outline-light h-100 w-100">
                    <p class="card-text text-center text-dark" style="font-size: 4rem">{{ $t['value'][0] }}&#176;C</p>
                  </span>
                  @break
                @endif
              @endforeach
            </div>
            <div>
              <span class="btn btn-outline-danger btn-sm btn-block">
                <i class="fas fa-long-arrow-alt-up text-light"></i>
                Max {{ $maxTemperature }}&#176;C
              </span>
              <span class="btn btn-outline-success btn-sm btn-block">
                <i class="fas fa-long-arrow-alt-down text-light"></i>
                Min {{ $minTemperature }}&#176;C
              </span>
            </div>
          </div>

          <div class="col-lg-9">
            <div id="temperatureChart"></div>
          </div>

        </div>
      </div>
    </div>

    <div class="spacer-2"></div>

    <div class="row">
      <div class="col-sm-12">
        <p class="text-center text-dark">Data Source BMKG (Badan Meteorologi, Klimatologi, dan Geofisika)</p>
      </div>
    </div>

  </div>
@endsection

@section('script')
  <script src="{{ asset('js/apexcharts.min.js') }}"></script>
  <script>
    (function () {
      var humidityJson = @json($humidity);
      var humidityArrayValue = humidityJson.timerange.map(function(data) { return data.value; });

      var temperatureJson = @json($temperature);
      var temperatureArrayValue = temperatureJson.timerange.map(function(data) { return data.value[0]; });

      function addDays(date, days) {
        var copy = new Date(Number(date));
        copy.setDate(date.getDate() + days);
        return copy;
      }

      function formatDate(date) {
        return date.getDate().toString() + '-' + date.getMonth().toString() + '-' + date.getFullYear().toString().slice(2);
      }

      var dateNow = new Date();

      var Date0 = formatDate(addDays(dateNow, 0));
      var Date1 = formatDate(addDays(dateNow, 1));
      var Date2 = formatDate(addDays(dateNow, 2));

      var xaxisCat = [
        '00:00 ' + Date0, '06:00 ' + Date0, '12:00 ' + Date0, '18:00 ' + Date0,
        '00:00 ' + Date1, '06:00 ' + Date1, '12:00 ' + Date1, '18:00 ' + Date1,
        '00:00 ' + Date2, '06:00 ' + Date2, '12:00 ' + Date2, '18:00 ' + Date2]

      var humidityOptions = {
        series: [ { name: "Humidity", data: humidityArrayValue } ],
        chart: { type: 'line', id: 'hu', group: 'threedaysweather', height: 300, toolbar: { show: false }, zoom: { enabled: false } },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        title: { text: 'Prakiraan kelembaban udara tiga hari kedepan', align: 'left' },
        grid: { row: { colors: ['#f3f3f3', 'transparent'], opacity: 0.5 }, },
        xaxis: { categories: xaxisCat, }
      };

      var humidityChart = new ApexCharts(document.querySelector("#humidityChart"), humidityOptions);
      humidityChart.render();

      var temperatureOptions = {
        series: [ { name: "Temperature", data: temperatureArrayValue } ],
        chart: { type: 'line', id: 't', group: 'threedaysweather', height: 300, toolbar: { show: false }, zoom: { enabled: false } },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        title: { text: 'Prakiraan suhu udara tiga hari kedepan', align: 'left' },
        grid: { row: { colors: ['#f3f3f3', 'transparent'], opacity: 0.5 }, },
        xaxis: { categories: xaxisCat, }
      };

      var temperatureChart = new ApexCharts(document.querySelector("#temperatureChart"), temperatureOptions);
      temperatureChart.render();
    })();
  </script>
@endsection