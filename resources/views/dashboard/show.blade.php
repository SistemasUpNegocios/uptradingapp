@extends('index')

@section('title', 'Vista general')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">

<style>
    #grafica3{
        height: 245px !important;
        margin: 0 auto !important;
    }
    #grafica4{
        height: 245px !important;
    }
</style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Vista general</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Vista general</a></li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard filtros">
        <div class="row">
            <div class="col-lg-12">
                <div class="row justify-content-center">
                    <input type="radio" id="todo" class="filtroInput" value="todo">
                    <input type="radio" id="datos" class="filtroInput" value="datos" checked>
                    <input type="radio" id="graficas" class="filtroInput" value="graficas">
                
                    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)
                        <div id="contenedor_filtros" class="contenedor_filtros">    
                            <div class="card info-card machines-card">
                                <div class="card-body pb-0">
                                    <h5 class="card-title mb-0 text-center">Filtros</h5>
                                    <ol class="filters">
                                        <li>
                                            <label id="todo_for" for="todo">Todo</label>
                                        </li>
                                        <li>
                                            <label id="datos_for" for="datos">Datos</label>
                                        </li>
                                        <li>
                                            <label id="graficas_for" for="graficas">Gráficas</label>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_gold || auth()->user()->is_ps_diamond)
                        {{-- agenda --}}
                        <div class="datos col-md-12">
                            <div class="card info-card machines-card">
                                <div class="card-body pb-0">
                                    <h5 class="card-title mb-0"><a class="card-title mb-0" href="{{ url('/admin/agenda') }}">Agenda</a> <span>| citas para hoy</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="ps-0">
                                            <ul>
                                                @if (sizeof($agenda) > 0)                                                
                                                    @foreach ($agenda as $cita)
                                                        @php
                                                            $horario = \Carbon\Carbon::parse($cita->start)->format('h:i a');
                                                            $hora = explode(':', $horario);
                                                            $nombre = ucwords(strtolower($cita->nombre));
                                                            $apellidop = ucwords(strtolower($cita->apellido_p));
                                                            $apellidom = ucwords(strtolower($cita->apellido_m));
                                                        @endphp
                                                        <li style="text-align: justify">
                                                            @if ($hora[0] == "01")
                                                                {{ $cita->title }} a la {{ $horario }}
                                                            @else
                                                                {{ $cita->title }} a las {{ $horario }}
                                                            @endif
                                                            @if (auth()->user()->is_admin || auth()->user()->is_procesos)                                                                
                                                                para {{ $nombre }} {{ $apellidop }} {{ $apellidom }}.
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <li>No hay citas para ti hoy.</li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(auth()->user()->is_ps_bronze)
                        {{-- hora --}}
                        <div class="datos col-md-6 col-12">
                            <div class="card info-card hour-card">
                                <div class="card-body">
                                    <h5 class="card-title" id="day"></h5>
        
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-clock"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 id="hour"></h6>
                                            <span class="text-muted small pt-1" id="date"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="datos col-md-6 col-12">
                            <div class="card info-card locations-card">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Opciones</h6>
                                        </li>
        
                                        <li><a class="dropdown-item" href="{{ url('/admin/cliente') }}">Gestionar clientes</a></li>
                                    </ul>
                                </div>
        
                                <div class="card-body">
                                    <h5 class="card-title">Clientes <span>| Total</span></h5>
        
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person-video2"></i>
                                        </div>
                                        <div class="ps-3">
                                            <p>{{ $clientesCountBronze }}</p>
                                            <a href="{{ url('/admin/cliente') }}"><span class="text-yellow small pt-1 fw-bold">Gestionar</span></a>
                                        </div>
                                    </div>
        
                                </div>
                            </div>
        
                        </div>
                    @else
                        {{-- hora --}}
                        <div class="datos col-md-6">
                            <div class="card info-card hour-card">
                                <div class="card-body">
                                    <h5 class="card-title" id="day"></h5>
        
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-clock"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 id="hour"></h6>
                                            <span class="text-muted small pt-1" id="date"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- contratos --}}
                        <div class="datos col-md-6">
                            <div class="card info-card machines-card">
        
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Opciones</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ url('/admin/contrato') }}">Gestionar contratos</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Contratos <span>| Total</span></h5>
        
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </div>
                                        <div class="ps-3">
                                            <p class="num-card">{{ $contratos }}</p>
                                            <a href="{{ url('/admin/contrato') }}"><span class="text-success small pt-1 fw-bold">Gestionar</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                    

                        {{-- compuestos --}}
                        <div class="datos col-md-4">
                            <div class="card info-card machines-card">
                                <div class="card-body pb-0">
                                    <h5 class="card-title mb-0">Contratos <span>| Compuestos</span></h5>
        
                                    <div class="d-flex align-items-center">
                                        <div class="ps-0">
                                            <p class="num-card">{{ $contratos_compuestos }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- mensuales --}}
                        <div class="datos col-md-4">
                            <div class="card info-card machines-card">
                                <div class="card-body pb-0">
                                    <h5 class="card-title mb-0">Contratos <span>| Mensuales</span></h5>
        
                                    <div class="d-flex align-items-center">
                                        <div class="ps-0">
                                            <p class="num-card">{{ $contratos_mensuales }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- convenios --}}
                        <div class="datos col-md-4">
                            <div class="card info-card machines-card">
                                <div class="card-body pb-0">
                                    <h5 class="card-title mb-0">Convenios MAM <span>| Total</span></h5>
        
                                    <div class="d-flex align-items-center">
                                        <div class="ps-0">
                                            <p class="num-card">{{ $convenios }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- gestion de PS y Clientes --}}
                        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
                            <div class="datos col-md-6">
                                <div class="card info-card associates-card">
            
                                    <div class="filter">
                                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                            <li class="dropdown-header text-start">
                                                <h6>Opciones</h6>
                                            </li>
            
                                            <li><a class="dropdown-item" href="{{ url('/admin/ps') }}">Gestionar PS</a></li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">PS <span>| Total</span></h5>
            
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="ps-3">                                        
                                                <p>{{ $ps }}</p>
                                                <a href="{{ url('/admin/ps') }}"><span class="text-danger small pt-1 fw-bold">Gestionar</span></a>
                                            </div>
                                        </div>
            
                                    </div>
            
                                </div>
                            </div>
            
                            <div class="datos col-md-6">
                                <div class="card info-card locations-card">
                                    <div class="filter">
                                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                            <li class="dropdown-header text-start">
                                                <h6>Opciones</h6>
                                            </li>
            
                                            <li><a class="dropdown-item" href="{{ url('/admin/cliente') }}">Gestionar clientes</a></li>
                                        </ul>
                                    </div>
            
                                    <div class="card-body">
                                        <h5 class="card-title">Clientes <span>| Total</span></h5>
            
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person-video2"></i>
                                            </div>
                                            <div class="ps-3">
                                                <p>{{ $clientesCount }}</p>
                                                <a href="{{ url('/admin/cliente') }}"><span class="text-yellow small pt-1 fw-bold">Gestionar</span></a>
                                            </div>
                                        </div>
            
                                    </div>
                                </div>
            
                            </div>
                        @endif

                        {{-- gestion de graficas --}}
                        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)
                            {{-- Gráfica de linea de contratos y convenios --}}
                            <div class="graficas col-md-12">
                                <div class="card info-card machines-card">
                                    <div class="card-body pb-0">
                                        <canvas class="pt-3" id="grafica1"></canvas>
                                    </div>
                                </div>
                            </div>

                            {{-- Gráfica de linea de contratos mensuales y compuestos --}}
                            <div class="graficas col-md-12">
                                <div class="card info-card machines-card">
                                    <div class="card-body pb-0">
                                        <canvas class="pt-3" id="grafica2"></canvas>
                                    </div>
                                </div>
                            </div>

                            {{-- Gráfica pie de clientes y clientes en formulario --}}
                            <div class="graficas col-md-6">
                                <div class="card info-card machines-card">
                                    <div class="card-body pb-0">
                                        <canvas class="pt-3" id="grafica3"></canvas>
                                    </div>
                                </div>
                            </div>

                            {{-- Gráfica de barras de PS y PS Movil --}}
                            <div class="graficas col-md-6">
                                <div class="card info-card machines-card">
                                    <div class="card-body pb-0">
                                        <canvas class="pt-3" id="grafica4"></canvas>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)
        <a href="#" id="filtros" class="d-flex align-items-center justify-content-center filtros_dash">
            <i class="bi bi-funnel-fill text-white"></i>
        </a>
    @endif
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/cumple.js') }}"></script>
    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)
        <script src="{{ asset('js/graficas.js') }}"></script>
        <script src="{{ asset('js/dashboard.js') }}"></script>        
    @endif

@endsection