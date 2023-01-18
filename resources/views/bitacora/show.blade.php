@extends('index')

@section('title', 'Gestión de bitácora')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">

    <link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Gestión de bitácora</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Gestión de bitácora</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body mt-3">
                        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)                    
                            <a class="btn principal-button mb-3 new" data-bs-toggle="modal" data-bs-target="#formModal"> <i class="bi-plus-lg me-1"> </i>Añadir una nueva bitácora</a>
                        @endif
                        <table class="table table-striped table-bordered nowrap" style="width: 100%" id="bitacora">
                            <thead>
                                <tr>
                                    <th data-priority="0" scope="col">Cliente</th>
                                    <th data-priority="0" scope="col">Nota</th>
                                    <th data-priority="0" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="bitacoraBody">
                            </tbody>
                        </table>


                        {{-- <p class='fw-bold mt-3'>No se ha registrado ninguna calle destacada. ¡Añade una ahora!</p> --}}

                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Añadir bitácora</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bitacoraForm" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInput">
                        <div class="row">                            
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <select name="clienteid" minlength="3" maxlength="20" pattern="[a-zA-Zá-úÁ-Ú ]+"  class="form-select selectSearch" id="clienteIdInput" >
                                        <option value="" disabled selected>Selecciona..</option>
                                        @foreach($lista_clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }} {{ $cliente->apellido_p }} {{ $cliente->apellido_m }}</option>
                                        @endforeach
                                    </select>
                                    <label for="clienteIdInput">Cliente</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" placeholder="Ingresa la nota de la bitacora"
                                        id="notaInput" name="nota" title="Ingresa la nota de la bitacora" minlength="3" maxlength="200" style="height: 200px" ></textarea>
                                    <label for="floatingInput">Nota</label>
                                </div>
                            </div>
                        </div>
                        <div id="alertMessage"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnSubmit">Añadir bitacora</button>
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
    <script src="{{ asset('js/bitacora.js') }}"></script>
@endsection