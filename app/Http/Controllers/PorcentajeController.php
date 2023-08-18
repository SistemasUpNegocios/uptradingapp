<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Amortizacion;
use App\Models\PagoCliente;
use App\Models\Log;
use App\Models\Ps;
use App\Models\TipoContrato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PorcentajeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if(auth()->user()->is_root){
            $ps = Ps::all();
            $clientes = Cliente::select()->orderBy("apellido_p")->get();
            $tipos = TipoContrato::all();
            $pendientes = DB::table('pendiente')
                ->select()
                ->join('ps', 'ps.id', '=', 'pendiente.ps_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->get();
    
            $data = array(
                "lista_ps" => $ps,
                "lista_clientes" => $clientes,
                "lista_tipos" => $tipos,
                "lista_pendientes" => $pendientes,
            );
    
            return response()->view('porcentaje.show', $data, 200);
        } else {
            return redirect()->to('/admin/dashboard');        
        }
    }

    public function getContratosPorcentaje()
    {
        $contrato = DB::table('contrato')
        ->join('ps', 'ps.id', '=', 'contrato.ps_id')
        ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
        ->join('tipo_contrato', 'tipo_contrato.id', '=', 'contrato.tipo_id')
        ->join('oficina', "oficina.id", "=", "ps.oficina_id")
        ->select(DB::raw("contrato.id, contrato.operador, contrato.lugar_firma, contrato.periodo, contrato.fecha, contrato.operador_ine, contrato.fecha_renovacion, contrato.fecha_pago, contrato.fecha_limite, contrato.contrato, ps.id AS psid, cliente.id AS clienteid,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, tipo_contrato.id AS tipoid, tipo_contrato.capertura AS capertura, tipo_contrato.cmensual AS cmensual, tipo_contrato.rendimiento, contrato.porcentaje, contrato.folio, contrato.inversion, contrato.tipo_cambio, contrato.inversion_us, contrato.inversion_letra, contrato.inversion_letra_us, contrato.status, contrato.tipo_pago, contrato.comprobante_pago"))
        ->where("contrato.status", "=", "Pendiente de activación")
        ->get();

        return datatables()->of($contrato)->addColumn('btn', 'porcentaje.buttons')->rawColumns(['btn'])->toJson();

    }

    public function editPorcentajes(Request $request)
    {
        if ($request->ajax()) {
            $contrato = Contrato::find($request->id);
            $contrato->porcentaje = $request->porcentaje;
            $contrato->update();

            $rendimiento = $contrato->porcentaje * .01;
            $monto = $contrato->inversion_us;

            if ($contrato->tipo_id == 1) {
                for ($i = 0; $i < $contrato->periodo; $i++) {

                    $redito = $monto * $rendimiento;
                    $pago = $monto + $redito;

                    Amortizacion::where('contrato_id', $contrato->id)->update(["saldo_con_redito" => $pago, "redito" => $redito, "monto" => $monto]);
                    PagoCliente::where('contrato_id', $contrato->id)->update(["pago" => $redito]);
                    
                }

            }else if($contrato->tipo_id == 2){
                for ($i = 0; $i < $contrato->periodo; $i++) {

                    $redito = $monto * $rendimiento;
                    $pago = $monto + $redito;

                    Amortizacion::where('contrato_id', $contrato->id)
                    ->where('serie', $i+1)
                    ->update(["saldo_con_redito" => $pago, "redito" => $redito, "monto" => $monto]);

                    $monto = $monto + $redito;
                }

                PagoCliente::where('contrato_id', $contrato->id)->update(["pago" => $pago]);
            }

            $contrato_id = $contrato->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Actualización";
            $log->tabla = "Contrato (porcentajes)";
            $log->id_tabla = $contrato_id;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {
                return response($contrato);
            }
        }

    }
}
