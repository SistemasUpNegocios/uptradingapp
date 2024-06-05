@extends('index')

@section('title', 'Gestor de notas')

@section('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
    <section class="section">
        <div class="row" id="row_nota_completa">
            <div class="col-12 p-0">
                <button type="button" class="btn btn-sm btn-outline-dark w-100" data-bs-toggle="modal" data-bs-target="#cardModalArchivadas">
                    Tareas archivadas
                </button>
            </div>
            <div class="col-md-4 p-0 columna_nota" data-id="1">
                <h1 class="titulo_nota nota_abierta">
                    <i class="bi bi-brightness-high"></i> Abiertas 
                    <span class="nota_cantidad">{{$notas_abiertas_count}}</span>
                </h1>
                <div class="col_card" id="col_abiertas" data-columna="Abierta">
                    <div class="text-center nota_nueva_abierta">
                        <i class="bi bi-plus-circle-fill"></i>
                    </div>
                    <div class="card d-none" id="card_nota_nueva_abierta">
                        <h5 id="titulo_abiertas_nuevo" contenteditable="true"></h5>
                    </div>
                    @if ($notas_abiertas_count > 0)
                        @foreach ($notas_abiertas as $nota_abierta)
                            @php
                                if ($nota_abierta->fecha_limite != null){
                                    $class_fecha = "";

                                    $fecha_actual = Carbon\Carbon::now();
                                    $fecha_limite = Carbon\Carbon::parse($nota_abierta->fecha_limite);
                                    if ($fecha_limite->gt($fecha_actual)) {
                                        $class_none = "d-none";
                                        $class_fecha_color = "";
                                    } else {
                                        $class_none = "";
                                        $class_fecha_color = "fecha_limite_texto";
                                    }
                                } else {
                                    $class_none = "d-none";
                                    $class_fecha = "d-none";
                                    $class_fecha_color = "";
                                }

                                if($nota_abierta->asignado_a != 0){
                                    $user_asignado_abierta = \App\Models\User::where('id', $nota_abierta->asignado_a)->first();
                                }
                            @endphp
                            <div class="card card_nota" data-id="{{$nota_abierta->id}}" data-titulo="{{$nota_abierta->titulo}}" data-descripcion="{{$nota_abierta->descripcion}}" data-estatus="{{$nota_abierta->estatus}}" data-fecha_creacion="{{$nota_abierta->fecha_creacion}}" data-fecha_actualizacion="{{$nota_abierta->fecha_actualizacion}}" data-fecha_limite="{{$nota_abierta->fecha_limite}}" data-historial="{{$nota_abierta->historial}}" data-contribucion="{{$nota_abierta->contribucion}}" data-asignado_a="{{$nota_abierta->asignado_a}}" data-nombre="{{$nota_abierta->nombre}}" data-foto_perfil="{{$nota_abierta->foto_perfil}}">
                                <h4 class="texto_atrasada {{$class_none}}"><i class="bi bi-calendar-event"></i> Atrasada</h4>
                                <div class="card_asignado">
                                    <h5 style="flex: 1;">{{$nota_abierta->titulo}}</h5>
                                    @if($nota_abierta->asignado_a != null)
                                        <div class="filter">
                                            <img data-bs-toggle="dropdown" class="drop_img_asignar" src="../img/usuarios/{{$user_asignado_abierta->foto_perfil}}" alt="{{$user_asignado_abierta->nombre}}" title="{{$user_asignado_abierta->nombre}}">
            
                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <li class="dropdown-item modal_asignado_a_1">
                                                    <img src="../img/signo.png" alt="Foto asignada" class="imagen_sin_asignar">
                                                    <span class="nombre_sin_asignar">Sin usuarios...</span> 
                                                    <i class="bi bi-check icono_sin_asignar"></i>
                                                </li>
                                                <hr class="hr_modal_asignado">
                                                <div class="contenedor_usuarios_asignados"></div>
                                            </ul>
                                        </div>
                                    @else
                                        <div class="filter">
                                            <img data-bs-toggle="dropdown" class="drop_img_asignar img_signo_sin d-none" src="../img/signo.png" alt="Sin asignar" title="Sin asignar">

                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <li class="dropdown-item modal_asignado_a_1">
                                                    <img src="../img/signo.png" alt="Foto asignada" class="imagen_sin_asignar">
                                                    <span class="nombre_sin_asignar">Sin usuarios...</span> 
                                                    <i class="bi bi-check icono_sin_asignar"></i>
                                                </li>
                                                <hr class="hr_modal_asignado">
                                                <div class="contenedor_usuarios_asignados"></div>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="fecha_limite {{$class_fecha}} {{$class_fecha_color}}">
                                    <div class="fecha_limite_icono">
                                        <svg width="100%" height="100%" viewBox="0 0 20 20"><g fill="none" fill-rule="evenodd"><circle cx="10" cy="10" r="10" fill="currentColor" opacity=".205"></circle><rect width="11" height="10" x="4.5" y="5.5" stroke="currentColor" rx="2"></rect><path fill="currentColor" d="M13.499 5A2.498 2.498 0 0 1 16 7.51V8H4v-.49A2.511 2.511 0 0 1 6.501 5h6.998z"></path><circle cx="7" cy="10" r="1" fill="currentColor"></circle><circle cx="10" cy="10" r="1" fill="currentColor"></circle><circle cx="13" cy="10" r="1" fill="currentColor"></circle><circle cx="7" cy="13" r="1" fill="currentColor"></circle><circle cx="10" cy="13" r="1" fill="currentColor"></circle><circle cx="13" cy="13" r="1" fill="currentColor"></circle><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M6.5 4.5v2M13.5 4.5v2"></path></g></svg>
                                    </div>
                                    <div class="{{$class_fecha_color}}">
                                        {{ Carbon\Carbon::parse($nota_abierta->fecha_limite)->isoFormat('D [de] MMM [de] YYYY') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="card_nota">
                            <div class="sin_tareas">
                                <i class="bi bi-check-circle"></i>
                                <p>No hay tareas...</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-4 p-0 columna_nota" data-id="2">
                <h1 class="titulo_nota nota_progreso">
                    <i class="bi bi-hourglass-split"></i> En progreso 
                    <span class="nota_cantidad">{{$notas_progreso_count}}</span>
                </h1>
                
                <div class="col_card" id="col_progreso" data-columna="En progreso">
                    <div class="text-center nota_nueva_progreso">
                        <i class="bi bi-plus-circle-fill"></i>
                    </div>
                    <div class="card d-none" id="card_nota_nueva_progreso">
                        <h5 id="titulo_progreso_nuevo" contenteditable="true"></h5>
                    </div>
                    @if ($notas_progreso_count > 0)
                        @foreach ($notas_progreso as $nota_progreso)
                            @php
                                if ($nota_progreso->fecha_limite != null){
                                    $class_fecha = "";

                                    $fecha_actual = Carbon\Carbon::now();
                                    $fecha_limite = Carbon\Carbon::parse($nota_progreso->fecha_limite);
                                    if ($fecha_limite->gt($fecha_actual)) {
                                        $class_none = "d-none";
                                        $class_fecha_color = "";
                                    } else {
                                        $class_none = "";
                                        $class_fecha_color = "fecha_limite_texto";
                                    }
                                } else {
                                    $class_none = "d-none";
                                    $class_fecha = "d-none";
                                    $class_fecha_color = "";
                                }

                                if($nota_progreso->asignado_a != 0){
                                    $user_asignado_progreso = \App\Models\User::where('id', $nota_progreso->asignado_a)->first();
                                }
                            @endphp
                            <div class="card card_nota" data-id="{{$nota_progreso->id}}" data-titulo="{{$nota_progreso->titulo}}" data-descripcion="{{$nota_progreso->descripcion}}" data-estatus="{{$nota_progreso->estatus}}" data-fecha_creacion="{{$nota_progreso->fecha_creacion}}" data-fecha_actualizacion="{{$nota_progreso->fecha_actualizacion}}" data-fecha_limite="{{$nota_progreso->fecha_limite}}" data-historial="{{$nota_progreso->historial}}" data-contribucion="{{$nota_progreso->contribucion}}" data-asignado_a="{{$nota_progreso->asignado_a}}" data-nombre="{{$nota_progreso->nombre}}" data-foto_perfil="{{$nota_progreso->foto_perfil}}">
                                <h4 class="texto_atrasada {{$class_none}}"><i class="bi bi-calendar-event"></i> Atrasada</h4>
                                <div class="card_asignado">
                                    <h5 style="flex: 1;">{{$nota_progreso->titulo}}</h5>
                                    @if($nota_progreso->asignado_a != null)
                                        <div class="filter">
                                            <img data-bs-toggle="dropdown" class="drop_img_asignar" src="../img/usuarios/{{$user_asignado_progreso->foto_perfil}}" alt="{{$user_asignado_progreso->nombre}}" title="{{$user_asignado_progreso->nombre}}">
            
                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <li class="dropdown-item modal_asignado_a_1">
                                                    <img src="../img/signo.png" alt="Foto asignada" class="imagen_sin_asignar">
                                                    <span class="nombre_sin_asignar">Sin usuarios...</span> 
                                                    <i class="bi bi-check icono_sin_asignar"></i>
                                                </li>
                                                <hr class="hr_modal_asignado">
                                                <div class="contenedor_usuarios_asignados"></div>
                                            </ul>
                                        </div>
                                    @else
                                        <div class="filter">
                                            <img data-bs-toggle="dropdown" class="drop_img_asignar img_signo_sin d-none" src="../img/signo.png" alt="Sin asignar" title="Sin asignar">

                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <li class="dropdown-item modal_asignado_a_1">
                                                    <img src="../img/signo.png" alt="Foto asignada" class="imagen_sin_asignar">
                                                    <span class="nombre_sin_asignar">Sin usuarios...</span> 
                                                    <i class="bi bi-check icono_sin_asignar"></i>
                                                </li>
                                                <hr class="hr_modal_asignado">
                                                <div class="contenedor_usuarios_asignados"></div>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="fecha_limite {{$class_fecha}} {{$class_fecha_color}}">
                                    <div class="fecha_limite_icono">
                                        <svg width="100%" height="100%" viewBox="0 0 20 20"><g fill="none" fill-rule="evenodd"><circle cx="10" cy="10" r="10" fill="currentColor" opacity=".205"></circle><rect width="11" height="10" x="4.5" y="5.5" stroke="currentColor" rx="2"></rect><path fill="currentColor" d="M13.499 5A2.498 2.498 0 0 1 16 7.51V8H4v-.49A2.511 2.511 0 0 1 6.501 5h6.998z"></path><circle cx="7" cy="10" r="1" fill="currentColor"></circle><circle cx="10" cy="10" r="1" fill="currentColor"></circle><circle cx="13" cy="10" r="1" fill="currentColor"></circle><circle cx="7" cy="13" r="1" fill="currentColor"></circle><circle cx="10" cy="13" r="1" fill="currentColor"></circle><circle cx="13" cy="13" r="1" fill="currentColor"></circle><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M6.5 4.5v2M13.5 4.5v2"></path></g></svg>
                                    </div>
                                    <div class="{{$class_fecha_color}}">
                                        {{ Carbon\Carbon::parse($nota_progreso->fecha_limite)->isoFormat('D [de] MMM [de] YYYY') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="card_nota">
                            <div class="sin_tareas">
                                <i class="bi bi-check-circle"></i>
                                <p>No hay tareas...</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-4 p-0 columna_nota" data-id="3">
                <h1 class="titulo_nota nota_lista">
                    <i class="bi bi-check-lg"></i> Listo 
                    <span class="nota_cantidad">{{$notas_terminada_count}}</span>
                </h1>
                <div class="col_card" id="col_terminada" data-columna="Terminada">
                    @if ($notas_terminada_count > 0)
                        @foreach ($notas_terminada as $nota_terminada )
                            @php
                                if($nota_terminada->asignado_a != 0){
                                    $user_asignado_terminada = \App\Models\User::where('id', $nota_terminada->asignado_a)->first();
                                }
                            @endphp
                            <div class="card card_nota" data-id="{{$nota_terminada->id}}" data-titulo="{{$nota_terminada->titulo}}" data-descripcion="{{$nota_terminada->descripcion}}" data-estatus="{{$nota_terminada->estatus}}" data-fecha_creacion="{{$nota_terminada->fecha_creacion}}" data-fecha_actualizacion="{{$nota_terminada->fecha_actualizacion}}" data-fecha_limite="{{$nota_terminada->fecha_limite}}" data-historial="{{$nota_terminada->historial}}" data-contribucion="{{$nota_terminada->contribucion}}" data-asignado_a="{{$nota_terminada->asignado_a}}" data-nombre="{{$nota_terminada->nombre}}" data-foto_perfil="{{$nota_terminada->foto_perfil}}">
                                <h4 class="texto_terminada"><i class="bi bi-check-circle-fill"></i> Terminada</h4>
                                <div class="card_asignado">
                                    <h5 style="flex: 1;">{{$nota_terminada->titulo}}</h5>
                                    @if($nota_terminada->asignado_a != null)
                                        <div class="filter">
                                            <img data-bs-toggle="dropdown" class="drop_img_asignar" src="../img/usuarios/{{$user_asignado_terminada->foto_perfil}}" alt="{{$user_asignado_terminada->nombre}}" title="{{$user_asignado_terminada->nombre}}">
            
                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <li class="dropdown-item modal_asignado_a_1">
                                                    <img src="../img/signo.png" alt="Foto asignada" class="imagen_sin_asignar">
                                                    <span class="nombre_sin_asignar">Sin usuarios...</span> 
                                                    <i class="bi bi-check icono_sin_asignar"></i>
                                                </li>
                                                <hr class="hr_modal_asignado">
                                                <div class="contenedor_usuarios_asignados"></div>
                                            </ul>
                                        </div>
                                    @else
                                        <div class="filter">
                                            <img data-bs-toggle="dropdown" class="drop_img_asignar img_signo_sin d-none" src="../img/signo.png" alt="Sin asignar" title="Sin asignar">

                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <li class="dropdown-item modal_asignado_a_1">
                                                    <img src="../img/signo.png" alt="Foto asignada" class="imagen_sin_asignar">
                                                    <span class="nombre_sin_asignar">Sin usuarios...</span> 
                                                    <i class="bi bi-check icono_sin_asignar"></i>
                                                </li>
                                                <hr class="hr_modal_asignado">
                                                <div class="contenedor_usuarios_asignados"></div>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="card_nota">
                            <div class="sin_tareas">
                                <i class="bi bi-check-circle"></i>
                                <p>No hay tareas...</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Modal de notas archivadas -->
            <div class="modal fade" id="cardModalArchivadas" tabindex="-1" aria-labelledby="exampleModalLabelArchivadas" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">Tareas archivadas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if ($notas_archivadas_count > 0)
                                @foreach ($notas_archivadas as $nota_archivada)
                                    <div class="card notas_archivadas" data-bs-toggle="collapse" data-bs-target="#collapseExample{{$nota_archivada->id}}" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="card-body p-3">
                                            <h5><i class="bi bi-box-arrow-in-down"></i> {{$nota_archivada->titulo}}</h5>
                                            <div class="collapse" id="collapseExample{{$nota_archivada->id}}">
                                                @if ($nota_archivada->descripcion == "")
                                                    <h6>Sin descripción...</h6>
                                                @else
                                                    <h6>{{$nota_archivada->descripcion}}</h6>
                                                @endif
                                                <p class="mt-4">{{$nota_archivada->estatus}} / {{$nota_archivada->nombre}}</p>
                                                <button class="ms-3 mt-2 boton_archivado btn btn-outline-success btn-sm" data-id="{{$nota_archivada->id}}" data-titulo="{{$nota_archivada->titulo}}" data-descripcion="{{$nota_archivada->descripcion}}" data-estatus="{{$nota_archivada->estatus}}" data-fecha_creacion="{{$nota_archivada->fecha_creacion}}" data-fecha_actualizacion="{{$nota_archivada->fecha_actualizacion}}" data-fecha_limite="{{$nota_archivada->fecha_limite}}" data-historial="{{$nota_archivada->historial}}" data-contribucion="{{$nota_archivada->contribucion}}" data-asignado_a="{{$nota_archivada->asignado_a}}" data-nombre="{{$nota_archivada->nombre}}" data-foto_perfil="{{$nota_archivada->foto_perfil}}">
                                                    Abrir tarea
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="card notas_archivadas2">
                                    <div class="card-body p-0 mt-4 mb-4 text-center">
                                        <h5>No hay tareas archivadas...</h5>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal de notas -->
    <div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center modal_cont_terminada d-none">
                        <button class="btn btn-outline-primary modal_archivar me-4">Archivar</button>

                        <i class="bi bi-check-circle-fill me-3"></i> 
                        <p class="m-0">
                           <span class="modal_span_terminada">Terminada</span> por <span id="modal_terminada_por"></span>
                            <br>
                            <span id="modal_terminada"></span>
                        </p>
                    </div>
                    <div class="d-flex align-items-center modal_cont_asignado d-none">
                        <button class="btn btn-primary modal_finalizar">Finalizar</button>

                        <div class="m-0 ms-4 div_asignado_a d-flex align-items-center">
                            <img src="../img/signo.png" alt="Foto asignado" class="img_asignado">
                            <div class="ms-2">
                                <span class="texto_asignado"></span>
                                <div class="filter">
                                    <a href="#" class="modal_asignado_a" data-bs-toggle="dropdown">
                                        <span>Sin asignar</span> 
                                        <i class="bi bi-caret-down-fill"></i>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-item modal_asignado_a_1">
                                            <img src="" alt="Foto asignada">
                                            <span></span> 
                                            <i class="bi bi-check"></i>
                                        </li>
                                        <hr class="hr_modal_asignado">
                                        <div class="contenedor_usuarios_asignados"></div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center modal_cont_archivada">
                        <i class="bi bi-archive-fill me-3"></i> 
                        <p class="m-0">
                            <span class="modal_span_archivada">Archivado</span> por 
                            <span id="modal_archivado_por"></span>
                            <br>
                            <span id="modal_archivada"></span>
                        </p>
                    </div>

                    <div class="d-flex align-items-center filtros_modal">
                        <div class="filter modal_cont_terminada_filtros">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-item modal_restaurar"><i class="bi bi-recycle"></i>Restaurar</li>
                                <li class="dropdown-item modal_archivar"><i class="bi bi-archive"></i> Archivar</li>
                                <hr style="margin: 0.5em 0 !important; height: 0.2px !important">
                                <li class="dropdown-item modal_eliminar"><i class="bi bi-trash-fill"></i> Eliminar</li>
                            </ul>
                        </div>
                        <div class="filter modal_cont_asignado_filtros">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-item modal_finalizar"><i class="bi bi-check-circle"></i> Finalizar</li>
                                <li class="dropdown-item modal_archivar"><i class="bi bi-archive"></i> Archivar</li>
                                <hr style="margin: 0.5em 0 !important; height: 0.2px !important">
                                <li class="dropdown-item modal_eliminar"><i class="bi bi-trash-fill"></i> Eliminar</li>
                            </ul>
                        </div>
                        <div class="filter modal_cont_archivada_filtros">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-item modal_restaurar"><i class="bi bi-recycle"></i>Restaurar</li>
                                <hr style="margin: 0.5em 0 !important; height: 0.2px !important">
                                <li class="dropdown-item modal_eliminar"><i class="bi bi-trash-fill"></i> Eliminar</li>
                            </ul>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="row modal_row_completo">
                    <div class="col-6 col_terminada_tiempo">
                        <div class="modal_reloj">
                            <svg width="100%" height="100%" version="1.1" viewBox="0 0 64 64"><g fill="none" fill-rule="evenodd" stroke="none" stroke-width="1"><circle cx="32" cy="32" r="32" fill="#FFF"></circle><path stroke="#829199" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M32 32L16.5 10"></path><path stroke="#6C7980" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M32 32l21-9.5"></path><path stroke="#E6175C" stroke-linecap="round" stroke-linejoin="round" d="M35 28.5l-23 25"></path><circle cx="32" cy="32" r="2" fill="#000"></circle></g></svg>
                        </div>
                        <div class="modal_parrafo ms-3">
                            <p>Tiempo en terminar</p>
                            <h6 id="tiempo_en_terminar">7 días</h6>
                        </div>
                    </div>
                    <div class="col-6 col_terminada_contribuir">
                        <div class="modal_img_contribucion">
                            <svg width="100%" height="100%" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414" clip-rule="evenodd" version="1.1" viewBox="0 0 100 100" xml:space="preserve"><path fill="#fff" d="M50 100c27.614 0 50-22.386 50-50S77.614 0 50 0 0 22.386 0 50s22.386 50 50 50z"></path><clipPath id="a162417839"><path d="M50 100c27.614 0 50-22.386 50-50S77.614 0 50 0 0 22.386 0 50s22.386 50 50 50z"></path></clipPath><g clip-path="url(#a162417839)"><path fill="#a195eb" d="M46.875 29.419l-5.603 5.603-.118.113a3.117 3.117 0 0 1-3.211.595 3.124 3.124 0 0 1-1.09-5.127L47.79 19.665c.16-.151.323-.291.508-.411.32-.208.679-.356 1.052-.436.162-.034.322-.051.486-.064.164-.004.163-.004.328 0 .218.018.432.046.645.102a3.126 3.126 0 0 1 1.401.809l10.937 10.938c.113.119.222.239.319.373a3.132 3.132 0 0 1-.206 3.928 3.142 3.142 0 0 1-3.131.927 3.144 3.144 0 0 1-1.028-.49 3.67 3.67 0 0 1-.373-.319l-5.603-5.603v74.487c-.005.106-.005.211-.016.316a3.142 3.142 0 0 1-.956 1.949 3.147 3.147 0 0 1-2.626.824 3.143 3.143 0 0 1-1.68-.824 3.142 3.142 0 0 1-.908-1.636c-.057-.276-.05-.348-.064-.629V29.419z"></path><path fill="#7f8c92" d="M25 63.794l-5.603 5.603-.118.113a3.117 3.117 0 0 1-2.255.798 3.148 3.148 0 0 1-2.159-1.029 3.139 3.139 0 0 1-.798-1.928 3.132 3.132 0 0 1 .592-2 3.67 3.67 0 0 1 .319-.373L25.915 54.04a3.126 3.126 0 0 1 1.401-.809c.213-.056.427-.084.645-.102.165-.004.164-.004.328 0 .164.013.324.03.486.064.373.08.732.228 1.052.436.185.12.348.26.508.411l10.937 10.938c.113.119.222.239.319.373a3.144 3.144 0 0 1 .592 2 3.146 3.146 0 0 1-1.154 2.265 3.118 3.118 0 0 1-1.803.692 3.132 3.132 0 0 1-2-.592 3.67 3.67 0 0 1-.373-.319l-5.603-5.603v58.862c-.011.249-.006.313-.05.558a3.144 3.144 0 0 1-.915 1.701 3.147 3.147 0 0 1-2.579.838 3.134 3.134 0 0 1-2.397-1.741 3.125 3.125 0 0 1-.296-1.076c-.009-.093-.009-.186-.013-.28V63.794z"></path><path fill="#00cdeb" d="M71.875 52.857l-5.603 5.603-.118.112a3.142 3.142 0 0 1-1.283.697 3.119 3.119 0 0 1-2.227-.235 3.145 3.145 0 0 1-1.554-1.818 3.135 3.135 0 0 1 .444-2.803 3.9 3.9 0 0 1 .319-.373L72.79 43.103a3.126 3.126 0 0 1 2.046-.911c.164-.005.163-.005.328 0a3.126 3.126 0 0 1 2.046.911L88.147 54.04c.113.12.222.24.319.373a3.144 3.144 0 0 1 .592 2.001 3.135 3.135 0 0 1-.148.802 3.149 3.149 0 0 1-1.701 1.889 3.132 3.132 0 0 1-3.481-.645l-5.603-5.603v58.862c-.004.093-.004.187-.013.28a3.125 3.125 0 0 1-1.631 2.472 3.147 3.147 0 0 1-2.709.121 3.137 3.137 0 0 1-1.847-2.315c-.044-.246-.039-.31-.05-.558V52.857z"></path></g></svg>
                        </div>
                        <div class="modal_parrafo ms-3">
                            <p id="cantidad_contribucion"></p>
                            <div id="imagenes_contribucion">
                                <img src="" alt="Foto contribuyó">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 modal_col_1">
                        <h5 id="modal_titulo" contenteditable="true"></h5>
                        <p id="modal_descripcion" contenteditable="true"></p>
                        <div id="modal_historial">
                            <div class="div_historial"></div>
                        </div>
                    </div>
                    <div class="col-md-4 modal_col_2">
                        <div class="fecha-limite mt-0 cols_modales">
                            <label for="fechaLimite">
                                <i class="bi bi-calendar-event fecha-icon"></i> 
                                <span>Fecha Límite</span> 
                                <i class="bi bi-caret-down-fill fecha-limite-flecha"></i>
                            </label>
                            <input type="text" id="fechaLimite" class="fecha-input" autocomplete="off">
                        </div>
                        <hr style="margin: 0.5em 0 !important; height: 0.2px !important">
                        <div class="cols_modales">
                            <i class="bi bi-person-circle"></i> <b id="modal_user"></b>
                            <br>
                            <span id="modal_estatus"></span>
                        </div>
                        <div class="cols_modales">
                            <i class="bi bi-plus-circle"></i> <b>Creada</b>
                            <br>
                            <span id="modal_fecha_creacion"></span>
                        </div>
                        <div class="mb-3 cols_modales">
                            <i class="bi bi-pencil"></i> <b>Actualizada</b>
                            <br>
                            <span id="modal_fecha_actualizacion"></span>
                        </div>
                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/es.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <script src="{{ asset('js/notas.js') }}"></script>
@endsection