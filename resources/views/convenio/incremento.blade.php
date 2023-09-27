@php
    $incrementos = App\Models\IncrementoConvenio::where('convenio_id', $id)->get();

    echo count($incrementos);
@endphp