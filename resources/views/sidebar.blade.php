<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between administrador_up">
        <a href="{{ url('/admin/dashboard') }}" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block">Administrador Up Trading</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn menu-pc" id="btntog"></i>
        <a class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
            aria-controls="offcanvasExample">
            <i class="bi bi-list toggle-sidebar-btn menu-cel" id="btntog"></i>
        </a>
    </div>

    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
        <div class="search-bar">
            <form id="busquedaForm" class="search-form d-flex align-items-center" method="POST"
                action="/admin/buscarCliente">
                @csrf
                <input type="text" name="query" placeholder="Buscar cliente" title="Ingresa el nombre del cliente" required>
                <button type="submit" title="Buscar"><i class="bi bi-search"></i></button>
            </form>
        </div>
    @endif

    <div class="align-items-center text-center text-white w-100 valor_dolar_menu" style="font-size: 14px;"><b id="valor_dolar_dashboard"></b></div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle" href="#" onClick="return false;">
                    <i class="bi bi-search"></i>
                </a>
            </li>

            @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_gold || auth()->user()->is_ps_diamond || auth()->user()->is_ps_bronze)
                <li class="nav-item" id="preguntas" title="Preguntas Frecuentes">
                    <a class="nav-link nav-icon fs-5" href="#" data-bs-toggle="modal" data-bs-target="#formModalFaq">
                        <i class="bi bi-question-octagon"></i>
                    </a>
                </li>
            @endif

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
                            @if(auth()->user()->is_root)
                                SUPERUSUARIO
                            @elseif(auth()->user()->is_admin || auth()->user()->is_procesos)
                                ADMINISTRADORA
                            @elseif(auth()->user()->is_contabilidad)
                                CONTADORA
                            @elseif (auth()->user()->is_ps_diamond)
                                PS DIAMOND
                            @elseif(auth()->user()->is_ps_gold || auth()->user()->is_ps_bronze)
                                PS GOLD
                            @elseif(auth()->user()->is_cliente)
                                CLIENTE                                                      
                            @else
                                Usuario de <span style="text-transform: uppercase">{{ auth()->user()->privilegio }}</span>
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
    $ps_golds = User::where('privilegio', 'ps_gold')->orWhere('privilegio', 'ps_diamond')->get();
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

        @if (!auth()->user()->is_cliente)
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
                    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_gold || auth()->user()->is_ps_bronze || auth()->user()->is_ps_diamond)
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
                    @endif

                    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)
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

                        @if (!auth()->user()->is_ps_gold && !auth()->user()->is_ps_bronze)
                            <li class="nav-heading">PS GOLD</li>
                            @foreach ($ps_golds as $ps)
                                @if (auth()->user()->id != $ps->id)
                                    <li>
                                        <a href="#" class="chatModal deptoPs" data-chatid="{{ $ps->id }}">
                                            <i class="bi bi-circle"></i><span>{{ $ps->nombre }} {{ $ps->apellido_p }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endif
                </ul>
            </li>
        @endif

        <li class="nav-heading">Opciones de administrador</li>
        @if (auth()->user()->is_root)
            <li class="nav-item">
                <a class="@if (request()->is('admin/porcentaje')) nav-link @else nav-link collapsed @endif"
                    href="{{ URL::to('admin/porcentaje') }}">                
                    <i class="bi bi-percent"></i>
                    <span>Porcentajes</span>
                </a>
            </li>
        @endif

        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_diamond)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#clientes-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-people"></i>Clientes</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="clientes-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">                    
                    <li>
                        <a href="{{ URL::to('admin/cliente') }}">
                            <i class="bi bi-circle"></i><span>Clientes</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/cuentasmam') }}">
                            <i class="bi bi-circle"></i><span>Cuentas MAM</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/conteocontratosclientes') }}">
                            <i class="bi bi-circle"></i><span>Número de contratos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/conteoconveniosclientes') }}">
                            <i class="bi bi-circle"></i><span>Número de convenios</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_gold || auth()->user()->is_ps_diamond || auth()->user()->is_ps_bronze)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#herramientas-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-tools"></i><span>Herramientas</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="herramientas-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">                    
                    <li>
                        <a href="{{ URL::to('admin/agenda') }}">
                            <i class="bi bi-circle"></i><span>Agenda</span>
                        </a>
                    </li>
                    {{-- @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_ps_gold || auth()->user()->is_ps_diamond || auth()->user()->is_ps_bronze)
                        <li>
                            <a href="{{ URL::to('admin/notas') }}">
                                <i class="bi bi-circle"></i><span>Notas MAM</span>
                            </a>
                        </li>
                    @endif --}}
                    <li>
                        <a href="{{ URL::to('admin/documentos') }}">
                            <i class="bi bi-circle"></i><span>Documentos</span>
                        </a>
                    </li>
                    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
                        <li>
                            <a href="{{ URL::to('admin/concentrado') }}">
                                <i class="bi bi-circle"></i><span>Concentrados</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('admin/flujodinero') }}">
                                <i class="bi bi-circle"></i><span>Flujo de dinero</span>
                            </a>
                        </li>
                    @endif
                    @if (!auth()->user()->is_ps_diamond && !auth()->user()->is_ps_bronze)
                        <li>
                            <a href="{{ URL::to('admin/intencionInversion') }}">
                                <i class="bi bi-circle"></i><span>Intención de inversión</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ URL::to('admin/checklist') }}">
                            <i class="bi bi-circle"></i><span>Checklist de nuevos clientes</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_ps_diamond || auth()->user()->is_ps_gold || auth()->user()->is_ps_bronze)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#formulario-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-ui-checks"></i><span>Formularios</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="formulario-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ URL::to('admin/formulario') }}">
                            <i class="bi bi-circle"></i><span>Formulario Forex</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('https://trade.swissquote.ch/signup/public/form/full/fx/com/individual?lang=es&partnerid=61f9eacc-7353-43d3-9b4f-bd965c7e8419#full/fx/com/individual/step1') }}" target="_blank">
                            <i class="bi bi-circle"></i><span>Formulario Swissquote</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (!auth()->user()->is_ps_bronze && !auth()->user()->is_ps_diamond)
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
                            <a href="{{ URL::to('admin/contratovencer') }}">
                                <i class="bi bi-circle"></i><span>Contratos a vencer</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('admin/contratoTerminado') }}">
                                <i class="bi bi-circle"></i><span>Contratos terminados</span>
                            </a>
                        </li>                    
                    @endif
                </ul>
            </li>
        @endif
        
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
                @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)
                    <li>
                        <a href="{{ URL::to('admin/conveniovencer') }}">
                            <i class="bi bi-circle"></i><span>Convenios a vencer</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/convenioTerminado') }}">
                            <i class="bi bi-circle"></i><span>Convenios terminados</span>
                        </a>
                    </li>                    
                @endif
                <li>
                    <a href="{{ URL::to('admin/incrementoConvenio') }}">
                        <i class="bi bi-circle"></i><span>Incremento cuenta MAM</span>
                    </a>
                </li>
            </ul>
        </li>

        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_gold || auth()->user()->is_cliente)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#pagosCliente-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-cash"></i><span>Pagos a clientes</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="pagosCliente-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_gold || auth()->user()->is_cliente)
                        <li class="nav-heading">Tabla</li>
                        <li>
                            <a href="{{ URL::to('admin/pagosCliente') }}">
                                <i class="bi bi-circle"></i><span>Pagos a clientes (compuesto y mensual)</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)
                        <li class="nav-heading">Rendimiento mensual</li>
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
                    @endif
                </ul>
            </li>
        @endif
        
        @if (!auth()->user()->is_cliente)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#pagos-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-cash-stack"></i><span>Pagos a PS</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="pagos-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_gold)
                        <li class="nav-heading">Rendimiento compuesto y mensual</li>
                        <li>
                            <a href="{{ URL::to('admin/pagoPS') }}">
                                <i class="bi bi-circle"></i><span>Pago a PS</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_diamond || auth()->user()->is_ps_bronze)
                        <li class="nav-heading">Convenios</li>
                        <li>
                            <a href="{{ URL::to('admin/pagoPSConvenio') }}">
                                <i class="bi bi-circle"></i><span>Pagos a PS</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)
                        <li class="nav-heading">Reporte de pagos</li>
                        <li>
                            <a href="{{ URL::to('admin/resumenPS') }}">
                                <i class="bi bi-circle"></i><span>Resumen de PS</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('admin/reportePagosPs') }}">
                                <i class="bi bi-circle"></i><span>Reporte de pagos de PS</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        
        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#ps-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person-workspace"></i><span>PS</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="ps-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ URL::to('admin/ps') }}">
                            <i class="bi bi-circle"></i><span>PS</span>
                        </a>
                    </li>                    
                    <li>
                        <a href="{{ URL::to('admin/psmovil') }}">
                            <i class="bi bi-circle"></i><span>PS Móvil</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/conteocontratosps') }}">
                            <i class="bi bi-circle"></i><span>Número de contratos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/conteoconveniosps') }}">
                            <i class="bi bi-circle"></i><span>Número de convenios</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/oficina') }}">
                            <i class="bi bi-circle"></i><span>Oficinas</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        
        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#contenidositio-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-window-split"></i><span>Gestión</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="contenidositio-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
                        <li>
                            <a href="{{ URL::to('admin/folio') }}">
                                <i class="bi bi-circle"></i><span>Folios</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
                        <li>
                            <a href="{{ URL::to('admin/banco') }}">
                                <i class="bi bi-circle"></i><span>Bancos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('admin/preguntas') }}">
                                <i class="bi bi-circle"></i><span>Preguntas</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ URL::to('admin/tipocambio') }}">
                            <i class="bi bi-circle"></i><span>Tipo de cambio</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('admin/pagos') }}">
                            <i class="bi bi-circle"></i><span>Historial de pagos</span>
                        </a>
                    </li>
                    @if (auth()->user()->is_root)
                        <li>
                            <a href="{{ URL::to('admin/tipocontrato') }}">
                                <i class="bi bi-circle"></i><span>Tipos de contrato</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('admin/modelo') }}">
                                <i class="bi bi-circle"></i><span>Modelos de contrato</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
                        <li>
                            <a href="{{ URL::to('admin/intencion') }}">
                                <i class="bi bi-circle"></i><span>Intenciones de inversión</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>            
        @endif        

        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
            <li class="nav-heading">Configuración</li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#control-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-clock-history"></i><span>Control</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="control-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    @if (auth()->user()->is_root)
                        <li>
                            <a href="{{ URL::to('admin/cuentasGoogle') }}">
                                <i class="bi bi-circle"></i><span>Cuentas Google</span>
                            </a>
                        </li>
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
                    @endif
                    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
                        <li>
                            <a href="{{ URL::to('admin/usuario') }}">
                                <i class="bi bi-circle"></i><span>Usuarios del sistema</span>
                            </a>
                        </li>
                    @endif
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