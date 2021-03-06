@extends('admin.layout')

@section('main')
  <div class="container">

    <div class="spacer-2"></div>

    <nav class="navbar navbar-light bg-light text-dark border-width-1 border-primary border-left-only rounded shadow-sm">
      <span class="h3 m-0">Edit Profil Petani</span>
    </nav>

    <div class="spacer-2"></div>

    <div class="row">

      <div class="col-lg-9">

        <div class="card shadow-sm">
          <div class="card-body">
    
            <form id="edit-form" action="{{ route('admin.farmer.update',['id' => $farmer->id]) }}" method="POST">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
        
              <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name" value="{{ old('name') ? old('name') : $farmer->name }}" aria-describedby="nameFeedback">
                @if ($errors->has('name'))
                  <div id="nameFeedback" class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                  </div>
                @endif
              </div>
        
              <div class="form-group">
                <label for="email">E-Mail / Username</label>
                <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email" value="{{ old('email') ? old('email') : $farmer->email }}" aria-describedby="emailFeedback">
                @if ($errors->has('email'))
                  <div id="emailFeedback" class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                  </div>
                @endif
              </div>
    
              <div class="form-group">
                <label for="phone">No Telepon</label>
                <input type="text" class="form-control {{$errors->has('phone') ? 'is-invalid' : ''}}" id="phone" name="phone" value="{{ old('phone') ? old('phone') : $farmer->phone }}" aria-describedby="phoneFeedback">
                @if ($errors->has('phone'))
                  <div id="phoneFeedback" class="invalid-feedback">
                    <strong>{{ $errors->first('phone') }}</strong>
                  </div>
                @endif
              </div>
    
              <div class="form-group">
                <label for="address">Alamat</label>
                <input type="text" class="form-control {{$errors->has('address') ? 'is-invalid' : ''}}" id="address" name="address" value="{{ old('address') ? old('address') : $farmer->address }}" aria-describedby="addressFeedback">
                @if ($errors->has('address'))
                  <div id="addressFeedback" class="invalid-feedback">
                    <strong>{{ $errors->first('address') }}</strong>
                  </div>
                @endif
              </div>
    
              <div class="form-group">
                <label for="birthDate">Tanggal Lahir</label>
                <input type="date" class="form-control {{$errors->has('birthDate') ? 'is-invalid' : ''}}" id="birthDate" name="birthDate" value="{{ old('birthDate') ? old('birthDate') : $farmer->birthDate }}" aria-describedby="birthDateFeedback">
                @if ($errors->has('birthDate'))
                  <div id="birthDateFeedback" class="invalid-feedback">
                    <strong>{{ $errors->first('birthDate') }}</strong>
                  </div>
                @endif
              </div>
    
              <div class="form-group">
                <label>Jenis Kelamin</label>
                <div class="form-group">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ $farmer->gender == 'male' ? 'checked' : '' }}>
                    <label class="form-check-label" for="male">Laki-laki</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ $farmer->gender == 'female' ? 'checked' : '' }}>
                    <label class="form-check-label" for="female">Perempuan</label>
                  </div>
                </div>
              </div>
              
            </form>
    
          </div>
        </div>

      </div>

      <div class="col-lg-3">

        <div class="card shadow-sm">
          <div class="card-body">
            <a class="btn btn-sm btn-primary" role="button" onclick="event.preventDefault(); document.getElementById('edit-form').submit();">
              <i class="fa fa-save"></i>
              Simpan
            </a>
          </div>
          <div class="card-footer bg-light">
            <a class="btn btn-sm btn-secondary" href="{{ route('admin.farmer.show',['id' => $farmer->id]) }}" >Batal</a>
          </div>
        </div>

      </div>

    </div>

  </div>
@endsection