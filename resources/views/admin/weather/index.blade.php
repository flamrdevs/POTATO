@extends('admin.layout')

@section('main')
  <div class="container">

    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light rounded text-dark shadow-sm">
      <span class="h3 m-0">Cuaca</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-sm-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <table class="table table-sm table-borderless">
              <thead>
                <tr>
                  <th scope="col"><h5 class="card-title">{{ $humidity['@attributes']['description'] }}</h5></th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">
                    @foreach ($humidity['timerange'] as $hu)
                      @if (((int)date('H') - (int)$hu['@attributes']['h']) < 6)
                        <p class="card-text">{{ $hu['value'] }}%</p>
                        @break
                      @endif
                    @endforeach
                  </th>
                  <td>
                    Max {{ $maxHumidity }}%
                  </td>
                </tr>
                <tr>
                  <th scope="row"></th>
                  <td>
                    Min {{ $minHumidity }}%
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <table class="table table-sm table-borderless">
              <thead>
                <tr>
                  <th scope="col"><h5 class="card-title">{{ $temperature['@attributes']['description'] }}</h5></th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">
                    @foreach ($temperature['timerange'] as $t)
                      @if (((int)date('H') - (int)$t['@attributes']['h']) < 6)
                        <p class="card-text">{{ $t['value'][0] }}&#176;C</p>
                        @break
                      @endif
                    @endforeach
                  </th>
                  <td>
                    Max {{ $maxTemperature }}&#176;C
                  </td>
                </tr>
                <tr>
                  <th scope="row"></th>
                  <td>
                    Min {{ $minTemperature }}&#176;C
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-sm-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">{{ $humidity['@attributes']['description'] }}</h5>
            <table class="table table-sm table-bordered">
              <thead>
                <tr>
                  <th scope="col" class="text-center">#</th>
                  <th scope="col" class="text-center">Tanggal</th>
                  <th scope="col" class="text-center">Persentase</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($humidity['timerange'] as $hu)
                  <tr>
                    <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                    <td>{{ date('H:00 - d-m-y', strtotime('+'.$hu['@attributes']['h'].' Hours'))}}</td>
                    <td>{{ $hu['value'] }}%</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">{{ $temperature['@attributes']['description'] }}</h5>
            <table class="table table-sm table-bordered">
              <thead>
                <tr>
                  <th scope="col" class="text-center">#</th>
                  <th scope="col" class="text-center">Tanggal</th>
                  <th scope="col" class="text-center">Suhu</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($temperature['timerange'] as $t)
                  <tr>
                    <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                    <td>{{ date('H:00 - d-m-y', strtotime('+'.$t['@attributes']['h'].' Hours'))}}</td>
                    <td>{{ $t['value'][0] }}&#176;C</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>

  </div>
@endsection