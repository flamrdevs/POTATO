@extends('farmer.layout')

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

            <div class="mb-3 row">
              <div class="col-sm-6 offset-sm-6">
                <div class="form-group">
                  <select class="form-control" name="show" id="show">
                    <option value="allFarming">Semua</option>
                    <option value="showFarming">Berlangsung</option>
                    <option value="hideFarming">Selesai</option>
                  </select>
                </div>
              </div>
            </div>

            @foreach ($farmings as $farming)
              <div class="card my-3 mx-3 shadow-sm {{ $farming->status ? 'showFarming' : 'hideFarming' }}">
                <div class="card-body">

                  <table class="table">
                    <tbody>
                      <tr>
                        <td>Petani</td>
                        <td>:</td>
                        <td>{{ $farming->user['name'] }}</td>
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
                        <td>
                          <span class="badge p-2 {{ $farming->status ? 'badge-success' : 'badge-danger' }}">{{ $farming->status ? 'berlangsung' : 'selesai'}}</span>
                        </td>
                        <td></td>
                        <td>
                          <a class="btn btn-outline-primary btn-sm float-right" href="{{ route('farmer.farming.show', ['id' => $farming->id]) }}" role="button">Detail</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>

                </div>
              </div>
            @endforeach
    
          </div>
        </div>
      </div>

      <div class="col-lg-3">

        <div class="card shadow-sm">
          <div class="card-body">
            <a class="btn btn-primary btn-sm" href="{{ route('farmer.farming.create') }}" role="button">Tambah</a>
          </div>
        </div>

      </div>

    </div>

  </div>
@endsection

@section('script')
  <script>
    (function() {
      $('#show').on('change', function() {
        switch (this.value) {
          case 'allFarming':
            $('.showFarming').show();
            $('.hideFarming').show();
            break;
        
          case 'showFarming':
            $('.showFarming').show();
            $('.hideFarming').hide();
            break;

          case 'hideFarming':
            $('.showFarming').hide();
            $('.hideFarming').show();
            break;
        
          default:
            break;
        }
      });
    })();
  </script>
@endsection