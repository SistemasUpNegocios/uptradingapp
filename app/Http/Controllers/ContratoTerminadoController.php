<?php

namespace App\Http\Controllers;

use App\Models\Amortizacion;
use App\Models\Beneficiario;
use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Log;
use App\Models\Modelo;
use App\Models\PagoPS;
use App\Models\Ps;
use App\Models\TipoContrato;
use App\Models\Pendiente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use Illuminate\Support\Facades\Auth;

class ContratoTerminadoController extends Controller
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

            return response()->view('contratoterminado.show', $data, 200);

        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getContrato()
    {
        $psid = session('psid');
        $clienteid = session('clienteid');
        $codigo = session('codigo_oficina');

        $contrato = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('tipo_contrato', 'tipo_contrato.id', '=', 'contrato.tipo_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->select(DB::raw("contrato.id, contrato.operador, contrato.lugar_firma, contrato.periodo, contrato.fecha, contrato.operador_ine, contrato.fecha_renovacion, contrato.fecha_pago, contrato.fecha_limite, contrato.contrato, ps.id AS psid, cliente.id AS clienteid,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, tipo_contrato.id AS tipoid, tipo_contrato.tipo, tipo_contrato.capertura AS capertura, tipo_contrato.cmensual AS cmensual, tipo_contrato.rendimiento, contrato.porcentaje, contrato.folio, contrato.inversion, contrato.tipo_cambio, contrato.inversion_us, contrato.inversion_letra, contrato.inversion_letra_us, contrato.status, contrato.tipo_pago, contrato.comprobante_pago"))
            ->where("contrato.ps_id", "like", $psid)
            ->where("contrato.cliente_id", "like", $clienteid)
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where("contrato.status", "!=", "Pendiente de activación")
            ->where("contrato.status", "!=", "Activado")
            ->where("contrato.status", "!=", "Refrendado")
            ->orderBy("contrato.id", "desc")
            ->get();        

        return datatables()->of($contrato)->addColumn('btn', 'contratoterminado.buttons')->rawColumns(['btn'])->toJson();
        
    }

    public function editContrato(Request $request)
    {
        if ($request->ajax()) {

            $contrato = Contrato::find($request->id);

            $contrato->status = $request->input('status');

            $contrato->update();

            $contrato_id = $contrato->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Actualización";
            $log->tabla = "Contrato";
            $log->id_tabla = $contrato_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();

            return response($contrato);
        }
    }

    public function deleteContrato(Request $request)
    {

        $contrato_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Eliminación";
        $log->tabla = "Contrato";
        $log->id_tabla = $contrato_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            if ($request->ajax()) {
                Contrato::destroy($request->id);
            }
        }
    }

    public function getBeneficiarios(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;

            $beneficiarios = DB::table("beneficiario")
                ->where("contrato_id", "=", $id)
                ->get();

            $countBeneficiarios = DB::table("beneficiario")
                ->where("contrato_id", "=", $id)
                ->count();

            return response(["beneficiarios" => $beneficiarios, "countBeneficiarios" => $countBeneficiarios]);
        }
    }

    public function getClave(Request $request)
    {
        $clave = DB::table('users')->where("id", "=", auth()->user()->id)->first();

            if (\Hash::check($request->clave, $clave->password)) {
                return response("success");
            }else{
                return response("error");
            }
    }

    public function editStatus(Request $request)
    {
        $contrato = Contrato::find($request->id);

        $contrato->status = $request->status;

        $contrato->update();

        return response($contrato);
    }
}