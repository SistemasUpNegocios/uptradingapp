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
<div class="accordion">
    <div class="accordion-item alert alert-secondary pb-0" id="memo_introduccion" role="alert">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed px-0 pb-0"
                style="background-color: transparent !important; color: #41464b !important; box-shadow: none !important;"
                type="button" data-bs-toggle="collapse" data-bs-target="#accordionIntro"
                aria-expanded="false" aria-controls="accordionIntro">
                Memo de introduccion
            </button>
            <hr class="px-0 mx-0">
        </h2>
        <div id="accordionIntro" class="accordion-collapse collapse" aria-labelledby="headingOne"
            data-bs-parent="#accordionExample">
            <div class="accordion-body px-0" style="text-align: justify;">
                <p id="p_memo_introduccion" class="fst-italic">{{ $pendientes->memo_introduccion }}</p>
                <textarea name="memo_introduccion" id="memo_introduccionInput" class="d-none form-control mb-3">{{ $pendientes->memo_introduccion }}</textarea>
                <button class="btn btn-primary mt-2 mb-2 me-2" id="memo_introduccionButton">Editar</button>
                <span class="text-muted" style="font-size: 14px;">Última modificación {{Carbon\Carbon::parse($pendientes->fecha_introduccion)->diffForHumans() }}</span>
            </div>
        </div>
    </div>
</div>    
<div class="alert d-flex justify-content-between align-items-center" id="intencion_inversion"
    role="alert">
    <div class="me-5">
        Intención de inversión
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputInversion"
            name="intencion_inversion" value="{{ $pendientes->intencion_inversion }}">
    </div>
</div>
<div class="accordion">
    <div class="accordion-item alert alert-secondary pb-0" id="memo_intencion" role="alert">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed px-0 pb-0"
                style="background-color: transparent !important; color: #41464b !important; box-shadow: none !important;"
                type="button" data-bs-toggle="collapse" data-bs-target="#accordionIntencion"
                aria-expanded="false" aria-controls="accordionIntencion">
                Memo de intención de inversión
            </button>
            <hr class="px-0 mx-0">
        </h2>
        <div id="accordionIntencion" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body px-0" style="text-align: justify;">
                <p id="p_memo_intencion" class="fst-italic">{{ $pendientes->memo_intencion_inversion }}</p>
                <textarea name="memo_intencion" id="memo_intencionInput" class="d-none form-control mb-3">{{ $pendientes->memo_intencion_inversion }}</textarea>
                <button class="btn btn-primary mt-2 mb-2 me-2" id="memo_intencionButton">Editar</button>
                <span class="text-muted" style="font-size: 14px;">Última modificación {{Carbon\Carbon::parse($pendientes->fecha_intencion_inversion)->diffForHumans() }}</span>
            </div>
        </div>
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
<div class="accordion">
    <div class="accordion-item alert alert-secondary pb-0" id="memo_formulario" role="alert">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed px-0 pb-0"
                style="background-color: transparent !important; color: #41464b !important; box-shadow: none !important;"
                type="button" data-bs-toggle="collapse" data-bs-target="#accordionForm"
                aria-expanded="false" aria-controls="accordionForm">
                Memo de formulario
            </button>
            <hr class="px-0 mx-0">
        </h2>
        <div id="accordionForm" class="accordion-collapse collapse" aria-labelledby="headingOne"
            data-bs-parent="#accordionExample">
            <div class="accordion-body px-0" style="text-align: justify;">
                <p id="p_memo_formulario" class="fst-italic">{{ $pendientes->memo_formulario }}</p>
                <textarea name="memo_formulario" id="memo_formularioInput" class="d-none form-control mb-3">{{ $pendientes->memo_formulario }}</textarea>
                <button class="btn btn-primary mt-2 mb-2 me-2" id="memo_formularioButton">Editar</button>
                <span class="text-muted" style="font-size: 14px;">Última modificación {{Carbon\Carbon::parse($pendientes->fecha_formulario)->diffForHumans() }}</span>
            </div>
        </div>
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
<div class="accordion">
    <div class="accordion-item alert alert-secondary pb-0" id="memo_videoconferencia" role="alert">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed px-0 pb-0"
                style="background-color: transparent !important; color: #41464b !important; box-shadow: none !important;"
                type="button" data-bs-toggle="collapse" data-bs-target="#accordionVideo"
                aria-expanded="false" aria-controls="accordionVideo">
                Memo de videoconferencia
            </button>
            <hr class="px-0 mx-0">
        </h2>
        <div id="accordionVideo" class="accordion-collapse collapse" aria-labelledby="headingOne"
            data-bs-parent="#accordionExample">
            <div class="accordion-body px-0" style="text-align: justify;">
                <p id="p_memo_videoconferencia" class="fst-italic">{{ $pendientes->memo_videoconferencia }}</p>
                <textarea name="memo_videoconferencia" id="memo_videoconferenciaInput" class="d-none form-control mb-3">{{ $pendientes->memo_videoconferencia }}</textarea>
                <button class="btn btn-primary mt-2 mb-2 me-2" id="memo_videoconferenciaButton">Editar</button>
                <span class="text-muted" style="font-size: 14px;">Última modificación {{Carbon\Carbon::parse($pendientes->fecha_videoconferencia)->diffForHumans() }}</span>
            </div>
        </div>
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
<div class="alert d-flex justify-content-between align-items-center"
    id="instrucciones_bancarias" role="alert">
    <div class="me-5">
        Instrucciones bancarias
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputInstrucciones"
            name="instrucciones_bancarias" value="{{ $pendientes->instrucciones_bancarias }}">
    </div>
</div>
<div class="accordion">
    <div class="accordion-item alert alert-secondary pb-0" id="memo_instrucciones" role="alert">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed px-0 pb-0"
                style="background-color: transparent !important; color: #41464b !important; box-shadow: none !important;"
                type="button" data-bs-toggle="collapse" data-bs-target="#accordionInstrucciones"
                aria-expanded="false" aria-controls="accordionInstrucciones">
                Memo de instrucciones bancarias
            </button>
            <hr class="px-0 mx-0">
        </h2>
        <div id="accordionInstrucciones" class="accordion-collapse collapse" aria-labelledby="headingOne"
            data-bs-parent="#accordionExample">
            <div class="accordion-body px-0" style="text-align: justify;">
                <p id="p_memo_instrucciones" class="fst-italic">{{ $pendientes->memo_instrucciones_bancarias }}</p>
                <textarea name="memo_instrucciones" id="memo_instruccionesInput" class="d-none form-control mb-3">{{ $pendientes->memo_instrucciones_bancarias }}</textarea>
                <button class="btn btn-primary mt-2 mb-2 me-2" id="memo_instruccionesButton">Editar</button>
                <span class="text-muted" style="font-size: 14px;">Última modificación {{Carbon\Carbon::parse($pendientes->fecha_instrucciones_bancarias)->diffForHumans() }}</span>
            </div>
        </div>
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
    <div class="accordion-item alert alert-secondary pb-0" id="memo_transferencia" role="alert">
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
<div class="alert d-flex justify-content-between align-items-center" id="contrato" role="alert">
    <div class="me-5">
        Contrato activado
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputContrato"
            name="contrato" value="{{ $pendientes->contrato }}">
    </div>
</div>
<div class="accordion">
    <div class="accordion-item alert alert-secondary pb-0" id="memo_contrato" role="alert">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed px-0 pb-0"
                style="background-color: transparent !important; color: #41464b !important; box-shadow: none !important;"
                type="button" data-bs-toggle="collapse" data-bs-target="#accordionContrato"
                aria-expanded="false" aria-controls="accordionContrato">
                Memo de contrato activado
            </button>
            <hr class="px-0 mx-0">
        </h2>
        <div id="accordionContrato" class="accordion-collapse collapse" aria-labelledby="headingOne"
            data-bs-parent="#accordionExample">
            <div class="accordion-body px-0" style="text-align: justify;">
                <p id="p_memo_contrato" class="fst-italic">{{ $pendientes->memo_contrato }}</p>
                <textarea name="memo_contrato" id="memo_contratoInput" class="d-none form-control mb-3">{{ $pendientes->memo_contrato }}</textarea>
                <button class="btn btn-primary mt-2 mb-2 me-2" id="memo_contratoButton">Editar</button>
                <span class="text-muted" style="font-size: 14px;">Última modificación {{Carbon\Carbon::parse($pendientes->fecha_contrato)->diffForHumans() }}</span>
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
<div class="alert d-flex justify-content-between align-items-center" id="tarjetaSwiss" role="alert">
    <div class="me-5">
        Tarjeta de Swissquote
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputTarjetaSwiss" name="tarjeta_swissquote" value="{{ $pendientes->tarjeta_swissquote }}">
    </div>
</div>
<div class="accordion">
    <div class="accordion-item alert alert-secondary pb-0" id="memo_tarjeta_swiss" role="alert">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed px-0 pb-0"
                style="background-color: transparent !important; color: #41464b !important; box-shadow: none !important;"
                type="button" data-bs-toggle="collapse" data-bs-target="#accordionSwiss"
                aria-expanded="false" aria-controls="accordionSwiss">
                Memo de Tarjeta Swissquote
            </button>
            <hr class="px-0 mx-0">
        </h2>
        <div id="accordionSwiss" class="accordion-collapse collapse" aria-labelledby="headingOne"
            data-bs-parent="#accordionExample">
            <div class="accordion-body px-0" style="text-align: justify;">
                <p id="p_memo_tarjeta_swiss" class="fst-italic">{{ $pendientes->memo_tarjeta_swissquote }}</p>
                <textarea name="memo_tarjeta_swiss" id="memo_tarjeta_swissInput" class="d-none form-control mb-3">{{ $pendientes->memo_tarjeta_swissquote }}</textarea>
                <button class="btn btn-primary mt-2 mb-2 me-2" id="memo_tarjeta_swissButton">Editar</button>
                <span class="text-muted" style="font-size: 14px;">Última modificación {{Carbon\Carbon::parse($pendientes->fecha_tarjeta_swissquote)->diffForHumans() }}</span>
            </div>
        </div>
    </div>
</div> 
<div class="alert d-flex justify-content-between align-items-center" id="tarjetaUp" role="alert">
    <div class="me-5">
        Tarjeta de Up Trading
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputTarjetaUp" name="tarjeta_uptrading" value="{{ $pendientes->tarjeta_uptrading }}">
    </div>
</div>
<div class="accordion">
    <div class="accordion-item alert alert-secondary pb-0" id="memo_tarjeta_uptrading" role="alert">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed px-0 pb-0"
                style="background-color: transparent !important; color: #41464b !important; box-shadow: none !important;"
                type="button" data-bs-toggle="collapse" data-bs-target="#accordionUp"
                aria-expanded="false" aria-controls="accordionUp">
                Memo de Tarjeta Up Trading
            </button>
            <hr class="px-0 mx-0">
        </h2>
        <div id="accordionUp" class="accordion-collapse collapse" aria-labelledby="headingOne"
            data-bs-parent="#accordionExample">
            <div class="accordion-body px-0" style="text-align: justify;">
                <p id="p_memo_tarjeta_uptrading" class="fst-italic">{{ $pendientes->memo_tarjeta_uptrading }}</p>
                <textarea name="memo_tarjeta_uptrading" id="memo_tarjeta_uptradingInput" class="d-none form-control mb-3">{{ $pendientes->memo_tarjeta_uptrading }}</textarea>
                <button class="btn btn-primary mt-2 mb-2 me-2" id="memo_tarjeta_uptradingButton">Editar</button>
                <span class="text-muted" style="font-size: 14px;">Última modificación {{Carbon\Carbon::parse($pendientes->fecha_tarjeta_uptrading)->diffForHumans() }}</span>
            </div>
        </div>
    </div>
</div> 
<div class="alert d-flex justify-content-between align-items-center" id="1erPago" role="alert">
    <div class="me-5">
        1er pago
    </div>
    <div class="form-check">
        <input class="fs-4 form-check-input" type="checkbox" id="checkboxInputPago"
            name="primer_pago" value="{{ $pendientes->primer_pago }}">
    </div>
</div>
<div class="accordion">
    <div class="accordion-item alert alert-secondary pb-0" id="memo_primer_pago" role="alert">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed px-0 pb-0"
                style="background-color: transparent !important; color: #41464b !important; box-shadow: none !important;"
                type="button" data-bs-toggle="collapse" data-bs-target="#accordionPago"
                aria-expanded="false" aria-controls="accordionPago">
                Memo de 1er pago
            </button>
            <hr class="px-0 mx-0">
        </h2>
        <div id="accordionPago" class="accordion-collapse collapse" aria-labelledby="headingOne"
            data-bs-parent="#accordionExample">
            <div class="accordion-body px-0" style="text-align: justify;">
                <p id="p_memo_primer_pago" class="fst-italic">{{ $pendientes->memo_primer_pago }}</p>
                <textarea name="memo_primer_pago" id="memo_primer_pagoInput" class="d-none form-control mb-3">{{ $pendientes->memo_primer_pago }}</textarea>
                <button class="btn btn-primary mt-2 mb-2 me-2" id="memo_primer_pagoButton">Editar</button>
                <span class="text-muted" style="font-size: 14px;">Última modificación {{Carbon\Carbon::parse($pendientes->fecha_primer_pago)->diffForHumans() }}</span>
            </div>
        </div>
    </div>
</div> 