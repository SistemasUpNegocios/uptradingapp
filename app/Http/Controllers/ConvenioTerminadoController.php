<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Cliente;
use App\Models\BeneficiarioConvenio;
use App\Models\Convenio;
use App\Models\Log;
use App\Models\Oficina;
use App\Models\Notificacion;
use App\Models\PagoPSConvenio;
use App\Models\Ps;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ConvenioTerminadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_gold || auth()->user()->is_ps_bronze || auth()->user()->is_ps_diamond || auth()->user()->is_cliente){
            $codigo = session('codigo_oficina');
            $numeroCliente = "MXN-" . $codigo . "-";

            $ps = Ps::select()->orderBy("apellido_p")->where('codigoPS', 'like', "$codigo%")->get();
            $clientes = Cliente::select()->orderBy("apellido_p")->where("codigoCliente", "like", "%$numeroCliente%")->get();
            $bancos = Banco::all();

            $data = array(
                "lista_ps" => $ps,
                "clientes" => $clientes,
                "bancos" => $bancos,
            );

            return response()->view('convenioterminado.show', $data, 200);
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getConvenio()
    {

        $psid = session('psid');
        $clienteid = session('clienteid');
        $codigo = session('codigo_oficina');

        $convenio = DB::table('convenio')
            ->join('ps', 'ps.id', '=', 'convenio.ps_id')
            ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
            ->join('banco', 'banco.id', '=', 'convenio.banco_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->select(DB::raw("convenio.id, convenio.folio, convenio.monto, convenio.monto_letra, convenio.firma, convenio.fecha_inicio, convenio.fecha_fin, convenio.fecha_carga, convenio.capertura, convenio.cmensual, convenio.ctrimestral, convenio.status, convenio.status_oficina, convenio.numerocuenta, convenio.loggin, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, banco.id AS banco_id"))
            ->where(function ($query) {
                $query->where("convenio.status", "Finiquitado")
                ->orWhere("convenio.status", "Cancelado");
            })
            ->orderBy("convenio.id", "desc")
            ->get();

        return datatables()->of($convenio)->addColumn('btn', 'convenioterminado.buttons')->rawColumns(['btn'])->toJson();
    }

    public function editConvenio(Request $request)
    {
        if ($request->ajax()) {

            $convenio = Convenio::find($request->id);
            $convenio->status = $request->status;
            $convenio->update();

            $convenio_id = $convenio->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;
            $log->tipo_accion = "Actualización";
            $log->tabla = "Convenio";
            $log->id_tabla = $convenio_id;
            $log->bitacora_id = $bitacora_id;
            $log->save();

            return response($convenio);
        }
    }

    public function deleteConvenio(Request $request)
    {
        $convenio_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Eliminación";
        $log->tabla = "Convenio";
        $log->id_tabla = $convenio_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            if ($request->ajax()) {
                Convenio::destroy($request->id);
            }
        }
    }

    public function validateClave(Request $request)
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
        $convenio = Convenio::find($request->id);
        $id_user = auth()->user()->id;

        if($request->status == "Activado"){
            \Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHANNEL_ID_CONVENIOS'),
                'parse_mode' => 'HTML',
                'text' => "El convenio con folio $convenio->folio ha sido activado por Jorge"
            ]);
            
            $convenio->memo_status = "Convenio activado por id:1";
            $convenio->fecha_inicio = Carbon::now()->format('Y-m-d');
            $convenio->fecha_fin = Carbon::now()->addYear()->format('Y-m-d');

            $notificacion = new Notificacion;
            $notificacion->titulo = "Jorge activó un nuevo convenio";
            $notificacion->mensaje = "El convenio con folio $convenio->folio ha sido activado por Jorge";
            $notificacion->status = "Pendiente";
            $notificacion->user_id = 1;
            $notificacion->save();

            $notificacion = new Notificacion;
            $notificacion->titulo = "Jorge activó un nuevo convenio";
            $notificacion->mensaje = "El convenio con folio $convenio->folio ha sido activado por Jorge";
            $notificacion->status = "Pendiente";
            $notificacion->user_id = 4;
            $notificacion->save();

            $notificacion = new Notificacion;
            $notificacion->titulo = "Jorge activó un nuevo convenio";
            $notificacion->mensaje = "El convenio con folio $convenio->folio ha sido activado por Jorge";
            $notificacion->status = "Pendiente";
            $notificacion->user_id = 234;
            $notificacion->save();

            $notificacion = new Notificacion;
            $notificacion->titulo = "Jorge activó un nuevo convenio";
            $notificacion->mensaje = "El convenio con folio $convenio->folio ha sido activado por Jorge";
            $notificacion->status = "Pendiente";
            $notificacion->user_id = 235;
            $notificacion->save();

        }elseif($request->status == "Pendiente de activación"){
            $convenio->memo_status = "Convenio desactivado por id:$id_user";
        }elseif($request->status == "Finiquitado"){
            $convenio->memo_status = "Convenio finiquitado por id:$id_user";
        }elseif($request->status == "Refrendado"){
            $convenio->memo_status = "Convenio refrendado por id:$id_user";
        }

        $convenio->status = $request->status;
        $convenio->update();

        return response($convenio);
    }

    public function getPreview(Request $request)
    {
        $id = $request->id;

        $convenio = DB::table('convenio')
            ->where('id', '=', $id)
            ->get();

        return view('convenio.preview', compact('convenio'));
    }

    public function imprimirConvenio(Request $request)
    {

        $convenio = DB::table('convenio')
            ->join('ps', 'ps.id', '=', 'convenio.ps_id')
            ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
            ->join('banco', 'banco.id', '=', 'convenio.banco_id')
            ->select(DB::raw("convenio.id, convenio.folio, convenio.monto, convenio.monto_letra, convenio.firma, convenio.fecha_inicio, convenio.fecha_fin, convenio.fecha_carga, convenio.capertura, convenio.cmensual, convenio.ctrimestral, convenio.status, convenio.memo_status, convenio.numerocuenta, convenio.loggin, ps.id AS ps_id, CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, banco.nombre AS banconombre"))
            ->where('convenio.id', '=', $request->id)
            ->get();

        if(!empty($convenio[0]->memo_status)){
            $memo = explode(":", $convenio[0]->memo_status);
            $holograma_fecha = strtotime($convenio[0]->fecha_inicio);

            if (isset($memo[1])) {
                $holograma2 = $holograma_fecha."U".$convenio[0]->monto."P".$memo[1];
            }else{
                $holograma2 = "";
            }

        }else{
            $holograma2 = "";
        }

        $pdf = PDF::loadView('convenio.imprimir', ['convenio' => $convenio, 'convenio2' => $convenio, 'holograma2' => $holograma2]);

        $fecha_hoy = Carbon::now();
        $nombreDescarga = $convenio[0]->folio.'_'.$convenio[0]->clientenombre.'_'.$fecha_hoy->format('d-m-Y').'.pdf';

        $visualizacion = $pdf->stream($nombreDescarga);
        Storage::disk('convenios')->put($nombreDescarga, $visualizacion);

        return $visualizacion;
    }

    public function getFolioConvenio(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;
            $opc = $request->opc;

            if ($opc == 1) {
                $cliente = DB::table("cliente")
                    ->select("codigoCliente")
                    ->where("id", "=", $id)
                    ->get();

                $codigoCliente = $cliente[0]->codigoCliente;
                $codigoCliente = explode("-", $codigoCliente);

                $codigoCliente = $codigoCliente[2];

                $convenios = Convenio::where("cliente_id", $id)
                    ->count();

                $convenios++;

                if (strlen(strval($convenios)) == 1) {
                    $convenios = '-MAM-0' . $convenios;
                } else {
                    $convenios = '-MAM-' . $convenios;
                }

                return response($codigoCliente . $convenios . '-00', 200);
            } elseif ($opc == 2) {
                $ps = Ps::where("id", $id)
                    ->get();

                $oficina_id = $ps[0]->oficina_id;

                $oficina = Oficina::where("id", $oficina_id)
                    ->get();

                $codigo_oficina = $oficina[0]->codigo_oficina;

                return response($codigo_oficina, 200);
            }
        }
    }

    public function validateClaveOficina(Request $request)
    {
        $clave = DB::table('users')->where("id", "=", auth()->user()->id)->first();

        if (\Hash::check($request->clave, $clave->password)) {
            return response("success");
        }else{
            return response("error");
        }
    }

    public function editStatusOficina(Request $request)
    {
        $convenio = Convenio::find($request->id);
        $convenio->status_oficina = $request->status;
        $convenio->update();

        \Telegram::sendMessage([
            'chat_id' => '-1001976160071',
            'parse_mode' => 'HTML',
            'text' => "La oficina central ha autorizado la información del convenio con folio $convenio->folio para su activación."
        ]);

        $notificacion = new Notificacion;
        $notificacion->titulo = "La oficina central la autorizó información";
        $notificacion->mensaje = "La oficina central ha autorizado la información del convenio con folio $convenio->folio para su activación";
        $notificacion->status = "Pendiente";
        $notificacion->user_id = 1;
        $notificacion->save();

        $notificacion = new Notificacion;
        $notificacion->titulo = "La oficina central la autorizó información";
        $notificacion->mensaje = "La oficina central ha autorizado la información del convenio con folio $convenio->folio para su activación";
        $notificacion->status = "Pendiente";
        $notificacion->user_id = 3;
        $notificacion->save();

        return response($convenio);
    }

    public function getBeneficiarios(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;

            $beneficiarios = DB::table("beneficiario_convenio")
                ->where("convenio_id", "=", $id)
                ->get();

            $countBeneficiarios = DB::table("beneficiario_convenio")
                ->where("convenio_id", "=", $id)
                ->count();

            return response(["beneficiarios" => $beneficiarios, "countBeneficiarios" => $countBeneficiarios]);
        }
    }
}
