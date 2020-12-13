@extends('farmer.layout')

@section('main')
  <div class="container">
    
    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light text-dark border-width-1 border-primary border-left-only rounded shadow-sm">
      <span class="h3 m-0">Tambah Data Masa Bertani</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-lg-9">

        <div class="card shadow-sm">
          <div class="card-body">
    
            <form id="create-form" action="{{ route('farmer.farming.store') }}" method="POST">
              {{ csrf_field() }}
        
              <div class="form-group">
                <label for="farmer">Petani</label>
                <select class="form-control" name="farmer" id="farmer">
                  <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                </select>
                <div class="invalid-feedback">{{ $errors->first('farmer') }}</div>
              </div>

              <div class="form-group">
                <label for="plant">Tanaman</label>
                <select class="form-control" name="plant" id="plant">
                  @foreach ($plants as $plant)
                    <option value="{{ $plant->id }}">{{ $plant->name }}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">{{ $errors->first('plant') }}</div>
              </div>

              <div class="form-group">
                @if (count($machines) == 0)
                  <fieldset disabled>
                @endif

                <label for="machine">Kode Mesin</label>
                <select class="form-control" name="machine" id="machine">
                  <option value="">{{ count($machines) == 0 ? '' : 'tanpa mesin' }}</option>
                  @foreach ($machines as $machine)
                    <option value="{{ $machine->code }}">{{ $machine->code }}</option>
                  @endforeach
                </select>

                @if (count($machines) == 0)
                  <small class="text-muted">
                    tidak ada mesin tersedia
                  </small>
                  </fieldset>
                @endif
              </div>
              
            </form>
    
          </div>
        </div>

      </div>

      <div class="col-lg-3">

        <div class="card shadow-sm">
          <div class="card-body">
            <a class="btn btn-sm btn-primary" role="button" onclick="event.preventDefault(); document.getElementById('create-form').submit();">Simpan</a>
          </div>
          <div class="card-footer bg-light">
            <a class="btn btn-sm btn-secondary" href="{{ route('farmer.farming') }}" >Batal</a>
          </div>
        </div>

      </div>

    </div>

  </div>
@endsection