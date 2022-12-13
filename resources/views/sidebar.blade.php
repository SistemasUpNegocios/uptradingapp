<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ url('/admin/dashboard') }}" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block">Administrador Up Trading</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn menu-pc" id="btntog"></i>
        <a class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
            aria-controls="offcanvasExample">
            <i class="bi bi-list toggle-sidebar-btn menu-cel" id="btntog"></i>
        </a>
    </div>

    <div class="search-bar">
        <form id="busquedaForm" class="search-form d-flex align-items-center" method="POST"
            action="/admin/buscarCliente">
            @csrf
            <input type="text" name="query" placeholder="Buscar cliente" title="Ingresa el nombre del cliente" required>
            <button type="submit" title="Buscar"><i class="bi bi-search"></i></button>
        </form>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle" href="#" onClick="return false;">
                    <i class="bi bi-search"></i>
                </a>
            </li>
            <li class="nav-item" id="preguntas" title="Preguntas Frecuentes">
                <a class="nav-link nav-icon fs-5" href="#" data-bs-toggle="modal" data-bs-target="#formModalFaq">
                    <i class="bi bi-question-octagon"></i>
                </a>
            </li>

            <li class="nav-item dropdown" id="notificaciones">

                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-primary badge-number" id="numeroNotifBadge"></span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages" id="contNotificaciones"></ul>

            </li>

            <li class="nav-item dropdown pe-3">

                <?php $foto = auth()->user()->foto_perfil;  ?>

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset("img/usuarios/$foto") }}" id="imgPerfilNav" alt="Foto de perfil"
                        class="rounded-circle profilephoto2">
                    <span id="nombreSide" class="d-none d-md-block dropdown-toggle ps-2">
                        {{ auth()->user()->nombre }} {{ auth()->user()->apellido_p }}
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6 id="nombreCompletoSide">
                            {{ auth()->user()->nombre }} {{ auth()->user()->apellido_p }} {{ auth()->user()->apellido_m
                            }}
                        </h6>
                        <span>
                            @if (auth()->user()->is_ps_encargado)
                            PS ENCARGADO
                            @elseif(auth()->user()->is_ps_asistente)
                            PS ASISTENTE
                            @elseif(auth()->user()->is_cliente)
                            CLIENTE
                            @elseif (auth()->user()->is_cliente_ps_encargado)
                            CLIENTE & PS ENCARGADO
                            @elseif(auth()->user()->is_cliente_ps_asistente)
                            CLIENTE & PS ASISTENTE
                            @else
                            Usuario <span style="text-transform: uppercase">{{ auth()->user()->privilegio }}</span>
                            @endif
                        </span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ URL::to('admin/perfil') }}">
                            <i class="bi bi-person"></i>
                            <span>Mi cuenta</span>
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>


                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Cerrar sesión</span>
                        </a>
                    </li>

                </ul>
            </li>
        </ul>
    </nav>

</header>

@php
    use App\Models\User;
    $ps_encargados = User::where('privilegio', 'ps_encargado')->get();
@endphp

<div class="sidebar-nav sidebar offcanvas offcanvas-start" tabindex="-1" id="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-heading">Menú</li>

        <li class="nav-item">
            <a class="@if (request()->is('admin/dashboard')) nav-link @else nav-link collapsed @endif"
                href="{{ URL::to('admin/dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Vista general</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="@if (request()->is('admin/perfil')) nav-link @else nav-link collapsed @endif"
                href="{{ URL::to('admin/perfil') }}">
                <i class="bi bi-person"></i>
                <span>Mi cuenta</span>
            </a>
        </li>

        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_encargado)
            <li class="nav-item">
                <a class="@if (request()->is('admin/tickets')) nav-link @else nav-link collapsed @endif"
                    href="{{ URL::to('admin/tickets') }}">
                    <i class="bi bi-send"></i>
                    <span>Tickets</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#chat-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-whatsapp"></i><span>Chat de ayuda</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="chat-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    
                    @if (auth()->user()->id != 1)
                        <li>
                            <a href="#" id="deptoSistemas" class="chatModal" data-chatid="1">
                                <i class="bi bi-circle"></i><span>Departamento de sistemas</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->id != 246)
                        <li>
                            <a href="#" id="deptoEgresos" class="chatModal" data-chatid="246">
                                <i class="bi bi-circle"></i><span>Departamento de egresos</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-heading">Departamento de administración</li>
                    @if (auth()->user()->id != 234)
                        <li>
                            <a href="#" id="deptoAdmin" class="chatModal" data-chatid="234">
                                <i class="bi bi-circle"></i><span>Maru</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->id != 235)
                        <li>
                            <a href="#" id="deptoAdmin" class="chatModal" data-chatid="235">
                                <i class="bi bi-circle"></i><span>Karen</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-heading">Departamento de contabilidad</li>
                    @if (auth()->user()->id != 236)
                        <li>
                            <a href="#" id="deptoConta" class="chatModal" data-chatid="236">
                                <i class="bi bi-circle"></i><span>Valeria</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->id != 239)
                        <li>
                            <a href="#" id="deptoConta" class="chatModal" data-chatid="239">
                                <i class="bi bi-circle"></i><span>Ofelia</span>
                            </a>
                        </li>
                    @endif

                    @if (!auth()->user()->is_ps_encargado)
                        <li class="nav-heading">PS encargados</li>
                        @foreach ($ps_encargados as $ps)
                            @if (auth()->user()->id != $ps->id)
                                <li>
                                    <a href="#" class="chatModal deptoPs" data-chatid="{{ $ps->id }}">
                                        <i class="bi bi-circle"></i><span>{{ $ps->nombre }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </li>
        @endif

        <li class="nav-heading">Opciones de administrador</li>
        @if (!auth()->user()->is_cliente)
            <li class="nav-item">
                <a class="@if (request()->is('admin/cliente')) nav-link @else nav-link collapsed @endif"
                    href="{{ URL::to('admin/cliente') }}">
                    <i class="bi bi-people"></i>
                    <span>Clientes</span>
                </a>
            </li>
        @endif

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#herramientas-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-tools"></i><span>Herramientas</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="herramientas-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)            
                    <li>
                        <a href="{{ URL::to('admin/agenda') }}">
                            <i class="bi bi-circle"></i><span>Agenda</span>
                        </a>
                    </li>
                @endif
                @if (!auth()->user()->is_cliente)
                    <li>
                        <a href="{{ URL::to('admin/intencionInversion') }}">
                            <i class="bi bi-circle"></i><span>Intención de inversión</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/formulario') }}">
                            <i class="bi bi-circle"></i><span>Formulario cuenta Forex</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/checklist') }}">
                            <i class="bi bi-circle"></i><span>Checklist de nuevos clientes</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ URL::to('admin/documentos') }}">
                        <i class="bi bi-circle"></i><span>Documentos</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#contratos-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-file-earmark-richtext"></i><span>Contratos</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="contratos-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ URL::to('admin/contrato') }}">
                        <i class="bi bi-circle"></i><span>Contratos</span>
                    </a>
                </li>
                @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)
                    <li>
                        <a href="{{ URL::to('admin/contratoTerminado') }}">
                            <i class="bi bi-circle"></i><span>Contratos terminados</span>
                        </a>
                    </li>
                @endif
                @if (auth()->user()->is_root)
                    <li>
                        <a href="{{ URL::to('admin/modelo') }}">
                            <i class="bi bi-circle"></i><span>Modelos de contrato</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/tipocontrato') }}">
                            <i class="bi bi-circle"></i><span>Tipos de contrato</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#convenios-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-file-earmark-text"></i><span>Convenios MAM</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="convenios-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ URL::to('admin/convenio') }}">
                        <i class="bi bi-circle"></i><span>Convenios</span>
                    </a>
                </li>
            </ul>
        </li>

        @if (!auth()->user()->is_ps_asistente)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#pagosCliente-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-cash"></i><span>Pagos a clientes</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="pagosCliente-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ URL::to('admin/pagosCliente') }}">
                            <i class="bi bi-circle"></i><span>Pagos a clientes (compuesto y mensual)</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/reportePagosCliente') }}">
                            <i class="bi bi-circle"></i><span>Reporte de pagos a clientes</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/reportePagosClienteOficina') }}">
                            <i class="bi bi-circle"></i><span>Reporte de pagos a clientes por oficina</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (!auth()->user()->is_cliente)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#pagos-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-cash"></i><span>Pagos a PS</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="pagos-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li class="nav-heading">Rendimiento compuesto y mensual</li>
                    <li>
                        <a href="{{ URL::to('admin/pagoPS') }}">
                            <i class="bi bi-circle"></i><span>Pago a PS</span>
                        </a>
                    </li>                    
                    <li class="nav-heading">Convenios</li>
                    <li>
                        <a href="{{ URL::to('admin/pagoPSConvenio') }}">
                            <i class="bi bi-circle"></i><span>Pagos a PS</span>
                        </a>
                    </li>                
                </ul>
            </li>
        @endif

        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos ||
        auth()->user()->is_ps_encargado)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#ps-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person-workspace"></i><span>PS</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="ps-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    @if (!auth()->user()->is_ps_encargado && !auth()->user()->is_ps_asistente)
                        <li>
                            <a href="{{ URL::to('admin/oficina') }}">
                                <i class="bi bi-circle"></i><span>Oficinas</span>
                            </a>
                        </li>                        
                        <li>
                            <a href="{{ URL::to('admin/psOficina') }}">
                                <i class="bi bi-circle"></i><span>PS de oficina</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ URL::to('admin/ps') }}">
                            <i class="bi bi-circle"></i><span>PS</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/resumenPS') }}">
                            <i class="bi bi-circle"></i><span>Resumen de PS</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/psmovil') }}">
                            <i class="bi bi-circle"></i><span>PS Móvil</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#contenidositio-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-window-split"></i><span>Gestión</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="contenidositio-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ URL::to('admin/banco') }}">
                            <i class="bi bi-circle"></i><span>Bancos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/bitacora') }}">
                            <i class="bi bi-circle"></i><span>Bitacora</span>
                        </a>
                    </li>                
                    <li>
                        <a href="{{ URL::to('admin/tipocambio') }}">
                            <i class="bi bi-circle"></i><span>Tipo de cambio</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/preguntas') }}">
                            <i class="bi bi-circle"></i><span>Preguntas</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (auth()->user()->is_root)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#porcentajes-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-percent"></i><span>Porcentajes</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="porcentajes-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ URL::to('admin/porcentaje') }}">
                            <i class="bi bi-circle"></i><span>Cambiar porcentaje de contratos</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ URL::to('admin/cuentasGoogle') }}">
                    <i class="bi bi-google"></i>
                    <span>Cuentas Google</span>
                </a>
            </li>
        @endif

        @if (auth()->user()->is_root)
            <li class="nav-heading">Configuración</li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#control-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-clock-history"></i><span>Control</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="control-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ URL::to('admin/bitacoraAcceso') }}">
                            <i class="bi bi-circle"></i><span>Bitácora de accesos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/historialCambios') }}">
                            <i class="bi bi-circle"></i><span>Historial de cambios</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#configuracion-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-gear"></i><span>Configuración</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="configuracion-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ URL::to('admin/usuario') }}">
                            <i class="bi bi-circle"></i><span>Usuarios del sistema</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('logout') }}">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Cerrar sesión</span>
            </a>
        </li>

    </ul>
</div>