<?php

namespace App\Http\Controllers;

use App\Models\ContratoEscaneado;
use Illuminate\Http\Request;

class ContratoEscaneadoController extends Controller
{
    public function checkScanner(Request $request)
    {
        $contrato_id = $request->id;

        $scanner = ContratoEscaneado::where('contrato_id', $contrato_id)->get();

        if ($scanner->first()) {
            return $scanner;
        } else {
            return "none";
        }
    }

    public function addScanner(Request $request)
    {
        if ($request->ajax()) {
            $contrato_id = $request->id;
            $contrato = $request->contrato;

            $contrato_escaneado = new ContratoEscaneado;

            if ($request->hasFile('img')) {
                $img = $request->file('img');

                $time = time();
                $timestamp = date("Y-m-d", $time);

                $filename = $contrato . ' ' . $timestamp . '.png';

                $img->move(public_path('documentos/contrato_escaneado'), $filename);
                $contrato_escaneado->img = $filename;
                
            }

            $contrato_escaneado->contrato_id = $contrato_id;
            $contrato_escaneado->save();

            return response($contrato_escaneado);

        }
    }


    public function editScanner(Request $request)
    {
        if ($request->ajax()) {
            $contrato_id = $request->id;
            $contrato = $request->contrato;

            $contrato_escaneado = ContratoEscaneado::where('contrato_id', $request->id)->get();

            $contrato_escaneado = ContratoEscaneado::find($contrato_escaneado[0]->id);

            if ($request->hasFile('img')) {
                $img = $request->file('img');

                $time = time();
                $timestamp = date("Y-m-d", $time);

                $filename = $contrato . ' ' . $timestamp . '.png';

                $img->move(public_path('documentos/contrato_escaneado'), $filename);
                $contrato_escaneado->img = $filename;
            } 

            $contrato_escaneado->update();

            return response($contrato_escaneado);

        }
    }
}