<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Administrador Up Trading</title>
    <meta content="" name="description">

    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    <link href="{{ asset('img/favicon.png') }}" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/preloader.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
    @yield('css')
    @laravelPWA
    <style>
        :root {
            touch-action: pan-x pan-y;
            height: 100%
        }
    </style>
</head>

<body>
    @yield('preloader')

    @include('sidebar')

    <main id="main" class="main">
        @yield('content')
    </main>

    @include('pregunta.modal')

    @include('chat.modal')
    
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-chevron-up"></i>
    </a>

    @yield('footer')

    <div class="modal fade" id="busquedaModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleSearch"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="resultadosBusqueda"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formModalCalc" tabindex="-1" aria-labelledby="modalTitleCal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleCal">Conversor de divisas <i class="bi bi-cash-coin"></i></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-floating mb-3">
                                <input type="number" step="any" class="form-control" placeholder="Ingresa el tipo de cambio USD" id="tipoCambioInputUSD">
                                <label for="tipoCambioInput">MXN - USD</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-floating mb-3">
                                <input type="number" step="any" class="form-control" placeholder="Ingresa el tipo de cambio EUR" id="tipoCambioInputEUR">
                                <label for="tipoCambioInputEUR">MXN - EUR</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-floating mb-3">
                                <input type="number" step="any" class="form-control" placeholder="Ingresa el tipo de cambio CHF" id="tipoCambioInputCHF">
                                <label for="tipoCambioInputCHF">MXN - CHF</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" placeholder="Ingresa el monto en USD" id="dolaresInput">
                                <label for="dolaresInput">Dólares</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" placeholder="Ingresa el monto en EUR" id="eurosInput">
                                <label for="eurosInput">Euros</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" placeholder="Ingresa el monto en CHF" id="francosInput">
                                <label for="francosInput">Francos suizos</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" placeholder="Ingresa el monto en MXN" id="pesosInput">
                                <label for="pesosInput">Pesos</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCancelCal" data-bs-dismiss="modal">Cerrar</button>
                    <button type="reset" class="btn btn-success" id="btnReset">Borrar campos</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    @yield('scripts')
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/preloader.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.8/push.js" integrity="sha512-x0GVeKL5uwqADbWOobFCUK4zTI+MAXX/b7dwpCVfi/RT6jSLkSEzzy/ist27Iz3/CWzSvvbK2GBIiT7D4ZxtPg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="{{ asset('js/notificaciones.js') }}"></script>
    <script src="{{ asset('js/chat.js') }}"></script>
</body>

</html>