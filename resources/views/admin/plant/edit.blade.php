@extends('admin.layout')

@section('main')
  <div class="container">

    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light rounded text-dark shadow-sm">
      <span class="h3 m-0">Edit Data Tanaman</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-lg-9">

        <div class="card shadow-sm">
          <div class="card-body">
    
            <form id="edit-form" action="{{ route('admin.plant.update',['id' => $plant->id]) }}" method="POST">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
        
              <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name" value="{{ $plant->name }}" aria-describedby="nameFeedback">
                @if ($errors->has('name'))
                  <div id="nameFeedback" class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                  </div>
                @endif
              </div>
              
            </form>
    
          </div>
        </div>

      </div>

      <div class="col-lg-3">

        <div class="card shadow-sm">
          <div class="card-body">
            <a class="btn btn-sm btn-primary" role="button" onclick="event.preventDefault(); document.getElementById('edit-form').submit();">Simpan</a>
          </div>
          <div class="card-footer bg-light">
            <a class="btn btn-sm btn-secondary" href="{{ route('admin.plant.show',['id' => $plant->id]) }}" >Batal</a>
          </div>
        </div>

      </div>

    </div>

  </div>
@endsection