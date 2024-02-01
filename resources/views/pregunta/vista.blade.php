@if (sizeof($preguntas) > 0)
    @foreach ($preguntas as $pregunta)
        @php
            $pregunta_info = str_replace(' ', '', $pregunta->pregunta);
            $pregunta_info = str_replace('/', '', $pregunta_info);
        @endphp
        <div class="row mb-1 mt-1">
            <div class="accordion accordion-flush mb-1" id="accordionFlushExample">
                <div class="accordion-item shadow p-3 bg-body rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $pregunta_info }}" aria-expanded="false" aria-controls="{{ $pregunta_info }}">
                            {{ $pregunta->pregunta }}
                        </button>
                    </h2>
                    <div id="{{ $pregunta_info }}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body" style="text-align: justify">
                            {{ $pregunta->informacion }}
                            <br>
                            <div class="mt-3 text-center">
                                <img src="{{asset("img/preguntas/$pregunta->imagen")}}" alt="{{$pregunta->pregunta}}" class="img-fluid" width="850px">
                            </div>
                        </div>
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