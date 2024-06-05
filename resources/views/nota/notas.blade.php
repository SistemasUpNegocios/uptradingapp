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