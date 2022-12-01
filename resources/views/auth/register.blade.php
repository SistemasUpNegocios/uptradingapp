@extends('auth.index')

@section('title', 'Regístrate al sistema')

@section('content')
<main class="main-content  mt-0">
  <section class="min-vh-100 mb-8">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
      style="background: linear-gradient(160deg, #51a7b146 0%, #00afc63b), url({{ asset('img/curved14.jpg') }}); background-size: cover; background-repeat: no-repeat;">
      <span class="mask"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-3">¡Regístrate!</h1>
            <p class="text-lead text-white">Llena el siguiente formulario para registrarte al sistema de Up Negocios.
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10">
        <div class="col-xl-5 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-body">
              <form role="form text-left" method="POST" action="">
                @csrf
                <div class="mb-3">
                  <input type="text" id="nameInput" class="form-control" placeholder="Ingresa tu nombre" name="nombre" value="{{old('nombre')}}">
                  @error('nombre')
                    <div style="display:block !important" class="invalid-feedback">*{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <input type="text" id="nameInput" class="form-control" placeholder="Ingresa tu apellido paterno" name="apellido_p" value="{{old('apellido_p')}}">
                  @error('apellido_p')
                    <div style="display:block !important" class="invalid-feedback">*{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <input type="text" id="nameInput" class="form-control" placeholder="Ingresa tu apellido materno" name="apellido_m" value="{{old('apellido_m')}}">
                  @error('apellido_m')
                    <div style="display:block !important" class="invalid-feedback">*{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <input type="email" id="emailInput" class="form-control" placeholder="Ingresa tu correo electrónico"
                    name="correo" value="{{old('correo')}}">
                    @error('correo')
                      <div style="display:block !important" class="invalid-feedback">*{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                  <input type="password" id="passwordInput" class="form-control" placeholder="Ingresa una contraseña"
                    name="password" value="{{old('password')}}">
                    @error('password')
                      <div style="display:block !important" class="invalid-feedback">*{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                  <input type="password" id="passwordConfirmationInput" class="form-control"
                    placeholder="Confirma la contraseña" name="password_confirmation" value="{{old('password_confirmation')}}">
                    @error('password_confirmation')
                      <div style="display:block !important" class="invalid-feedback">*{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="rememberMe" onclick="verPass()">
                  <label id="textCheck" class="form-check-label" for="rememberMe">Mostrar
                    contraseñas</label>
                </div>
                <div class="form-check form-check-info text-left">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                  <label class="form-check-label" for="flexCheckDefault">
                    Acepto los <a href="javascript:;" class="text-dark font-weight-bolder">Términos y condiciones</a>
                  </label>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Regístrate</button>
                </div>
                <p class="text-sm mt-3 mb-0">¿Ya tienes una cuenta? <a href="{{ route('login') }}"
                    class="text-dark font-weight-bolder">Inicia sesión</a></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection

@section('css')
  <link id="pagestyle" href="{{ asset('css/login.css') }}" rel="stylesheet" />
@endsection

@section('script')
  <script src="{{ asset('js/signup.js') }}"></script>
@endsection

@section('g-recaptcha')
  <script type="text/javascript">
    function callbackThen(response) { 
      // read HTTP status console.log(response.status);
      // read Promise object 
      response.json().then(function(data){ 
          // console.log(data); 
      });  
      function callbackCatch(error){ 
        console.error('Error:', error) 
      }
    } 
  </script>
  {!! htmlScriptTagJsApi([ 'callback_then' => 'callbackThen', 'callback_catch' => 'callbackCatch' ]) !!}
@endsection