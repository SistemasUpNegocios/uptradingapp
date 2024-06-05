@extends('index')

@section('title', 'Notificaciones')

@section('css')

@endsection

@section('content')
    <div class="pagetitle">
        <h1>Notificaciones de {{ auth()->user()->nombre }} {{ auth()->user()->apellido_p }} {{ auth()->user()->apellido_m }}</h1>        
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Notificaciones</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="card pt-4" >
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-1 text-center"><p class="text-muted fw-bold"></div>
                            <div class="col-md-6 text-center"><p class="text-muted fw-bold">NOTIFICACIÓN</div>
                            <div class="col-md-3 text-center"><p class="text-muted fw-bold">HORA</p></div>
                            <div class="col-md-2"><p class="text-muted fw-bold"></p></div>
                        </div>
                        <hr class="m-0">
                        @php $foto = auth()->user()->foto_perfil; @endphp
                        <input type="hidden" id="foto" value="{{$foto}}">
                        <div class="row align-items-center mt-3" id="contenedorNotificacion">
                            @if (sizeof($notificacionesList) <= 0)
                                <div class="col-12" style="text-align: center;"><span class="text-muted">No tienes ninguna notificación</span></div>
                            @else                                
                                @foreach ($notificacionesList as $notificacion)
                                    <div class="col-md-1 text-center">
                                        <img src="{{ asset("img/usuarios/$foto") }}" id="imgPerfilNav" alt="Foto de perfil" class="rounded-circle text-center" width="66px">
                                    </div>
                                    <div class="col-md-6" style="{{strlen($notificacion->mensaje) > 50 ? 'text-align: justify; padding-left: 2rem;' : 'text-align: center;' }} "><span class="text-muted">{{$notificacion->titulo}}: @php echo $notificacion->mensaje @endphp</span></div>
                                    <div class="col-md-3 text-center"><span class="text-muted">{{ str_replace('hace', 'Hace', \Carbon\Carbon::parse($notificacion->created_at)->diffForHumans()) }}</span></div>
                                    <div class="col-md-2 text-center">
                                        <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="text-muted">
                                                <i class="bi bi-three-dots"></i>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item eliminarNotif" href="#" data-id="{{ $notificacion->id }}">Eliminar</a></li>
                                        </ul>
                                    </div>
                                    <hr style="margin: 1.2rem auto; width: 97%">
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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
@endsection