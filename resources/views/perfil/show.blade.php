@extends('index')

@section('title', 'Perfil')

@section('css')

@endsection

@section('content')
    <div class="pagetitle">
        <h1>Mi cuenta</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Mi cuenta</li>
            </ol>
        </nav>
    </div>

    <?php $foto = auth()->user()->foto_perfil;  ?>

    <section class="section">
        <div class="row align-items-center">
            <div class="col-lg-4">
                <div class="card pt-4">
                    <div class="card-body text-center">
                        <img src="{{ asset("img/usuarios/$foto") }}" alt="avatar" id="imgPerfil" class="img-fluid imgPerfil">
                        <h5 class="mt-3"><span id="perfilNombreCard">{{ auth()->user()->nombre }}</span> <span id="perfilApellidopCard">{{ auth()->user()->apellido_p }}</span></h5>
                        <p class="text-muted mb-4">{{ auth()->user()->correo }}</p>
                        <div class="d-flex justify-content-center mb-2">
                            @include('perfil.buttons')
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 ">
                <div class="card pt-4" >
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Nombre</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="ml-0 text-muted mb-0" id="perfilNombre">{{ auth()->user()->nombre }}</p>
                            </div>
                        </div>
                        <hr style="margin-left: 0">
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Apellido Paterno</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0" id="perfilApellidop">{{ auth()->user()->apellido_p }}</p>
                            </div>
                        </div>  
                        <hr style="margin-left: 0">                    
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Apellido Materno</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0" id="perfilApellidom">{{ auth()->user()->apellido_m }}</p>
                            </div>
                        </div>
                        <hr style="margin-left: 0">                    
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Privilegio</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0" id="perfilPrivilegio">
                                    @if(auth()->user()->is_root)
                                        SUPERUSUARIO
                                    @elseif(auth()->user()->is_admin || auth()->user()->is_procesos)
                                        ADMINISTRADORA
                                    @elseif(auth()->user()->is_admin || auth()->user()->is_procesos)
                                        CONTADORA
                                    @elseif (auth()->user()->is_ps_diamond)
                                        PS DIAMOND
                                    @elseif(auth()->user()->is_ps_gold)
                                        PS GOLD
                                    @elseif(auth()->user()->is_ps_silver)
                                        PS SILVER
                                    @elseif(auth()->user()->is_cliente)
                                        CLIENTE                                                      
                                    @else
                                        Usuario de <span style="text-transform: uppercase">{{ auth()->user()->privilegio }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>                                                                                                   
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Perfil de: <span id="nombreTitle"></span> <span id="apellidoPatTitle"></span> <span id="apellidoMatTitle"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="PerfilForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="idInput" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="current_foto" id="currentPictureInput">
                        <div class="row">
                            <div class="col-12">
                                <div class="file-upload mb-3">
                                    <label for="pictureInput">Foto de perfil</label>
                                    <div class="image-upload-wrap">
                                        <input id="pictureInput" class="file-upload-input" type='file' name="foto"
                                            onchange="readURL(this);" accept="image/*" />
                                        <div class="drag-text">
                                            <h3>Arrastra una imagen o haz clic aquí</h3>
                                        </div>
                                    </div>
                                    <div class="file-upload-content">
                                        <img class="file-upload-image" src="#" alt="Imagen subida" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUpload()" class="remove-image">Eliminar <span
                                                    class="image-title">Imagen seleccionada</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">                        
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control" placeholder="Ingresa el nombre" id="nombreInput" name="nombre" value="{{ auth()->user()->nombre }}" required>
                                    <label for="floatingInput">Nombre</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control" placeholder="Ingresa el apellido paterno" id="apellidoPatInput" name="apellidop" value="{{ auth()->user()->apellido_p }}" required>
                                    <label for="floatingInput">Apellido paterno</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control" placeholder="Ingresa el apellido materno" id="apellidoMatInput" name="apellidom" value="{{ auth()->user()->apellido_m }}" required>
                                    <label for="floatingInput">Apellido materno</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input style="text-transform: none;" type="email" title="Campo obligatorio / example@uptrading.com" minlength="3" maxlength="70" class="form-control" placeholder="Ingresa el correo" id="correoiInput" name="correo" value="{{ auth()->user()->correo }}" readonly required>
                                    <label for="floatingInput">Email</label>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-start">
                            <div class="col-md-6 col-12">
                                <div class="form-check form-switch mb-3 d-flex justify-content-start">
                                    <input class="form-check-input" type="checkbox" role="switch" name="switch-pass" id="passInputCheck">
                                    <label class="form-check-label ms-1" for="passInputCheck">Cambiar contraseña</label>
                                </div>
                            </div>                        
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12 d-none" id="colPassOld">
                                <div class="form-floating mb-3">
                                    <input style="text-transform: none;" type="password" class="form-control"
                                        placeholder="Ingresa tú antigua contraseña" id="passOldInput"
                                        name="pass-old">
                                    <label for="passOldInput">Ingresa tu contraseña anterior</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 d-none" id="colPassNew">
                                <div class="form-floating mb-3">
                                    <input style="text-transform: none;" type="password" class="form-control"
                                        placeholder="Ingresa tu nueva contraseña" id="passNewInput"
                                        name="pass-new" >
                                    <label for="passNewInput">Ingresa tu nueva contraseña</label>
                                </div>
                            </div>
                        </div>
                        <div id="alertMessage"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnSubmit">Actualizar perfil</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/perfil.js') }}"></script>
@endsection