@extends('index')

@section('title', 'Gestión de PS')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">

    <link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Gestión de PS</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Gestión de PS</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body mt-3">
                        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
                            <a class="btn principal-button mb-3 new" data-bs-toggle="modal" data-bs-target="#formModal"> <i class="bi-plus-lg me-1"> </i>Añadir un nuevo PS</a>
                        @endif
                        <table class="table table-striped table-bordered nowrap text-center" id="ps">
                            <thead>
                                <tr>
                                    <th data-priority="0" scope="col">Código PS</th>
                                    <th data-priority="0" scope="col">Nombre</th>
                                    <th data-priority="0" scope="col">Oficina</th>
                                    <th data-priority="0" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="psBody">
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
                    <h5 class="modal-title" id="modalTitle">Añadir PS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="psForm" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInput">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingresa el código de PS"
                                        id="codigoPsInput" name="codigops" required>
                                    <label for="floatingInput">Código PS</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" minlength="3" maxlength="30"
                                        pattern="[a-zA-Zá-úÁ-Ú ]+" placeholder="Ingresa el nombre" id="nombreInput"
                                        name="nombre" required>
                                    <label for="floatingInput">Nombre</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" minlength="3" maxlength="30"
                                        pattern="[a-zA-Zá-úÁ-Ú ]+" placeholder="Ingresa el apellido paterno"
                                        id="apellidoPatInput" name="apellidop" required>
                                    <label for="floatingInput">Apellido paterno</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" minlength="3" maxlength="30"
                                        pattern="[a-zA-Zá-úÁ-Ú ]+" placeholder="Ingresa el apellido materno"
                                        id="apellidoMatInput" name="apellidom" required>
                                    <label for="floatingInput">Apellido materno</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" placeholder="Ingresa la fecha de nacimiento"
                                        id="fechaNacInput" name="fechanac" required>
                                    <label for="floatingInput">Fecha de nacimiento</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" minlength="3" maxlength="30"
                                        pattern="[a-zA-Zá-úÁ-Ú ]+" placeholder="Ingresa la nacionalidad"
                                        id="nacionalidadInput" name="nacionalidad" required>
                                    <label for="floatingInput">Nacionalidad</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" 
                                        placeholder="Ingresa la dirección" id="direccionInput" name="direccion" required>
                                    <label for="floatingInput">Dirección</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control"
                                        placeholder="Ingresa la colonia/fraccionamiento" id="colFraccInput" name="colonia"
                                        required>
                                    <label for="floatingInput">Colonia/Fraccionamiento</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" minlength="5" maxlength="5"
                                        placeholder="Ingresa el código postal" id="cpInput" name="cp" required>
                                    <label for="floatingInput">Código postal</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" minlength="3" maxlength="30"
                                        pattern="[a-zA-Zá-úÁ-Ú ]+" placeholder="Ingresa la ciudad" id="ciudadInput"
                                        name="ciudad" required>
                                    <label for="floatingInput">Ciudad</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" minlength="3" maxlength="30"
                                        pattern="[a-zA-Zá-úÁ-Ú ]+" placeholder="Ingresa el estado" id="estadoInput"
                                        name="estado" required>
                                    <label for="floatingInput">Estado</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" minlength="10" maxlength="10" pattern="[0-9]+"
                                        placeholder="Ingresa el número celular" id="celularInput" name="celular" required>
                                    <label for="floatingInput">Celular</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input style="text-transform: lowercase;" type="email" class="form-control" minlength="3" maxlength="70"
                                        title="example@gmail.com" placeholder="Ingresa el correo personal" id="correopInput"
                                        name="correo_personal" required>
                                    <label for="floatingInput">Email personal</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input style="text-transform: lowercase;" type="email" class="form-control" minlength="3" maxlength="70"
                                        title="example@uptrading.com" placeholder="Ingresa el correo institucional"
                                        id="correoiInput" name="correo_institucional" required>
                                    <input type="hidden" id="correotInput" name="correo_temp">
                                    <label for="floatingInput">Email institucional</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" minlength="5" maxlength="30"
                                        placeholder="Ingresa la INE" id="ineInput" name="ine">
                                    <label for="floatingInput">INE</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" minlength="5" maxlength="30"
                                        placeholder="Ingresa el pasaporte" id="pasaporteInput" name="pasaporte">
                                    <label for="floatingInput">Pasaporte</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control"
                                        placeholder="Ingresa la fecha de vencimiento del pasaporte" id="fechapasInput"
                                        name="fechapas" required>
                                    <label for="floatingInput">Fecha vencimiento de pasaporte</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <select name="oficina_id" minlength="3" maxlength="120" pattern="[a-zA-Zá-úÁ-Ú ]+"
                                        class="form-select selectSearch" id="oficinaIdInput">
                                        <option value="" disabled selected>Selecciona..</option>
                                        @foreach($lista_oficinas as $oficina)
                                        <option value="{{ $oficina->id }}">{{ $oficina->ciudad }} ({{
                                            $oficina->codigo_oficina }})</option>
                                        @endforeach
                                    </select>
                                    <label for="psIdInput">Oficina a la que pertenece el PS</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" minlength="5" maxlength="30" class="form-control" placeholder="Ingresa la cuenta Swift" id="swiftInput" name="swift" value="SWQBCHZZXXX">
                                    <label for="floatingInput">Cuenta Swift</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" minlength="5" maxlength="30" class="form-control" placeholder="Ingresa la cuenta IBAN" id="ibanInput" name="iban" value="CH8208781000170714100">
                                    <label for="floatingInput">Cuenta IBAN</label>
                                </div>
                            </div>
                        </div>
                        <div id="alertMessage"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancel"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnSubmit">Añadir PS</button>
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
    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>
    <script src="{{ asset('js/ps.js') }}"></script>
@endsection