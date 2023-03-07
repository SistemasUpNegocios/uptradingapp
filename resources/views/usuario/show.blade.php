@extends('index')

@section('title', 'Gestión de usuarios')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Gestión de usuarios</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a data-bs-target="#contenidositio-nav" data-bs-toggle="collapse" href="#">Vista general</a></li>
                <li class="breadcrumb-item active">Gestión de usuarios</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body mt-3">

                        @if (auth()->user()->is_root)
                            <a class="btn principal-button mb-3 new" data-bs-toggle="modal" data-bs-target="#formModal"> <i class="bi-plus-lg me-1"> </i>Añadir un nuevo usuario</a>
                        @endif
                        <table class="table table-striped table-bordered nowrap" style="font-size: 13px !important; width: 100%" id="usuario">
                            <thead class="text-center">
                                <tr>
                                    <th data-priority="0" scope="col">Nombre</th>
                                    <th data-priority="0" scope="col">Apellidos</th>
                                    <th data-priority="0" scope="col">Correo</th>
                                    <th data-priority="0" scope="col">Privilegio</th>
                                    <th data-priority="0" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="usuarioBody" class="text-center">
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Añadir usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="usuarioForm" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInput">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control" placeholder="Ingresa el nombre" id="nombreInput" name="nombre" readonly>
                                    <label for="floatingInput">Nombre</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control" placeholder="Ingresa el apellido paterno" id="apellidoPatInput" name="apellidop" readonly>
                                    <label for="floatingInput">Apellido paterno</label>                                                                                                
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control" placeholder="Ingresa el apellido materno" id="apellidoMatInput" name="apellidom" required readonly>
                                    <label for="floatingInput">Apellido materno</label>                                                                                                
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="email" title="Campo obligatorio / example@gmail.com" minlength="3" maxlength="70" class="form-control" placeholder="Ingresa el correo personal" id="correoInput" name="correo" required style="text-transform: none !important;">
                                    <label for="floatingInput">Email</label>                                                                                                
                                </div>
                            </div>
                        </div>
                        <div class="row">                            
                            @if (auth()->user()->is_root)
                                <div class="col-md-6 col-12" id="containerPrivilegio">
                                    <div class="form-floating mb-3">
                                        <select name="privilegio" class="form-control" id="privilegioInput" required>
                                            <option value="" disabled selected>Selecciona...</option>
                                            <option value="root">Root</option>
                                            <option value="admin">Admin</option>
                                            <option value="procesos">Procesos</option>
                                            <option value="ps_gold">PS Gold</option>
                                            <option value="ps_silver">PS Silver</option>
                                            <option value="contabilidad">Contabilidad</option>
                                            <option value="egresos">Egresos</option>
                                            <option value="cliente">Cliente</option>
                                        </select>
                                        <label for="privilegioInput">Privilegio</label>
                                    </div>
                                </div>
                            @elseif(auth()->user()->is_admin || auth()->user()->is_procesos)
                                <div class="col-md-6 col-12" id="containerPrivilegio">
                                    <div class="form-floating mb-3">
                                        <select name="privilegio" class="form-control" id="privilegioInput" required>
                                            <option value="" disabled selected>Selecciona...</option>
                                            <option value="ps_gold">PS Gold</option>
                                            <option value="ps_silver">PS Silver</option>
                                        </select>
                                        <label for="privilegioInput">Privilegio</label>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6 col-12" id="containerPassword">
                                <div class="form-floating mb-3">
                                    <input type="password" id="passwordInput" class="form-control" placeholder="Ingresa una contraseña" name="password" value="{{old('password')}}">
                                    <label for="floatingInput">Contraseña</label>
                                </div>
                            </div>
                        </div>
                        @if (auth()->user()->is_root)
                            <div class="row justify-content-start" id="checkCont">
                                <div class="col-md-6 col-12">
                                    <div class="form-check form-switch mb-3 d-flex justify-content-start">
                                        <input class="form-check-input" type="checkbox" role="switch" name="switch-pass" id="passInputCheck">
                                        <label class="form-check-label ms-1" for="passInputCheck">Restablecer contraseña</label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div id="alertMessage"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnSubmit">Añadir usuario</button>
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
    <script src="{{ asset('js/usuario.js') }}"></script>
@endsection