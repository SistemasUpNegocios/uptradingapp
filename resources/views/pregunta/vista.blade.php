@if (sizeof($preguntas) > 0)
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
@else
    <div class="row mb-1 mt-4 pt-3 text-center">
        <p>No se encontraron resultados coincidentes con <b>"{{ $info }}"</b></p>
    </div>
@endif