@php
    if(!$modelo){
        $modelo = 'Sin modelo';
    }
@endphp

<div data-id="{{ $id_cliente }}" data-modelo="{{$modelo}}" class="modelo">{{$modelo}}</div>