@extends('admin.layout')

@section('main')
  <div class="container">

    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light rounded text-dark shadow-sm">
      <span class="h3 m-0">Edit Data Siaran</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-lg-9">

        <div class="card shadow-sm">
          <div class="card-body">
    
            <form id="edit-form" action="{{ route('admin.broadcast.update',['id' => $broadcast->id]) }}" method="POST">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
        
              <div class="form-group">
                <label for="message">Pesan</label>
                <textarea class="form-control {{$errors->has('message') ? 'is-invalid' : ''}}" name="message" id="message" cols="30" rows="10" aria-describedby="messageFeedback">{{ old('message') ? old('message') : $broadcast->message }}</textarea>
                @if ($errors->has('message'))
                  <div id="messageFeedback" class="invalid-feedback">
                    <strong>{{ $errors->first('message') }}</strong>
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
            <a class="btn btn-sm btn-secondary" href="{{ route('admin.broadcast') }}" >Batal</a>
          </div>
        </div>

      </div>

    </div>

  </div>
@endsection