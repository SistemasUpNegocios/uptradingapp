@foreach ($pendientes as $pendiente)
<div class="col-lg-12 ps-3 pe-3">
    <div class="card border-0 mb-4 mt-4">
        <div class="d-flex">
            <div class="horizontal-card-bg-img"></div>
            <div class="flex-fill">
              <div class="card-body">
                <div class="font-weight-bold mt-3"><b>Lista de {{ $pendiente->memo_nombre }}</b></div>
                <div class="mb-3">Última modificación {{Carbon\Carbon::parse($pendiente->ultima_modificacion)->diffForHumans() }}</div>
              </div>
            </div>
            <div class="horizontal-card-btn-container d-flex justify-content-center align-items-center">
              <a class="btn btn-sm btn-primary me-2 showLista" data-id="{{ $pendiente->pendienteid }}" title="Ver los pendientes de {{ $pendiente->memo_nombre }}">Ver pendientes</a>
              <a class="btn btn-sm btn-danger delete" data-id="{{ $pendiente->pendienteid }}" title="Eliminar los pendientes de {{ $pendiente->memo_nombre }}"><i class="bi bi-trash"></i></a>
            </div>
        </div>
    </div>
</div> 
@endforeach    