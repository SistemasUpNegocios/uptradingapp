<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendiente;
use App\Models\Ps;
use App\Models\Log;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;


class PendienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_gold || auth()->user()->is_ps_diamond || auth()->user()->is_ps_bronze){
            $codigo = session('codigo_oficina');

            $pendientes = DB::table('pendiente')
                ->join('ps', 'ps.id', '=', 'pendiente.ps_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, pendiente.ps_id, pendiente.id AS pendienteid, pendiente.nombre, pendiente.memo_nombre, pendiente.introduccion, pendiente.formulario, pendiente.alta_cliente, pendiente.videoconferencia, pendiente.apertura, pendiente.memo_apertura, pendiente.instrucciones_bancarias, pendiente.generar_lpoa, pendiente.instrucciones_bancarias_mam, pendiente.transferencia, pendiente.conexion_mampool, pendiente.generar_convenio, pendiente.primer_reporte, pendiente.ultima_modificacion"))
                ->orderBy("ultima_modificacion", "desc")
                ->where("codigo_oficina", "like", $codigo)
                ->get();

            $ps = Ps::select()->where('codigoPS', 'like', "$codigo%")->get();

            $data = array(
                "lista_ps" => $ps,
                "pendientes" => $pendientes,
            );

            return response()->view('pendiente.show', $data, 200);
        }else{
            return redirect()->to('/admin/dashboard');
        }
        
    }

    public function addPendiente(Request $request)
    {
        $pendiente = new Pendiente;
        $pendiente->ps_id = $request->input('ps_id');
        $pendiente->memo_nombre = strtoupper($request->input('nombre'));
        $pendiente->memo_apertura = "Sin notas";
        $pendiente->save();

        $pendiente_id = $pendiente->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Inserción";
        $log->tabla = "Pendientes";
        $log->id_tabla = $pendiente_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            $pendientes = DB::table("pendiente")
                ->orderBy("ultima_modificacion", "desc")
                ->get();
            return response(["data" => $pendientes]);
        }   
        
    }

    public function listaPendientes(Request $request)
    {
        $pendientes = DB::table('pendiente')
            ->join('ps', 'ps.id', '=', 'pendiente.ps_id')
            ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, pendiente.ps_id, pendiente.id AS pendienteid, pendiente.nombre, pendiente.memo_nombre, pendiente.introduccion, pendiente.formulario, pendiente.alta_cliente, pendiente.videoconferencia, pendiente.apertura, pendiente.memo_apertura, pendiente.instrucciones_bancarias, pendiente.generar_lpoa, pendiente.memo_generar_lpoa, pendiente.instrucciones_bancarias_mam, pendiente.transferencia, pendiente.memo_transferencia, pendiente.conexion_mampool, memo_conexion_mampool, pendiente.generar_convenio, pendiente.memo_generar_convenio, pendiente.primer_reporte, pendiente.ultima_modificacion, fecha_introduccion, fecha_formulario, fecha_alta_cliente, fecha_videoconferencia, fecha_apertura, fecha_instrucciones_bancarias, fecha_generar_lpoa, fecha_instrucciones_bancarias_mam, fecha_transferencia, fecha_conexion_mampool, fecha_generar_convenio, fecha_primer_reporte"))
            ->where("pendiente.id", "=", $request->id)
            ->first();

        return view('pendiente.pendientes', compact('pendientes'));
        
    }

    public function listaClientes()
    {
        $codigo = session('codigo_oficina');

        $pendientes = DB::table('pendiente')
            ->join('ps', 'ps.id', '=', 'pendiente.ps_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, pendiente.ps_id, pendiente.id AS pendienteid, pendiente.nombre, pendiente.memo_nombre, pendiente.introduccion, pendiente.formulario, pendiente.alta_cliente, pendiente.videoconferencia, pendiente.apertura, pendiente.memo_apertura, pendiente.instrucciones_bancarias, pendiente.generar_lpoa, pendiente.instrucciones_bancarias_mam, pendiente.transferencia, pendiente.conexion_mampool, pendiente.generar_convenio, pendiente.primer_reporte, pendiente.ultima_modificacion"))
            ->orderBy("ultima_modificacion", "desc")
            ->where("codigo_oficina", "like", $codigo)
            ->get();

        $ps = Ps::all();

        $data = array(
            "lista_ps" => $ps,
            "pendientes" => $pendientes,
        );

        return response(["pendientes" => $pendientes]);
    }

    public function editPendiente(Request $request)
    {
        $pendiente = Pendiente::find($request->id);

        if (!empty($request->introduccion)) {
            $pendiente->introduccion = "Hecho";
            $pendiente->fecha_introduccion = date("Y-m-d H:i:s");
        } else {
            $pendiente->introduccion = "Pendiente";
            $pendiente->fecha_introduccion = date("Y-m-d H:i:s");
        }

        if (!empty($request->formulario)) {
            $pendiente->formulario = "Hecho";
            $pendiente->fecha_formulario = date("Y-m-d H:i:s");
        } else {
            $pendiente->formulario = "Pendiente";
            $pendiente->fecha_formulario = date("Y-m-d H:i:s");
        }

        if (!empty($request->alta_cliente)) {
            $pendiente->alta_cliente = "Hecho";
            $pendiente->fecha_alta_cliente = date("Y-m-d H:i:s");
        } else {
            $pendiente->alta_cliente = "Pendiente";
            $pendiente->fecha_alta_cliente = date("Y-m-d H:i:s");
        }

        if (!empty($request->videoconferencia)) {
            $pendiente->videoconferencia = "Hecho";
            $pendiente->fecha_videoconferencia = date("Y-m-d H:i:s");
        } else {
            $pendiente->videoconferencia = "Pendiente";
        }

        if (!empty($request->apertura)) {
            $pendiente->apertura = "Hecho";
        } else {
            $pendiente->apertura = "Pendiente";
        }

        if (!empty($request->instrucciones_bancarias)) {
            $pendiente->instrucciones_bancarias = "Hecho";
            $pendiente->fecha_instrucciones_bancarias = date("Y-m-d H:i:s");
        } else {
            $pendiente->instrucciones_bancarias = "Pendiente";
            $pendiente->fecha_instrucciones_bancarias = date("Y-m-d H:i:s");
        }

        if (!empty($request->generar_lpoa)) {
            $pendiente->generar_lpoa = "Hecho";
        } else {
            $pendiente->generar_lpoa = "Pendiente";
        }

        if (!empty($request->instrucciones_bancarias_mam)) {
            $pendiente->instrucciones_bancarias_mam = "Hecho";
            $pendiente->fecha_instrucciones_bancarias_mam = date("Y-m-d H:i:s");
        } else {
            $pendiente->instrucciones_bancarias_mam = "Pendiente";
            $pendiente->fecha_instrucciones_bancarias_mam = date("Y-m-d H:i:s");
        }

        if (!empty($request->transferencia)) {
            $pendiente->transferencia = "Hecho";
        } else {
            $pendiente->transferencia = "Pendiente";
        }

        if (!empty($request->conexion_mampool)) {
            $pendiente->conexion_mampool = "Hecho";
        } else {
            $pendiente->conexion_mampool = "Pendiente";
        }

        if (!empty($request->generar_convenio)) {
            $pendiente->generar_convenio = "Hecho";
        } else {
            $pendiente->generar_convenio = "Pendiente";
        }

        if (!empty($request->primer_reporte)) {
            $pendiente->primer_reporte = "Hecho";
            $pendiente->fecha_primer_reporte = date("Y-m-d H:i:s");
        } else {
            $pendiente->primer_reporte = "Pendiente";
            $pendiente->fecha_primer_reporte = date("Y-m-d H:i:s");
        }

        if($pendiente->memo_apertura != $request->memo_apertura){
            $pendiente->fecha_apertura = date("Y-m-d H:i:s");
        }
        if($pendiente->memo_generar_lpoa != $request->memo_generar_lpoa){
            $pendiente->fecha_generar_lpoa = date("Y-m-d H:i:s");
        }
        if($pendiente->memo_transferencia != $request->memo_transferencia){
            $pendiente->fecha_transferencia = date("Y-m-d H:i:s");
        }
        if($pendiente->memo_conexion_mampool != $request->memo_mam_pool){
            $pendiente->fecha_conexion_mampool = date("Y-m-d H:i:s");
        }
        if($pendiente->memo_generar_convenio != $request->memo_generar_convenio){
            $pendiente->fecha_generar_convenio = date("Y-m-d H:i:s");
        }

        $pendiente->memo_apertura = $request->memo_apertura;
        $pendiente->memo_generar_lpoa = $request->memo_generar_lpoa;
        $pendiente->memo_transferencia = $request->memo_transferencia;
        $pendiente->memo_conexion_mampool = $request->memo_mam_pool;
        $pendiente->memo_generar_convenio = $request->memo_generar_convenio;

        $pendiente->ultima_modificacion = date("Y-m-d H:i:s");


        $pendiente_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Actualización";
        $log->tabla = "Pendientes";
        $log->id_tabla = $pendiente_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            $pendiente->update();
            return response($pendiente);
        }        
    }

    public function deletePendiente(Request $request)
    {
        $pendiente_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Eliminación";
        $log->tabla = "Pendientes";
        $log->id_tabla = $pendiente_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            Pendiente::destroy($request->id);
            $pendientes = DB::table("pendiente")
                ->orderBy("ultima_modificacion", "desc")
                ->get();

            return response(["data" => $pendientes]);
        }
    }

    public function generateList()
    {
        $codigo = session('codigo_oficina');

        $pendientes = DB::table("pendiente")
            ->join('ps', 'ps.id', '=', 'pendiente.ps_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, pendiente.ps_id, pendiente.id AS pendienteid, pendiente.nombre, pendiente.memo_nombre, pendiente.introduccion, pendiente.formulario, pendiente.alta_cliente, pendiente.videoconferencia, pendiente.apertura, pendiente.memo_apertura, pendiente.instrucciones_bancarias, pendiente.generar_lpoa, pendiente.instrucciones_bancarias_mam, pendiente.transferencia, pendiente.conexion_mampool, pendiente.generar_convenio, pendiente.primer_reporte, pendiente.ultima_modificacion"))
            ->orderBy("ultima_modificacion", "desc")
            ->where("codigo_oficina", "like", $codigo)
            ->get();

        return View::make("pendiente/lista", ["pendientes" => $pendientes]);
    }
}