@extends('auth.index')

@section('title', 'Inicio de sesión')

@section('content')

    <form method="POST" action="" class="login">
        @csrf

        <img class="imgSubtitle" src="{{ asset('img/logo.png') }}" alt="Logo">

        @error('message')
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="exclamation-triangle-fill" fill="#fff" viewBox="0 0 16 16">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </symbol>
            </svg>
            <div class="alert alert-danger d-flex align-items-center" style="margin-top: -15px !important" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div class="text-white">
                    Datos incorrectos, intenta de nuevo
                </div>
            </div>
        @enderror
        <input id="correoInput" type="email" placeholder="Correo electrónico" aria-label="Correo electrónico" aria-describedby="email-addon" name="correo" required value="{{old('correo')}}">
        <input id="passwordInput" type="password" placeholder="Contraseña" aria-label="Contraseña" aria-describedby="password-addon" name="password" required value="{{old('password')}}">
        <button>Iniciar sesión</button>
    </form>

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@endsection

@section('g-recaptcha')
    <script type="text/javascript">
        function callbackThen(response) { 
            // read HTTP status console.log(response.status);
            // read Promise object 
            response.json().then(function(data){ 
                console.log(data); 
            });  
            function callbackCatch(error){ 
                console.error('Error:', error) 
            }
        } 
        localStorage.setItem("Contratos", "Contratos a vencer");
    </script>
    {!! htmlScriptTagJsApi([ 'callback_then' => 'callbackThen', 'callback_catch' => 'callbackCatch' ]) !!}
@endsection