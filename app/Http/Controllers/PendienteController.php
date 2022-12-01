<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendiente;
use App\Models\Ps;
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
        if(!auth()->user()->is_cliente){
            $codigo = session('codigo_oficina');

            $pendientes = DB::table('pendiente')
                ->join('ps', 'ps.id', '=', 'pendiente.ps_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, pendiente.ps_id, pendiente.id AS pendienteid, pendiente.nombre, pendiente.memo_nombre, pendiente.introduccion, pendiente.intencion_inversion, pendiente.formulario, pendiente.videoconferencia, pendiente.apertura, pendiente.memo_apertura, pendiente.instrucciones_bancarias, pendiente.transferencia, pendiente.contrato, pendiente.conexion_mampool, pendiente.primer_pago, pendiente.tarjeta_swissquote, pendiente.tarjeta_uptrading, pendiente.ultima_modificacion"))
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
        if ($request->ajax()) {
            // $request->validate([
            //     'memo_nombre' => 'required | unique:pendiente',
            // ]);

            $pendiente = new Pendiente;
            $pendiente->ps_id = $request->input('ps_id');
            $pendiente->memo_nombre = strtoupper($request->input('nombre'));
            $pendiente->memo_apertura = "Sin notas";
            $pendiente->save();

            if ($pendiente) {
                $pendientes = DB::table("pendiente")
                    ->orderBy("ultima_modificacion", "desc")
                    ->get();

                return response(["data" => $pendientes]);
            }

            // return response($pendiente);
        }
    }

    public function listaPendientes(Request $request)
    {
        $pendientes = DB::table('pendiente')
            ->join('ps', 'ps.id', '=', 'pendiente.ps_id')
            ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, pendiente.ps_id, pendiente.id AS pendienteid, pendiente.nombre, pendiente.memo_nombre, pendiente.introduccion, pendiente.intencion_inversion, pendiente.formulario, pendiente.videoconferencia, pendiente.apertura, pendiente.memo_apertura, pendiente.instrucciones_bancarias, pendiente.transferencia, pendiente.contrato, pendiente.conexion_mampool, pendiente.primer_pago, pendiente.tarjeta_swissquote, pendiente.tarjeta_uptrading, pendiente.ultima_modificacion, memo_introduccion, memo_intencion_inversion, memo_formulario, memo_videoconferencia, memo_apertura, memo_instrucciones_bancarias, memo_transferencia, memo_contrato, memo_conexion_mampool, memo_tarjeta_swissquote, memo_tarjeta_uptrading, memo_primer_pago, fecha_introduccion, fecha_intencion_inversion, fecha_formulario, fecha_videoconferencia, fecha_apertura, fecha_instrucciones_bancarias, fecha_transferencia, fecha_contrato, fecha_conexion_mampool, fecha_tarjeta_swissquote, fecha_tarjeta_uptrading, fecha_primer_pago"))
            ->where("pendiente.id", "=", $request->id)
            ->first();

        return view('pendiente.pendientes', compact('pendientes'));
        
    }

    public function listaClientes()
    {
        $pendientes = DB::table('pendiente')
            ->join('ps', 'ps.id', '=', 'pendiente.ps_id')
            ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, pendiente.ps_id, pendiente.id AS pendienteid, pendiente.nombre, pendiente.memo_nombre, pendiente.introduccion, pendiente.intencion_inversion, pendiente.formulario, pendiente.videoconferencia, pendiente.apertura, pendiente.memo_apertura, pendiente.instrucciones_bancarias, pendiente.transferencia, pendiente.contrato, pendiente.conexion_mampool, pendiente.primer_pago, pendiente.tarjeta_swissquote, pendiente.tarjeta_uptrading, pendiente.ultima_modificacion"))
            ->orderBy("ultima_modificacion", "desc")
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
        } else {
            $pendiente->introduccion = "Pendiente";
        }

        if (!empty($request->intencion_inversion)) {
            $pendiente->intencion_inversion = "Hecho";
        } else {
            $pendiente->intencion_inversion = "Pendiente";
        }

        if (!empty($request->formulario)) {
            $pendiente->formulario = "Hecho";
        } else {
            $pendiente->formulario = "Pendiente";
        }

        if (!empty($request->videoconferencia)) {
            $pendiente->videoconferencia = "Hecho";
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
        } else {
            $pendiente->instrucciones_bancarias = "Pendiente";
        }

        if (!empty($request->transferencia)) {
            $pendiente->transferencia = "Hecho";
        } else {
            $pendiente->transferencia = "Pendiente";
        }

        if (!empty($request->contrato)) {
            $pendiente->contrato = "Hecho";
            $contrato_activo = DB::table('contrato')            
                        ->where("pendiente_id", "=", $request->id)
                        ->update(["status" => "Activado"]);
        } else {
            $pendiente->contrato = "Pendiente";
            $contrato_activo = DB::table('contrato')            
                        ->where("pendiente_id", "=", $request->id)
                        ->update(["status" => "Pendiente de activación"]);
        }

        if (!empty($request->conexion_mampool)) {
            $pendiente->conexion_mampool = "Hecho";
        } else {
            $pendiente->conexion_mampool = "Pendiente";
        }

        if (!empty($request->tarjeta_swissquote)) {
            $pendiente->tarjeta_swissquote = "Hecho";
        } else {
            $pendiente->tarjeta_swissquote = "Pendiente";
        }

        if (!empty($request->tarjeta_uptrading)) {
            $pendiente->tarjeta_uptrading = "Hecho";
        } else {
            $pendiente->tarjeta_uptrading = "Pendiente";
        }

        if (!empty($request->primer_pago)) {
            $pendiente->primer_pago = "Hecho";
        } else {
            $pendiente->primer_pago = "Pendiente";
        }

        if($pendiente->memo_introduccion != $request->memo_introduccion){
            $pendiente->fecha_introduccion = date("Y-m-d H:i:s");
        }
        if($pendiente->memo_intencion_inversion != $request->memo_intencion){
            $pendiente->fecha_intencion_inversion = date("Y-m-d H:i:s");
        }
        if($pendiente->memo_formulario != $request->memo_formulario){
            $pendiente->fecha_formulario = date("Y-m-d H:i:s");
        }
        if($pendiente->memo_videoconferencia != $request->memo_videoconferencia){
            $pendiente->fecha_videoconferencia = date("Y-m-d H:i:s");
        }
        if($pendiente->memo_apertura != $request->memo_apertura){
            $pendiente->fecha_apertura = date("Y-m-d H:i:s");
        }
        if($pendiente->memo_instrucciones_bancarias != $request->memo_instrucciones){
            $pendiente->fecha_instrucciones_bancarias = date("Y-m-d H:i:s");
        }
        if($pendiente->memo_transferencia != $request->memo_transferencia){
            $pendiente->fecha_transferencia = date("Y-m-d H:i:s");
        }
        if($pendiente->memo_contrato != $request->memo_contrato){
            $pendiente->fecha_contrato = date("Y-m-d H:i:s");
        }
        if($pendiente->memo_conexion_mampool != $request->memo_mam_pool){
            $pendiente->fecha_conexion_mampool = date("Y-m-d H:i:s");
        }        
        if($pendiente->memo_tarjeta_swissquote != $request->memo_tarjeta_swiss){
            $pendiente->fecha_tarjeta_swissquote = date("Y-m-d H:i:s");
        }
        if($pendiente->memo_tarjeta_uptrading != $request->memo_tarjeta_uptrading){
            $pendiente->fecha_tarjeta_uptrading = date("Y-m-d H:i:s");
        }
        if($pendiente->memo_primer_pago != $request->memo_primer_pago){
            $pendiente->fecha_primer_pago = date("Y-m-d H:i:s");
        }

        $pendiente->memo_introduccion = $request->memo_introduccion;
        $pendiente->memo_intencion_inversion = $request->memo_intencion;
        $pendiente->memo_formulario = $request->memo_formulario;
        $pendiente->memo_videoconferencia = $request->memo_videoconferencia;
        $pendiente->memo_apertura = $request->memo_apertura;
        $pendiente->memo_instrucciones_bancarias = $request->memo_instrucciones;
        $pendiente->memo_transferencia = $request->memo_transferencia;
        $pendiente->memo_contrato = $request->memo_contrato;
        $pendiente->memo_conexion_mampool = $request->memo_mam_pool;
        $pendiente->memo_tarjeta_swissquote = $request->memo_tarjeta_swiss;
        $pendiente->memo_tarjeta_uptrading = $request->memo_tarjeta_uptrading;
        $pendiente->memo_primer_pago = $request->memo_primer_pago;

        $pendiente->ultima_modificacion = date("Y-m-d H:i:s");

        $pendiente->update();
        return response($pendiente);
    }

    public function deletePendiente(Request $request)
    {
        if ($request->ajax()) {
            Pendiente::destroy($request->id);

            $pendientes = DB::table("pendiente")
                ->orderBy("ultima_modificacion", "desc")
                ->get();

            return response(["data" => $pendientes]);
        }
    }

    public function generateList(Request $request)
    {
        if(auth()->user()->is_ps_asistente || auth()->user()->is_ps_encargado){
            $codigo = session('codigo_oficina');
        }else{
            $codigo = "%";
        }

        $pendientes = DB::table("pendiente")
            ->join('ps', 'ps.id', '=', 'pendiente.ps_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, pendiente.ps_id, pendiente.id AS pendienteid, pendiente.nombre, pendiente.memo_nombre, pendiente.introduccion, pendiente.intencion_inversion, pendiente.formulario, pendiente.videoconferencia, pendiente.apertura, pendiente.memo_apertura, pendiente.instrucciones_bancarias, pendiente.transferencia, pendiente.contrato, pendiente.conexion_mampool, pendiente.primer_pago, pendiente.tarjeta_swissquote, pendiente.tarjeta_uptrading, pendiente.ultima_modificacion"))
            ->orderBy("ultima_modificacion", "desc")
            ->where("codigo_oficina", "like", $codigo)
            ->get();

        return View::make("pendiente/lista", ["pendientes" => $pendientes]);
    }
}