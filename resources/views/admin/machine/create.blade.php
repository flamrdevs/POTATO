@extends('admin.layout')

@section('main')
  <div class="container">
    
    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light text-dark border-width-1 border-primary border-left-only rounded shadow-sm">
      <span class="h3 m-0">Buat Data Mesin Baru</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-lg-9">

        <div class="card shadow-sm">
          <div class="card-body">
    
            <form id="create-form" action="{{ route('admin.machine.store') }}" method="POST">
              {{ csrf_field() }}
        
              <div class="form-group">
                <label for="code">Kode</label>
                <input type="text" class="form-control {{$errors->has('code') ? 'is-invalid' : ''}}" id="code" name="code" value="{{ old('code') }}" aria-describedby="codeFeedback" autofocus>
                @if ($errors->has('code'))
                  <div id="codeFeedback" class="invalid-feedback">
                    <strong>{{ $errors->first('code') }}</strong>
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
            <a class="btn btn-sm btn-primary" role="button" onclick="event.preventDefault(); document.getElementById('create-form').submit();">
              <i class="fa fa-save"></i>
              Simpan
            </a>
          </div>
          <div class="card-footer bg-light">
            <a class="btn btn-sm btn-secondary" href="{{ route('admin.machine') }}" >Batal</a>
          </div>
        </div>

      </div>

    </div>

  </div>
@endsection