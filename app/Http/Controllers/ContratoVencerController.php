<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Ps;
use App\Models\Contrato;
use App\Models\Log;
use App\Models\Ticket;
use App\Models\TipoContrato;
use App\Models\Notificacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContratoVencerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {

        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos){
            $codigo = session('codigo_oficina');
            $numeroCliente = "MXN-" . $codigo . "-";

            $ps = Ps::select()->where("codigoPS", "like", "$codigo%")->get();
            $clientes = Cliente::select()->orderBy("apellido_p")->where("codigoCliente", "like", "$numeroCliente%")->get();
            $tipos = TipoContrato::all();
            $pendientes = DB::table('pendiente')
                ->select()
                ->join('ps', 'ps.id', '=', 'pendiente.ps_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->where('oficina.codigo_oficina', 'like', $codigo)
                ->get();

            $data = array(
                "lista_ps" => $ps,
                "lista_clientes" => $clientes,
                "lista_tipos" => $tipos,
                "lista_pendientes" => $pendientes,
            );

            return response()->view('contratosvencer.show', $data, 200);
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getContratoVencer ()
    {
        $contrato = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('tipo_contrato', 'tipo_contrato.id', '=', 'contrato.tipo_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->select(DB::raw("contrato.id, contrato.operador, contrato.lugar_firma, contrato.periodo, contrato.fecha, contrato.operador_ine, contrato.fecha_renovacion, contrato.fecha_pago, contrato.fecha_limite, contrato.contrato, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, cliente.celular, tipo_contrato.id AS tipoid, tipo_contrato.tipo, tipo_contrato.capertura AS capertura, tipo_contrato.cmensual AS cmensual, tipo_contrato.rendimiento, contrato.porcentaje, contrato.folio, contrato.inversion, contrato.tipo_cambio, contrato.inversion_us, contrato.inversion_letra, contrato.inversion_letra_us, contrato.fecha_reintegro, contrato.status_reintegro, contrato.memo_reintegro, contrato.status, contrato.pendiente_id AS pendienteid, contrato.tipo_pago, contrato.monto_pago, contrato.comprobante_pago, contrato.nota_contrato, contrato.autorizacion_nota"))
            ->where("contrato.status", "Activado")
            ->where("fecha_renovacion", "<=", Carbon::now()->addDays(15)->format('Y-m-d'))
            ->where("fecha_renovacion", ">=", Carbon::now()->format('Y-m-d'))
            ->orderBy("fecha_renovacion", "ASC")
            ->get();
       

        return datatables()->of($contrato)->addColumn('btn', 'contratosvencer.buttons')->rawColumns(['btn'])->toJson();
    }

    public function editNota(Request $request)
    {

        $bitacora_id = session('bitacora_id');

        $contrato = Contrato::find($request->id);
        $contrato->nota_contrato = $request->nota_contrato;
        $contrato->save();

        $contrato_completo = Contrato::join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->select(DB::raw("CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS cliente, fecha_renovacion"))
            ->where("contrato.id", $contrato->id)
            ->first();

        $contrato_id = $contrato->id;
        $log = new Log;
        $log->tipo_accion = "Inserción";
        $log->tabla = "Ticket";
        $log->id_tabla = $contrato_id;
        $log->bitacora_id = $bitacora_id;
        $log->save();

        $ticket = new Ticket;
        $ticket->generado_por = auth()->user()->id;
        $ticket->asignado_a = "246".','.Carbon::now()->toDateTimeString();
        $ticket->fecha_generado = Carbon::now()->toDateTimeString();
        $ticket->fecha_limite = Carbon::now()->addDays(5)->toDateTimeString();
        $ticket->departamento = "Egresos";
        $ticket->asunto = "Nota de contrato a vencer";
        $ticket->descripcion = "$request->nota_contrato.\nCliente: $contrato_completo->cliente.\nContrato: $contrato->contrato.\nFecha de termino: $contrato_completo->fecha_renovacion.";
        $ticket->status = "Abierto";
        $ticket->save();

        $ticket_id = $ticket->id;
        $log = new Log;
        $log->tipo_accion = "Actualización";
        $log->tabla = "Contrato (nota)";
        $log->id_tabla = $ticket_id;
        $log->bitacora_id = $bitacora_id;
        $log->save();

        if ($log->save()) {
            $notificacion = new Notificacion;
            $notificacion->titulo = "Ticket abierto";
            $notificacion->mensaje = "Tienes un nuevo ticket abierto con asunto: Nota de contrato a vencer";
            $notificacion->status = "Pendiente";
            $notificacion->user_id = 246;
            $notificacion->save();

            return response($ticket);
        }

        return response($contrato);
    }
    
    public function autorizarNota(Request $request)
    {
        $contrato = Contrato::find($request->id);
        $contrato->autorizacion_nota = $request->autorizacion;
        $contrato->save();

        return response($contrato);
    }
}