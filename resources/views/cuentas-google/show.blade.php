@extends('index')

@section('title', 'Cuentas Google Cloud')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
    </svg>

    <div class="pagetitle">
        <h1>Cuentas Google Cloud</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Cuentas Google Cloud</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-primary d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                        aria-label="Info:">
                        <use xlink:href="#info-fill" />
                    </svg>
                    <div>
                        IMPORTANTE: Aquí podrás crear todas las cuentas de clientes, solamente debes de poner su numero.
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <div class="card border-0">
                            <div class="d-flex">
                                <div class="horizontal-card-bg-img-email"></div>
                                <div class="flex-fill">
                                  <div class="card-body p-4">
                                    <div class="font-weight-bold"><b>Último correo creado:</b></div>
                                    <div id="ultimoCorreo">{{ $ultima_cuenta['primaryEmail'] }}</div>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around align-items-center mt-2 mb-4">
                            <a class="btn principal-button new" data-bs-toggle="modal" data-bs-target="#formModal"> <i class="bi-plus-lg me-1"> </i>Crear cuenta nueva</a>                            
                            <a class="btn principal-button" id="generarEmails"> <i class="bi bi-envelope-fill"></i> Generar 10 correos</a>
                        </div>
                        <table class="table table-striped table-bordered nowrap text-center" style="width: 100%" id="cuentas">
                            <thead>
                                <tr>
                                    <th data-priority="0" scope="col">Nombre completo</th>
                                    <th data-priority="0" scope="col">Correo</th>
                                    <th data-priority="0" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="cuentasBody" style="vertical-align: middle;">
                                @foreach ($cuentas as $cuenta)
                                    <tr>
                                        <td>{{ $cuenta["name"]['fullName'] }}</td>
                                        <td>{{ $cuenta["primaryEmail"] }}</td>
                                        <td>
                                            @include('cuentas-google.buttons')
                                        </td>
                                    </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
    </svg>
    
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Crear correo de Google</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cuentasForm" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInput">                    
                        <div class="row">                        
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control" placeholder="Ingresa el nombre" id="nombreInput" name="nombre" style="text-transform: none !important;" value="Cliente">
                                    <label for="nombreInput">Nombre</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control" placeholder="Ingresa los apellidos" id="apellidosInput" name="apellidos" style="text-transform: none !important;" value="Uptrading">
                                    <label for="apellidosInput">Apellidos</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="form-floating correo-floating">
                                        <input style="text-transform: lowercase;" type="text" title="Campo obligatorio / example@uptrading.com" minlength="3" maxlength="70" class="form-control" placeholder="Ingresa el correo" id="correoInput" name="correo" style="text-transform: none !important;" value="mxa_">
                                        <label for="correoInput">Correo</label> 
                                    </div>
                                    <span class="input-group-text span-floating" id="basic-addon2">@uptradingexperts.com</span>
                                </div>
                            </div> 
                        </div>                    
                        
                        <div id="alertMessage"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnSubmit">Añadir cuenta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('preloader')
    <div id="loader" class="loader">
        <h1></h1>
        <span></span>
        <span></span>
        <span></span>
    </div>
@endsection

@section('footer')
    <footer id="footer" class="footer">
        <div class="copyright" id="copyright">
        </div>
        <div class="credits">
            Todos los derechos reservados
        </div>
    </footer>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/cuentasgoogle.js') }}"></script>
@endsection