@extends('admin.layout')

@section('main')
  <div class="container">

    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light text-dark border-width-1 border-primary border-left-only rounded shadow-sm">
      <span class="h3 m-0">Data Cuaca</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-sm-6">
        <div class="card shadow-sm border-width-1 border-info border-left-only">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <h5 class="card-title h4 user-select-none">{{ $humidity['@attributes']['description'] }}</h5>
              </div>
              <div class="col-md-5">
                @foreach ($humidity['timerange'] as $hu)
                  @if (((int)date('H') - (int)$hu['@attributes']['h']) < 6)
                    <span class="btn btn-outline-light h-100 w-100">
                      <p class="card-text h2 text-center text-dark">{{ $hu['value'] }}%</p>
                    </span>
                    @break
                  @endif
                @endforeach
              </div>
              <div class="col-md-7">
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
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card shadow-sm border-width-1 border-info border-left-only">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <h5 class="card-title h4 user-select-none">{{ $temperature['@attributes']['description'] }}</h5>
              </div>
              <div class="col-md-5">
                @foreach ($temperature['timerange'] as $t)
                  @if (((int)date('H') - (int)$t['@attributes']['h']) < 6)
                    <span class="btn btn-outline-light h-100 w-100">
                      <p class="card-text h2 text-center text-dark">{{ $t['value'][0] }}&#176;C</p>
                    </span>
                    @break
                  @endif
                @endforeach
              </div>
              <div class="col-md-7">
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
          </div>
        </div>
      </div>

    </div>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-sm-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title h4 user-select-none">{{ $humidity['@attributes']['description'] }}</h5>
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
                    <td>{{ date('H:00 - d-m-y', strtotime('+'.$hu['@attributes']['h'].' Hours', strtotime('00:00:00 today')))}}</td>
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
            <h5 class="card-title h4 user-select-none">{{ $temperature['@attributes']['description'] }}</h5>
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
                    <td>{{ date('H:00 - d-m-y', strtotime('+'.$t['@attributes']['h'].' Hours', strtotime('00:00:00 today')))}}</td>
                    <td>{{ $t['value'][0] }}&#176;C</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
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