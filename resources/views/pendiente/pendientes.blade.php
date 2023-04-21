<input type="hidden" name="id" value="{{ $pendientes->pendienteid }}">
<div class="alert alert-success d-flex justify-content-between align-items-center" id="nombre" role="alert">
    <div class="me-5">
        Nombre del cliente: {{ $pendientes->memo_nombre }}
    </div>
</div>
<div class="alert alert-success d-flex justify-content-between align-items-center" id="ps" role="alert">
    <div class="me-5">
        PS: {{ $pendientes->psnombre }}
    </div>
</div>

<div class="alert d-flex justify-content-between align-items-center" id="introduccion" role="alert">
    <div class="me-5">
        Introducción
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputIntro"
            name="introduccion" value="{{ $pendientes->introduccion }}">
    </div>
</div>

<div class="alert d-flex justify-content-between align-items-center" id="formulario" role="alert">
    <div class="me-5">
        Formulario
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputForm"
            name="formulario" value="{{ $pendientes->formulario }}">
    </div>
</div>

<div class="alert d-flex justify-content-between align-items-center" id="altaCliente" role="alert">
    <div class="me-5">
        Alta de cliente
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputCliente"
            name="alta_cliente" value="{{ $pendientes->alta_cliente }}">
    </div>
</div>

<div class="alert d-flex justify-content-between align-items-center" id="videoconferencia"
    role="alert">
    <div class="me-5">
        Videoconferencia
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputVideo"
            name="videoconferencia" value="{{ $pendientes->videoconferencia }}">
    </div>
</div>

<div class="alert d-flex justify-content-between align-items-center" id="apertura" role="alert">
    <div class="me-5">
        Estatus de apertrua
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputApertura"
            name="apertura" value="{{ $pendientes->apertura }}">
    </div>
</div>                 
<div class="accordion">
    <div class="accordion-item alert alert-secondary pb-0" id="memo_apertura" role="alert">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed px-0 pb-0"
                style="background-color: transparent !important; color: #41464b !important; box-shadow: none !important;"
                type="button" data-bs-toggle="collapse" data-bs-target="#accordionApert"
                aria-expanded="false" aria-controls="accordionApert">
                Memo de apertura
            </button>
            <hr class="px-0 mx-0">
        </h2>
        <div id="accordionApert" class="accordion-collapse collapse" aria-labelledby="headingOne"
            data-bs-parent="#accordionExample">
            <div class="accordion-body px-0" style="text-align: justify;">
                <p id="p_memo_apertura" class="fst-italic">{{ $pendientes->memo_apertura }}</p>
                <textarea name="memo_apertura" id="memo_aperturaInput" class="d-none form-control mb-3">{{ $pendientes->memo_apertura }}</textarea>
                <button class="btn btn-primary mt-2 mb-2 me-2" id="memo_aperturaButton">Editar</button>
                <span class="text-muted" style="font-size: 14px;">Última modificación {{Carbon\Carbon::parse($pendientes->fecha_apertura)->diffForHumans() }}</span>
            </div>
        </div>
    </div>
</div>

<div class="alert d-flex justify-content-between align-items-center" id="instrucciones_bancarias" role="alert">
    <div class="me-5">
        Instrucciones bancarias
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputInstrucciones"
            name="instrucciones_bancarias" value="{{ $pendientes->instrucciones_bancarias }}">
    </div>
</div>

<div class="alert d-flex justify-content-between align-items-center" id="lpoa"
    role="alert">
    <div class="me-5">
        Generar LPOA
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputLPOA"
            name="generar_lpoa" value="{{ $pendientes->generar_lpoa }}">
    </div>
</div>
<div class="accordion">
    <div class="accordion-item alert alert-secondary pb-0" id="memo_lpoa" role="alert">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed px-0 pb-0"
                style="background-color: transparent !important; color: #41464b !important; box-shadow: none !important;"
                type="button" data-bs-toggle="collapse" data-bs-target="#accordionLPOA"
                aria-expanded="false" aria-controls="accordionLPOA">
                Memo de lpoa
            </button>
            <hr class="px-0 mx-0">
        </h2>
        <div id="accordionLPOA" class="accordion-collapse collapse" aria-labelledby="headingOne"
            data-bs-parent="#accordionExample">
            <div class="accordion-body px-0" style="text-align: justify;">
                <p id="p_memo_lpoa" class="fst-italic">{{ $pendientes->memo_generar_lpoa }}</p>
                <textarea name="memo_generar_lpoa" id="memo_lpoaInput" class="d-none form-control mb-3">{{ $pendientes->memo_generar_lpoa }}</textarea>
                <button class="btn btn-primary mt-2 mb-2 me-2" id="memo_lpoaButton">Editar</button>
                <span class="text-muted" style="font-size: 14px;">Última modificación {{Carbon\Carbon::parse($pendientes->fecha_generar_lpoa)->diffForHumans() }}</span>
            </div>
        </div>
    </div>
</div> 

<div class="alert d-flex justify-content-between align-items-center" id="instrucciones_bancarias_mam"
    role="alert">
    <div class="me-5">
        Instrucciones Bancarias MAM
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputInstruccionesMAM"
            name="instrucciones_bancarias_mam" value="{{ $pendientes->instrucciones_bancarias_mam }}">
    </div>
</div>

<div class="alert d-flex justify-content-between align-items-center" id="transferencia"
    role="alert">
    <div class="me-5">
        Transferencias
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputTrans"
            name="transferencia" value="{{ $pendientes->transferencia }}">
    </div>
</div>
<div class="accordion">
    <div class="accordion-item alert alert-secondary pb-0" id="memo_lpoa" role="alert">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed px-0 pb-0"
                style="background-color: transparent !important; color: #41464b !important; box-shadow: none !important;"
                type="button" data-bs-toggle="collapse" data-bs-target="#accordionTrans"
                aria-expanded="false" aria-controls="accordionTrans">
                Memo de transferencias
            </button>
            <hr class="px-0 mx-0">
        </h2>
        <div id="accordionTrans" class="accordion-collapse collapse" aria-labelledby="headingOne"
            data-bs-parent="#accordionExample">
            <div class="accordion-body px-0" style="text-align: justify;">
                <p id="p_memo_transferencia" class="fst-italic">{{ $pendientes->memo_transferencia }}</p>
                <textarea name="memo_transferencia" id="memo_transferenciaInput" class="d-none form-control mb-3">{{ $pendientes->memo_transferencia }}</textarea>
                <button class="btn btn-primary mt-2 mb-2 me-2" id="memo_transferenciaButton">Editar</button>
                <span class="text-muted" style="font-size: 14px;">Última modificación {{Carbon\Carbon::parse($pendientes->fecha_transferencia)->diffForHumans() }}</span>
            </div>
        </div>
    </div>
</div>
 
<div class="alert d-flex justify-content-between align-items-center" id="conectar_mam_pool"
    role="alert">
    <div class="me-5">
        Conectar MAM/POOL
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputConectar"
            name="conexion_mampool" value="{{ $pendientes->conexion_mampool }}">
    </div>
</div>
<div class="accordion">
    <div class="accordion-item alert alert-secondary pb-0" id="memo_mam_pool" role="alert">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed px-0 pb-0"
                style="background-color: transparent !important; color: #41464b !important; box-shadow: none !important;"
                type="button" data-bs-toggle="collapse" data-bs-target="#accordionMamPool"
                aria-expanded="false" aria-controls="accordionMamPool">
                Memo de conexión MAM/POOL
            </button>
            <hr class="px-0 mx-0">
        </h2>
        <div id="accordionMamPool" class="accordion-collapse collapse" aria-labelledby="headingOne"
            data-bs-parent="#accordionExample">
            <div class="accordion-body px-0" style="text-align: justify;">
                <p id="p_memo_mam_pool" class="fst-italic">{{ $pendientes->memo_conexion_mampool }}</p>
                <textarea name="memo_mam_pool" id="memo_mam_poolInput" class="d-none form-control mb-3">{{ $pendientes->memo_conexion_mampool }}</textarea>
                <button class="btn btn-primary mt-2 mb-2 me-2" id="memo_mam_poolButton">Editar</button>
                <span class="text-muted" style="font-size: 14px;">Última modificación {{Carbon\Carbon::parse($pendientes->fecha_conexion_mampool)->diffForHumans() }}</span>
            </div>
        </div>
    </div>
</div>

<div class="alert d-flex justify-content-between align-items-center" id="convenio" role="alert">
    <div class="me-5">
        Generar convenio
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputConvenio" name="generar_convenio" value="{{ $pendientes->generar_convenio }}">
    </div>
</div>
<div class="accordion">
    <div class="accordion-item alert alert-secondary pb-0" id="memo_generar_convenio" role="alert">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed px-0 pb-0"
                style="background-color: transparent !important; color: #41464b !important; box-shadow: none !important;"
                type="button" data-bs-toggle="collapse" data-bs-target="#accordionConvenio"
                aria-expanded="false" aria-controls="accordionConvenio">
                Memo de convenio generado
            </button>
            <hr class="px-0 mx-0">
        </h2>
        <div id="accordionConvenio" class="accordion-collapse collapse" aria-labelledby="headingOne"
            data-bs-parent="#accordionExample">
            <div class="accordion-body px-0" style="text-align: justify;">
                <p id="p_memo_generar_convenio" class="fst-italic">{{ $pendientes->memo_generar_convenio }}</p>
                <textarea name="memo_generar_convenio" id="memo_generar_convenioInput" class="d-none form-control mb-3">{{ $pendientes->memo_generar_convenio }}</textarea>
                <button class="btn btn-primary mt-2 mb-2 me-2" id="memo_generar_convenioButton">Editar</button>
                <span class="text-muted" style="font-size: 14px;">Última modificación {{Carbon\Carbon::parse($pendientes->fecha_generar_convenio)->diffForHumans() }}</span>
            </div>
        </div>
    </div>
</div> 

<div class="alert d-flex justify-content-between align-items-center" id="1erReporte" role="alert">
    <div class="me-5">
        1er reporte
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputReporte"
            name="primer_reporte" value="{{ $pendientes->primer_reporte }}">
    </div>
</div>