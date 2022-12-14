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

            if ($request->hasFile('anverso')) {
                $anverso = $request->file('anverso');

                $time = time();
                $timestamp = date("Y-m-d", $time);

                $filename = $contrato . ' ' . $timestamp . '.png';

                $anverso->move(public_path('documentos/contrato_escaneado'), $filename);
                $contrato_escaneado->img_anverso = $filename;
                
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

            if ($request->hasFile('anverso')) {
                $anverso = $request->file('anverso');

                $time = time();
                $timestamp = date("Y-m-d", $time);

                $filename = "Anverso " . $contrato . ' ' . $timestamp . '.png';

                $anverso->move(public_path('documentos/contrato_escaneado'), $filename);
                $contrato_escaneado->img_anverso = $filename;
            } 

            if ($request->hasFile('reverso')) {
                $reverso = $request->file('reverso');

                $time = time();
                $timestamp = date("Y-m-d", $time);

                $filename_reverso = "Reverso " . $contrato . ' ' . $timestamp . '.png';

                $reverso->move(public_path('documentos/contrato_escaneado'), $filename_reverso);
                $contrato_escaneado->img_reverso = $filename_reverso;
            } 

            $contrato_escaneado->update();

            return response($contrato_escaneado);

        }
    }
}