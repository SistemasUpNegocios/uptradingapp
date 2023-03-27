@extends('index')

@section('title', 'Formularios de cuenta Forex')

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
        <h1>Formularios de cuenta Forex</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Formularios de cuenta Forex</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body mt-3">
                        @if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
                            <div class="col-12">
                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                        <use xlink:href="#info-fill" />
                                    </svg>
                                    <div>
                                        Elige a un PS para filtrar los formularios de cuenta Forex
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <select class="form-select selectSearch" id="psIdInput" >
                                    <option value="todos" selected>TODOS</option>
                                    @foreach($lista_ps as $ps)
                                        <option data-id="{{ $ps->id }}" value="{{ $ps->id }}">
                                            {{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="psIdInput">PS</label>
                            </div>
                        @endif
                        <a class="btn principal-button mb-3 new" data-bs-toggle="modal" data-bs-target="#formModal"> <i class="bi-plus-lg me-1"> </i>Apertura de cuenta Forex</a>
                        <table class="table table-striped table-bordered nowrap text-center" id="formulario">
                            <thead>
                                <tr>
                                    <th data-priority="0" scope="col">Código cliente</th>
                                    <th data-priority="0" scope="col">Nombre</th>
                                    <th data-priority="0" scope="col">Apellido paterno</th>
                                    <th data-priority="0" scope="col">Apellido materno</th>
                                    <th data-priority="0" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="formularioBody" style="vertical-align: middle;">
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
                    <h5 class="modal-title" id="modalTitle">Formulario de cuenta Forex</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formularioForm" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInput">
                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    INFORMACIÓN PERSONAL:
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
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control" placeholder="Ingresa el nombre" id="nombreInput" name="nombre">
                                    <label for="nombreInput">Nombre</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control" placeholder="Ingresa el apellido paterno" id="apellidoPatInput" name="apellido_p">
                                    <label for="apellidoPatInput">Apellido paterno</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control" placeholder="Ingresa el apellido materno" id="apellidoMatInput" name="apellido_m">
                                    <label for="apellidoMatInput">Apellido materno</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input style="text-transform: lowercase;" type="email" title="Campo obligatorio / example@uptrading.com" minlength="3" maxlength="70" class="form-control" placeholder="Ingresa el correo institucional" id="correoiInput" name="correo_institucional">
                                    <label for="correoiInput">Email institucional</label>
                                    <input type="hidden" id="correotInput" name="correo_temp">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" placeholder="Ingresa la fecha de nacimiento" id="fechaNacInput" name="fecha_nacimiento">
                                    <label for="fechaNacInput">Fecha de nacimiento</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                        <div class="row">                        
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control" placeholder="Ingresa la nacionalidad" id="nacionalidadInput" name="nacionalidad">
                                    <label for="nacionalidadInput">Nacionalidad</label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="mb-1">
                                    <label><strong>Estado civil</strong></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="estado_civil" id="solteroInput" value="SOLTERO">
                                    <label class="form-check-label" for="solteroInput">Soltero</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="estado_civil" id="casadoInput" value="CASADO">
                                    <label class="form-check-label" for="casadoInput">Casado</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="estado_civil" id="concubinatoInput" value="CONCUBINATO">
                                    <label class="form-check-label" for="concubinatoInput">Concubinato</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    INFORMACIÓN LEGAL:
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" minlength="3" maxlength="50" class="form-control" placeholder="Ingresa la dirección" id="direccionInput" name="direccion">
                                    <label for="direccionInput">Dirección</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" minlength="3" maxlength="30" class="form-control" placeholder="Ingresa la colonia/fraccionamiento" id="colFraccInput" name="colonia">
                                    <label for="colFraccInput">Colonia/Fraccionamiento</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" title="Campo obligatorio / Solo números" minlength="5" maxlength="5" pattern="[0-9]+" class="form-control" placeholder="Ingresa el código postal" id="cpInput" name="cp">
                                    <label for="cpInput">Código postal</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" minlength="3" maxlength="30" " class="form-control" placeholder="Ingresa la ciudad" id="ciudadInput" name="ciudad">
                                    <label for="ciudadInput">Ciudad</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" class="form-control" placeholder="Ingresa el estado" id="estadoInput" name="estado"  >
                                    <label for="estadoInput">Estado</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" class="form-control" placeholder="Ingresa el pais" id="paisInput" name="pais"  >
                                    <label for="paisInput">País</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    INFORMACIÓN DE CONTACTO:
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" title="Campo obligatorio / Solo números" minlength="10" maxlength="10" pattern="[0-9]+" class="form-control" placeholder="Ingresa el número celular" id="celularInput" name="celular"  >
                                    <label for="celularInput">Celular</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input style="text-transform: lowercase;" type="email" title="Campo obligatorio / example@gmail.com" minlength="3" maxlength="70" class="form-control" placeholder="Ingresa el correo personal" id="correopInput" name="correo_personal"  >
                                    <label for="correopInput">Email personal</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    PERFIL DEL CLIENTE:
                                </div>
                            </div>
                        </div>
                        <div class="row">       
                            <div class="col-12 mb-3">
                                <div class="mb-1">
                                    <label><strong>¿Ha vivido o trabajado fuera de México?</strong></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="fuera_mexico" id="trabajoFueraSiInput" value="SI">
                                    <label class="form-check-label" for="trabajoFueraSiInput">Si</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="fuera_mexico" id="trabajoFueraNoInput" value="NO">
                                    <label class="form-check-label" for="trabajoFueraNoInput">No</label>
                                </div>
                            </div>                 
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <select name="situacion_laboral" class="form-control" id="situacionLaboralInput"  >
                                        <option value="" disabled selected>Selecciona..</option>
                                        <option value="AJENA">Empleado por cuenta ajena</option>
                                        <option value="PROPIA">Empleado por cuenta propia</option>
                                        <option value="DESEMPLEADO">Desempleado/a</option>
                                        <option value="JUBILADO">Jubilado/a</option>
                                        <option value="ESTUDIANTE">Estudiante</option>
                                        <option value="OTROS">Otros</option>
                                    </select>
                                    <label for="situacionLaboralInput">Situacion laboral</label>
                                </div>
                            </div>                        
                        </div>
                        <div class="row d-none" id="ajenaContainer">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="Ingresa el nombre o descripción de la empresa" id="empresaAjenaInput" name="nombre_direccion" style="height: 100px" ></textarea>
                                    <label for="empresaAjenaInput">Nombre y dirección de la empresa</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingresa tu puesto de trabajo actual" id="puestoTrabajoAjenaInput" name="puesto">
                                    <label for="puestoTrabajoAjenaInput">Puesto de trabajo</label>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="mb-1">
                                    <label><strong>¿A qué giro pertenece la empresa?</strong></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="giro_empresa" id="serviciosAjenaInput" value="SERVICIOS">
                                    <label class="form-check-label" for="serviciosAjenaInput">Servicios</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="giro_empresa" id="comercialAjenaInput" value="COMERCIAL">
                                    <label class="form-check-label" for="comercialAjenaInput">Comercial</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="giro_empresa" id="industrialAjenaInput" value="INDUSTRIAL">
                                    <label class="form-check-label" for="industrialAjenaInput">Industrial</label>
                                </div>
                            </div>                        
                            <div class="col-12 mb-3">
                                <div class="mb-1">
                                    <label><strong>¿A que sector pertenece la empresa?</strong></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sector_empresa" id="publicoAjenaInput" value="PUBLICO">
                                    <label class="form-check-label" for="publicoAjenaInput">Público</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sector_empresa" id="privadoAjenaInput" value="PRIVADO">
                                    <label class="form-check-label" for="privadoAjenaInput">Privado</label>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none" id="propiaContainer">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" placeholder="Ingresa el nombre de la empresa" id="empresaPropiaInput" name="nombre_direccion2" style="height: 100px" ></textarea>
                                    <label for="empresaPropiaInput">Nombre y dirección de la empresa</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingresa tu puesto de trabajo actual" id="puestoTrabajoPropiaInput" name="puesto2">
                                    <label for="puestoTrabajoPropiaInput">Puesto de trabajo</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingresa el porcentaje de participación" id="porcentajeAccionesInput" name="porcentaje_acciones">
                                    <label for="porcentajeAccionesInput">Porcentaje de participación (acciones)</label>
                                </div>
                            </div>                        
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingresa el monto aproximado que se factura al año" id="montoFacturadoInput" name="monto_anio">
                                    <label for="montoFacturadoInput">Monto aproximado que se factura al año</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingresa la página web de la empresa" id="paginaWebInput" name="pagina_web"  >
                                    <label for="paginaWebInput">Página web de la empresa</label>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="mb-1">
                                    <label><strong>¿A qué giro pertenece la empresa?</strong></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="giro_empresa" id="serviciosPropiaInput" value="SERVICIOS">
                                    <label class="form-check-label" for="serviciosPropiaInput">Servicios</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="giro_empresa" id="comercialPropiaInput" value="COMERCIAL">
                                    <label class="form-check-label" for="comercialPropiaInput">Comercial</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="giro_empresa" id="industrialPropiaInput" value="INDUSTRIAL">
                                    <label class="form-check-label" for="industrialPropiaInput">Industrial</label>
                                </div>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <div class="mb-1">
                                    <label><strong>Personas a su cargo</strong></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="personas_cargo" id="personasCargo0Input" value="0">
                                    <label class="form-check-label" for="personasCargo0Input">0</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="personas_cargo" id="personasCargo1Input" value="1">
                                    <label class="form-check-label" for="personasCargo1Input">1</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="personas_cargo" id="personasCargo2Input" value="2">
                                    <label class="form-check-label" for="personasCargo2Input">2</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="personas_cargo" id="personasCargo3Input" value="3">
                                    <label class="form-check-label" for="personasCargo3Input">3</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="personas_cargo" id="personasCargo4Input" value="4">
                                    <label class="form-check-label" for="personasCargo4Input">4</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="personas_cargo" id="personasCargo5Input" value="5">
                                    <label class="form-check-label" for="personasCargo5Input">5</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="personas_cargo" id="personasCargo6Input" value="6">
                                    <label class="form-check-label" for="personasCargo6Input">6</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="personas_cargo" id="personasCargo7Input" value="7">
                                    <label class="form-check-label" for="personasCargo7Input">7</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="personas_cargo" id="personasCargo8Input" value="8">
                                    <label class="form-check-label" for="personasCargo8Input">8</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="personas_cargo" id="personasCargo9Input" value="9">
                                    <label class="form-check-label" for="personasCargo9Input">9</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="personas_cargo" id="personasCargo10Input" value="10">
                                    <label class="form-check-label" for="personasCargo10Input">10</label>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none" id="desempleadoContainer">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingrese el último empleo" id="ultimoEmpleoInput" name="ultimo_empleo">
                                    <label for="ultimoEmpleoInput">Último empleo</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingrese el último empleador" id="ultimoEmpleadorInput" name="ultimo_empleador">
                                    <label for="ultimoEmpleadorInput">Último empleador</label>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none" id="jubiladoContainer">                        
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingrese su ultimo empleo" id="empleoInput" name="ultimo_empleo2">
                                    <label for="empleoInput">Especifique el último empleo</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingrese el monto mensual de jubilación" id="montoMensualInput" name="monto_mensual_jubilacion">
                                    <label for="montoMensualInput">Monto mensual de jubilación</label>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="mb-1">
                                    <label><strong>¿Qué estatus tenia en su actividad anterior?</strong></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_anterior" id="ajenaInput" value="AJENA">
                                    <label class="form-check-label" for="ajenaInput">Empleado por cuenta ajena</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_anterior" id="propiaInput" value="PROPIA">
                                    <label class="form-check-label" for="propiaInput">Empleado por cuenta propia</label>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none" id="estudianteContainer">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingrese su escuela" id="escuelaInput" name="escuela_universidad">
                                    <label for="escuelaInput">Escuela / Universidad</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingrese su campo o facultad" id="facultadInput" name="campo_facultad">
                                    <label for="facultadInput">Campo / Facultad</label>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none" id="otroContainer">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" placeholder="Especifique la situación laboral" id="especifiqueInput" name="especificacion_trabajo" style="height: 100px" ></textarea>
                                    <label for="especifiqueInput">Especifique</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="mb-1">
                                    <label><strong>¿Ejerce algúna función pública importante?</strong></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="funcion_publica" id="funcionPublicaSiInput" value="SI">
                                    <label class="form-check-label" for="funcionPublicaSiInput">Si</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="funcion_publica" id="funcionPublicaNoInput" value="NO">
                                    <label class="form-check-label" for="funcionPublicaNoInput">No</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" placeholder="Ingresa la descripcion de la de la función pública" id="funcionPublicaInput" name="descripcion_funcion_publica" title="Ingresa la descripcion de la de la función pública" style="height: 100px"></textarea>
                                    <label for="funcionPublicaInput">Función pública</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingresa tu residencia" id="residenciaInput" name="residencia">
                                    <label for="residenciaInput">Residencia</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingresa la RFC" id="rfcInput" name="rfc">
                                    <label for="rfcInput">RFC con Homoclave</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    INFORMACIÓN DE LA INVERSIÓN:
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingresa el deposito inicial" id="depositoInput" name="deposito_inicial">
                                    <label for="depositoInput">Depósito inicial estimado (USD)</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingresa el origen del dinero de la cuenta que se abrirá en Swissquote" id="origenDinero" name="origen_dinero" value="Ahorros">
                                    <label for="origenDinero">Origen del dinero de la cuenta Swissquote</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    INFORMACIÓN DEL PS:
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    @if (auth()->user()->is_ps_gold)
                                        @php 
                                            $ps = \App\Models\Ps::select()->where("correo_institucional", auth()->user()->correo)->first();
                                        @endphp
                                        
                                        <select name="ps_id" minlength="3" maxlength="120" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-select selectSearch" id="psInput">
                                            <option value="" disabled>Selecciona..</option>
                                            <option value="{{ $ps->id }}" selected>
                                                {{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}
                                            </option>
                                        </select>
                                    @elseif(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_ps_diamond)
                                        <select name="ps_id" minlength="3" maxlength="120" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-select selectSearch" id="psInput">
                                            <option value="" disabled selected>Selecciona..</option>
                                            @foreach($lista_ps as $ps)
                                                <option value="{{ $ps->id }}">
                                                    {{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                    <label for="psInput">Nombre completo</label>
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

    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>
    @if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
        <script src="{{ asset('js/formulariofiltro.js') }}"></script>
    @endif
    <script src="{{ asset('js/formulario.js') }}"></script>
@endsection