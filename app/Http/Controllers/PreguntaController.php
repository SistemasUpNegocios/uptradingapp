<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Log;

class PreguntaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
            return response()->view('pregunta.show');
        } else {
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getPreguntas()
    {
        $preguntas = Pregunta::all();
        return datatables()->of($preguntas)->addColumn('btn', 'pregunta.buttons')->rawColumns(['btn'])->toJson();
    }

    public function addPregunta(Request $request)
    {
        $pregunta = new Pregunta;
        $pregunta->pregunta = $request->pregunta;
        $pregunta->informacion = $request->informacion;
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = $file->getClientOriginalName();

            $file->move(public_path('img/preguntas'), $filename);
            $pregunta->imagen = $filename;
        }

        $pregunta->save();

        $pregunta_id = $pregunta->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Inserción";
        $log->tabla = "Preguntas";
        $log->id_tabla = $pregunta_id;
        $log->bitacora_id = $bitacora_id;

        $log->save();

        return response($pregunta);
    }

    public function editPregunta(Request $request)
    {
        $pregunta = Pregunta::find($request->id);
        $pregunta->pregunta = $request->pregunta;
        $pregunta->informacion = $request->informacion;
        if ($request->hasFile('img')) {
            $pregunta_imagen = Pregunta::where('id', $request->id)->first();
    
            $imagen_anterior = $pregunta_imagen->imagen;

            if (is_file(public_path('img/preguntas') . $imagen_anterior)) {
                chmod(public_path('img/preguntas') . $imagen_anterior, 0777);
                unlink(public_path('img/preguntas') . $imagen_anterior);
            }

            $file = $request->file('img');
            $filename = $file->getClientOriginalName();

            $file->move(public_path('img/preguntas'), $filename);
            $pregunta->imagen = $filename;
        }

        $pregunta->update();

        $pregunta_id = $pregunta->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Actualización";
        $log->tabla = "Preguntas";
        $log->id_tabla = $pregunta_id;
        $log->bitacora_id = $bitacora_id;

        $log->save();

        return response($pregunta);
    }

    public function deletePregunta(Request $request)
    {
        $pregunta_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Eliminación";
        $log->tabla = "Preguntas";
        $log->id_tabla = $pregunta_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            if ($request->ajax()) {
                Pregunta::destroy($request->id);
            }
        }
    }

    public function buscarPregunta(Request $request)
    {
        $info = $request->info;

        if(auth()->user()->is_ps_gold || auth()->user()->is_ps_bronze){
            $preguntas = Pregunta::select()
            ->where("id", "!=", 5)
            ->where("id", "!=", 7)
            ->where(function ($query) use ($info) {
                $query->where("pregunta", "like", "%$info%")
                ->orWhere("informacion", "like", "%$info%");
            })->get();
        }else{
            $preguntas = Pregunta::select()
            ->where("pregunta", "like", "%$request->info%")
            ->orWhere("informacion", "like", "%$request->info%")
            ->get();
        }

        return View::make("pregunta/vista", ["preguntas" => $preguntas, "info" => $request->info]);
    }
}