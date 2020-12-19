@extends('admin.layout')

@section('main')
  <div class="container">
    
    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light text-dark border-width-1 border-primary border-left-only rounded shadow-sm">
      <span class="h3 m-0">Edit Data Masa Bertani</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-lg-9">

        <div class="card shadow-sm">
          <div class="card-body">
    
            <form id="create-form" action="{{ route('admin.farming.update', ['id' => $farming->id]) }}" method="POST">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
        
              <div class="form-group">
                <label for="farmer">Petani</label>
                <select class="form-control" name="farmer" id="farmer">
                  @foreach ($farmers as $farmer)
                    <option {{ $farmer->id == $farming->user['id'] ? 'selected' : '' }} value="{{ $farmer->id }}">{{ $farmer->name }}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">{{ $errors->first('farmer') }}</div>
              </div>

              <div class="form-group">
                <label for="plant">Tanaman</label>
                <select class="form-control" name="plant" id="plant">
                  @foreach ($plants as $plant)
                    <option {{ $plant->id == $farming->plant['id'] ? 'selected' : '' }} value="{{ $plant->id }}">{{ $plant->name }}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">{{ $errors->first('plant') }}</div>
              </div>

              <div class="form-group">
                @if (count($machines) == 0 && is_null($farming->machine_code))
                  <fieldset disabled>
                @endif

                <label for="machine">Kode Mesin</label>
                <select class="form-control" name="machine" id="machine">
                  <option value="">{{ 'tanpa mesin' }}</option>

                  @if (!is_null($farming->machine_code))
                    <option selected value="{{ $farming->machine_code }}">{{ $farming->machine_code }}</option>
                  @endif
                  
                  @foreach ($machines as $machine)
                    <option value="{{ $machine->code }}">{{ $machine->code }}</option>
                  @endforeach
                </select>

                @if (count($machines) == 0 && is_null($farming->machine_code))
                  <small class="text-muted">
                    tidak ada mesin tersedia
                  </small>
                  </fieldset>
                @endif
              </div>

              <div class="form-group">
                <label for="status">Status</label>
                <span id="status" class="badge p-1 {{ $farming->status ? 'badge-success' : 'badge-danger' }}">{{ $farming->status ? 'berlangsung' : 'selesai' }}</span>
                <div>
                  <a role="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#statusModal">Selesai</a>
                </div>
              </div>
              
            </form>
    
          </div>
        </div>

      </div>

      <div class="col-lg-3">

        <div class="card shadow-sm">
          <div class="card-body">
            <a class="btn btn-sm btn-primary" role="button" onclick="event.preventDefault(); document.getElementById('create-form').submit();">
              <i class="fa fa-save"></i>
              Simpan
            </a>
          </div>
          <div class="card-footer bg-light">
            <a class="btn btn-sm btn-secondary" href="{{ route('admin.farming.show', ['id' => $farming->id]) }}" >Batal</a>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Modal -->
  <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin mengubah selesai status masa bertani ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
          <a class="btn btn-primary" role="button" onclick="event.preventDefault(); document.getElementById('status-form').submit();">Ya</a>
          <form id="status-form" action="{{ route('admin.farming.update', ['id' => $farming->id]) }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="form-check">
              <input type="radio" name="status" value="true" checked hidden>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
@endsection