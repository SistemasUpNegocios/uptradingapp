@extends('index')

@section('title', 'Gestión de clientes')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">

    <link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">

    <style>
        table.dataTable th, table.dataTable td {
            font-size: 15.5px;
        }
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Gestión de clientes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Gestión de clientes</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body mt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_ps_diamond || auth()->user()->is_ps_bronze)
                                <a class="btn principal-button mb-3 new me-1" data-bs-toggle="modal" data-bs-target="#formModal"> <i class="bi-plus-lg me-1"> </i>Añadir un nuevo cliente</a>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="lpoaSwitch">
                                    <label class="form-check-label" for="lpoaSwitch">Imprimir LPOA</label>
                                </div>
                            @endif
                        </div>
                        <div class="col-12 d-none" id="alertaNota">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    Si el color del botón de <b>"NOTA"</b> está en gris es que existe una nota, y si está negro es que está vacía.
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered nowrap text-center" id="cliente">
                            <thead>
                                <tr>
                                    <th data-priority="0" scope="col">Código cliente</th>
                                    <th data-priority="0" scope="col">Nombre</th>
                                    <th data-priority="0" scope="col">Apellido paterno</th>
                                    <th data-priority="0" scope="col">Apellido materno</th>
                                    <th data-priority="0" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
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
                    <h5 class="modal-title" id="modalTitle">Añadir cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="clienteForm" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInput">
                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    Ingresa los datos del cliente:
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="convenio_mam" id="tipoClienteSwitch">
                                    <label class="form-check-label" for="tipoClienteSwitch">¿El cliente es para convenio MAM?</label>
                                </div>
                            </div>
                            <div class="col-12" id="formCont">
                                <div class="form-floating">
                                    <select name="form_id" class="form-select selectSearch" id="formIdInput">
                                        <option value="" disabled selected>Selecciona...</option>
                                        @foreach($lista_form as $form)
                                        <option value="{{ $form->id }}">{{ $form->apellido_p }}
                                            {{ $form->apellido_m }} {{ $form->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <label for="formIdInput">Cliente en formulario</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12" id="codigoClienteCont">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingresa el código de cliente" id="codigoClienteInput" name="codigocliente" required>
                                    <label for="codigoClienteInput">Código cliente</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control" placeholder="Ingresa el nombre" id="nombreInput" name="nombre" required>
                                    <label for="nombreInput">Nombre</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control" placeholder="Ingresa el apellido paterno" id="apellidoPatInput" name="apellidop" required>
                                    <label for="apellidoPatInput">Apellido paterno</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control" placeholder="Ingresa el apellido materno" id="apellidoMatInput" name="apellidom">
                                    <label for="apellidoMatInput">Apellido materno</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12" id="identificadorCont">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingresa el identificador" id="identificadorInput" name="identificador">
                                    <label for="identificadorInput">Identificador</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="fechaNacCont">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" placeholder="Ingresa la fecha de nacimiento" id="fechaNacInput" name="fechanac" required>
                                    <label for="fechaNacInput">Fecha de nacimiento</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control" placeholder="Ingresa la nacionalidad" id="nacionalidadInput" name="nacionalidad" required>
                                    <label for="nacionalidadInput">Nacionalidad</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="dirColCont">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" minlength="3" maxlength="50" class="form-control" placeholder="Ingresa la dirección" id="direccionInput" name="direccion" required>
                                    <label for="direccionInput">Dirección</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" minlength="3" maxlength="30" class="form-control" placeholder="Ingresa la colonia/fraccionamiento" id="colFraccInput" name="colonia" required>
                                    <label for="colFraccInput">Colonia/Fraccionamiento</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="codCiudCont">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" title="Campo obligatorio / Solo números" minlength="5" maxlength="5" pattern="[0-9]+" class="form-control" placeholder="Ingresa el código postal" id="cpInput" name="cp" required>
                                    <label for="cpInput">Código postal</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" minlength="3" maxlength="30" " class="form-control" placeholder="Ingresa la ciudad" id="ciudadInput" name="ciudad" required>
                                    <label for="ciudadInput">Ciudad</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="estCelCont">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" class="form-control" placeholder="Ingresa el estado" id="estadoInput" name="estado" required>
                                    <label for="estadoInput">Estado</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" title="Campo obligatorio / Solo números" minlength="10" maxlength="10" pattern="[0-9]+" class="form-control" placeholder="Ingresa el número celular" id="celularInput" name="celular" required>
                                    <label for="celularInput">Celular</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="corrCont">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input style="text-transform: lowercase;" type="email" title="Campo obligatorio / example@gmail.com" minlength="3" maxlength="70" class="form-control" placeholder="Ingresa el correo personal" id="correopInput" name="correo_personal" required>
                                    <label for="correopInput">Email personal</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input style="text-transform: lowercase;" type="email" title="Campo obligatorio / example@uptrading.com" minlength="3" maxlength="70" class="form-control" placeholder="Ingresa el correo institucional" id="correoiInput" name="correo_institucional">
                                    <label for="correoiInput">Email institucional</label>
                                    <input type="hidden" id="correotInput" name="correo_temp">
                                </div>
                            </div>
                        </div>
                        <div class="row" id="inPasCont">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" minlength="5" maxlength="30" class="form-control" placeholder="Ingresa la INE" id="ineInput" name="ine">
                                    <label for="ineInput">INE</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" minlength="5" maxlength="30" class="form-control" placeholder="Ingresa el pasaporte" id="pasaporteInput" name="pasaporte">
                                    <label for="pasaporteInput">Pasaporte</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="venCuentCont">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" placeholder="Ingresa la fecha de vencimiento del pasaporte" id="fechapasInput" name="fechapas">
                                    <label for="fechapasInput">Fecha vencimiento de pasaporte</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" minlength="5" maxlength="30" class="form-control" placeholder="Ingresa la cuenta Swift" id="swiftInput" name="swift" value="SWQBCHZZXXX">
                                    <label for="swiftInput">Cuenta Swift</label>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center" id="ibanCont">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" minlength="5" maxlength="30" class="form-control" placeholder="Ingresa la cuenta IBAN" id="ibanInput" name="iban" value="CH">
                                    <label for="ibanInput">Cuenta IBAN</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" name="tarjeta" type="checkbox" role="switch" id="tarjetaInput">
                                    <label class="form-check-label" for="tarjetaInput">¿Tiene tarjeta?</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" id="cargarCliente">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    Carga los documentos del cliente:
                                </div>
                            </div>
                        </div>
                        <div class="row" id="inePasCont">
                            <div class="col-md-6 col-12 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label for="ineDocumentoInput" class="form-label">INE (documento)</label>
                                    <a id="ineDocumentoDesc" class="d-none fs-5 text-secondary"><i class="bi bi-download"></i></a>
                                </div>
                                <input type="file" id="ineDocumentoInput" class="form-control form-control-sm" name="ine_documento">
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label for="pasaporteDocumentoInput" class="form-label">Pasaporte (documento)</label>
                                    <a id="pasaporteDocumentoDesc" class="d-none fs-5 text-secondary"><i class="bi bi-download"></i></a>
                                </div>
                                <input type="file" id="pasaporteDocumentoInput" class="form-control form-control-sm" name="pasaporte_documento">
                            </div>
                        </div>
                        <div class="row" id="comprobanteLPOACont">
                            <div class="col-md-6 col-12 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label for="comprobanteDomicilioInput" class="form-label">Comprobante de domicilio</label>
                                    <a id="comprobanteDomicilioDesc" class="d-none fs-5 text-secondary"><i class="bi bi-download"></i></a>
                                </div>
                                <input type="file" id="comprobanteDomicilioInput" class="form-control form-control-sm" name="comprobante_domicilio">
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label for="LPOADocumentoInput" class="form-label">LPOA (documento)</label>
                                    <a id="LPOADocumentoDesc" class="d-none fs-5 text-secondary"><i class="bi bi-download"></i></a>
                                </div>
                                <input type="file" id="LPOADocumentoInput" class="form-control form-control-sm" name="lpoa_documento">
                            </div>
                        </div>
                        <div class="row" id="formAPRICont">
                            <div class="col-md-6 col-12 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label for="formAperturaInput" class="form-label">Formulario de apertura</label>
                                    <a id="formAperturaDesc" class="d-none fs-5 text-secondary"><i class="bi bi-download"></i></a>
                                </div>
                                <input type="file" id="formAperturaInput" class="form-control form-control-sm" name="formulario_apertura">
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label for="formRiesgosInput" class="form-label">Formulario de riesgos</label>
                                    <a id="formRiesgosDesc" class="d-none fs-5 text-secondary"><i class="bi bi-download"></i></a>
                                </div>
                                <input type="file" id="formRiesgosInput" class="form-control form-control-sm" name="formulario_riesgos">
                            </div>
                        </div>
                        <div id="alertMessage"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnSubmit">Añadir cliente</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formModalWhats" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Mandar mensaje</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" style="text-transform: none !important;" placeholder="Ingresa el nombre" id="nombreInputWhats" readonly>
                                <label for="nombreInputWhats">Cliente</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" style="text-transform: none !important;" placeholder="Ingresa el nombre" id="numeroInputWhats" readonly>
                                <label for="numeroInputWhats">Número</label>
                            </div>
                        </div>                    
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <textarea type="text" class="form-control" placeholder="Ingresa el mensaje" id="mensajeInputWhats" title="Ingresa el mensaje" style="height: 150px; text-transform: none !important;" required></textarea>
                                <label for="mensajeInputWhats">Mensaje</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn principal-button" id="enviarWhats">Enviar WhatsApp</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formModalNota" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleNota">Añadir nota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formNota" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInputNota">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label for="comprobanteInput" class="form-label">Comprobante de pago</label>
                                    <a id="comprobanteDesc" class="d-none fs-5 text-secondary"><i class="bi bi-download"></i></a>
                                </div>
                                <input type="file" id="comprobanteInput" class="form-control" name="comprobante_pago" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" placeholder="Ingresa la nota" id="notaInput" name="nota_contrato" title="Ingresa la nota" style="height: 200px; text-transform: none !important;" required></textarea>
                                    <label for="notaInput">Nota</label>
                                </div>
                            </div>
                        </div>
                        <div id="alertMessageNota"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancelNota" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnSubmitNota">Añadir nota</button>
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

    <script src="https://unpkg.com/pdf-lib@1.4.0"></script>
    <script src="https://unpkg.com/@pdf-lib/fontkit/dist/fontkit.umd.min.js"></script>
    <script src="https://unpkg.com/downloadjs@1.4.7"></script>
    <script src='https://unpkg.com/tesseract.js@v2.1.0/dist/tesseract.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.1.266/build/pdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.1.266/build/pdf.worker.min.js"></script>
    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>
    <script src="{{ asset('js/cliente.js') }}"></script>
@endsection