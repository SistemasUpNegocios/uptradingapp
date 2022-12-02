<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class BusquedaController extends Controller
{
    public function buscarCliente(Request $request)
    {
        if ($request->ajax()) {
            $codigo = session("codigo_oficina");
            $query = $request->input('query');

            $clientes = Cliente::
            whereRaw("CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '%" . $query . "%'")
                ->orderByRaw(
                    "CASE
                        WHEN CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '$query%' THEN 1
                        WHEN CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '%$query' THEN 3
                    ELSE 2
                    END"
                )->where("codigoCliente", "like", "MXN-$codigo%")
                ->get();

            if ($clientes->first()) {
                return response()->view('busqueda.resultados', compact('clientes', 'query'), 200);
            } else {
                return response($query, 500);
            }
        }
    }
}