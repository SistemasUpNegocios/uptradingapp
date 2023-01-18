@extends('index')

@section('title', 'Vista general')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
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

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
            
                    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_gold || auth()->user()->is_ps_diamond)
                        {{-- agenda --}}
                        <div class="col-md-12">
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

                        {{-- hora --}}
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                        <div class="col-md-4">
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
                        <div class="col-md-4">
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
                        <div class="col-md-4">
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
                            <div class="col-md-6">
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
            
                            <div class="col-md-6">
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
                    @endif
                </div>
            </div>
        
            {{-- <div class="col-lg-4">
    
                <div class="card associates-info">
                    <div class="card-body pb-0">
                        <h5 class="card-title">Clientes <span>| Todos los clientes</span></h5>
    
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Apellidos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientes as $cliente)                                    
                                    <tr>
                                        <td>{{ $cliente->nombre }}</td>
                                        <td class="fw-bold">{{ $cliente->apellido_p }} {{ $cliente->apellido_m }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
    
            </div> --}}
        </div>
    </section>
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
    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)        
        <script src="{{ asset('js/dashboard.js') }}"></script>        
    @endif

@endsection