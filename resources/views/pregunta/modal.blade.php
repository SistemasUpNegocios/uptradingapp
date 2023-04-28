@php
    use App\Models\Pregunta;
    if(auth()->user()->is_ps_gold || auth()->user()->is_ps_bronze){
        $preguntas = Pregunta::where("id", "!=", 5)->where("id", "!=", 7)->get();
    }else{
        $preguntas = Pregunta::all();
    }
@endphp

<div class="modal fade" id="formModalFaq" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Preguntas frecuentes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="d-flex mb-3 align-items-center" role="search" id="formPreguntas" autocomplete="off">
                    <input class="form-control me-2" id="buscarPreguntaInput" type="search" placeholder="Buscar..." aria-label="Buscar..." style="text-transform: none;">
                    <i class="bi bi-search" style="margin-left: -37px !important" id="buscarIcono"></i>
                </form>
                <div id="listaPreguntas">
                    @foreach ($preguntas as $pregunta)
                        <div class="row mb-1 mt-1">
                            <div class="accordion accordion-flush mb-1" id="accordionFlushExample">
                                <div class="accordion-item shadow p-3 bg-body rounded">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#{{ str_replace(' ', '', $pregunta->pregunta) }}" aria-expanded="false" aria-controls="{{ str_replace(' ', '', $pregunta->pregunta) }}">
                                        {{ $pregunta->pregunta }}
                                    </button>
                                </h2>
                                <div id="{{ str_replace(' ', '', $pregunta->pregunta) }}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body" style="text-align: justify">{{ $pregunta->informacion }}</div>
                                </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>