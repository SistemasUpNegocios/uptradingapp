<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Cliente;
use App\Models\Convenio;
use App\Models\IncrementoConvenio;
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


class IncrementoConvenioController extends Controller
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

            $data = array(
                "lista_ps" => $ps,
                "clientes" => $clientes,
            );

            return response()->view('incrementoconvenio.show', $data, 200);
        }else{
            return redirect()->to('/admin/dashboard');
        }

    }

    public function getConvenioUsuario(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;

            $convenio = Convenio::where('cliente_id', $id)->get();

            return response($convenio);
        }

    }

    public function getConvenio()
    {

        $psid = session('psid');
        $clienteid = session('clienteid');
        $codigo = session('codigo_oficina');

        if (auth()->user()->is_ps_gold || auth()->user()->is_ps_bronze) {
            $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();            
            $psid = $ps_cons->id;
        }

        $cliente_con = Cliente::select()->where("correo_institucional", auth()->user()->correo)->first();
        if (strlen($cliente_con) > 0) {
            $clienteid = $cliente_con->id;

            $incremento_convenio = DB::table('incremento_convenio')
                ->join('convenio', "convenio.id", "=", "incremento_convenio.convenio_id")
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->select(DB::raw("incremento_convenio.id, incremento_convenio.folio, incremento_convenio.firma, incremento_convenio.fecha_inicio_incremento, incremento_convenio.status, incremento_convenio.status_oficina, incremento_convenio.cantidad_incremento, incremento_convenio.cantidad_incrementoletra, incremento_convenio.convenio_id as convenioid, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre"))
                ->where(function ($query) use ($psid, $clienteid) {
                    $query->where("ps.id", "like", $psid)
                    ->orWhere("cliente.id", "like", $clienteid);
                })
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->get();
        }else{
            $incremento_convenio = DB::table('incremento_convenio')
                ->join('convenio', "convenio.id", "=", "incremento_convenio.convenio_id")
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->select(DB::raw("incremento_convenio.id, incremento_convenio.folio, incremento_convenio.firma, incremento_convenio.fecha_inicio_incremento, incremento_convenio.status, incremento_convenio.status_oficina, incremento_convenio.cantidad_incremento, incremento_convenio.cantidad_incrementoletra, incremento_convenio.convenio_id as convenioid, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre"))
                ->where("ps.id", "like", $psid)
                ->where("cliente.id", "like", $clienteid)
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->get();
        }

        if (auth()->user()->is_cliente) {
            $clienteid = $cliente_con->id;
            $incremento_convenio = DB::table('incremento_convenio')
                ->join('convenio', "convenio.id", "=", "incremento_convenio.convenio_id")
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->select(DB::raw("incremento_convenio.id, incremento_convenio.folio, incremento_convenio.firma, incremento_convenio.fecha_inicio_incremento, incremento_convenio.status, incremento_convenio.status_oficina, incremento_convenio.cantidad_incremento, incremento_convenio.cantidad_incrementoletra, incremento_convenio.convenio_id as convenioid, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre"))
                ->where("ps.id", "like", $psid)
                ->where("cliente.id", "like", $clienteid)
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->get();
        }

        return datatables()->of($incremento_convenio)->addColumn('btn', 'incrementoconvenio.buttons')->rawColumns(['btn'])->toJson();
    }

    public function getConvenioActivado()
    {
        
        $psid = session('psid');
        $clienteid = session('clienteid');
        $codigo = session('codigo_oficina');

        if (auth()->user()->is_ps_gold) {
            $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();            
            $psid = $ps_cons->id;
        }

        $cliente_con = Cliente::select()->where("correo_institucional", auth()->user()->correo)->first();
        if (strlen($cliente_con) > 0) {
            $clienteid = $cliente_con->id;

            $incremento_convenio = DB::table('incremento_convenio')
                ->join('convenio', "convenio.id", "=", "incremento_convenio.convenio_id")
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->select(DB::raw("incremento_convenio.id, incremento_convenio.folio, incremento_convenio.firma, incremento_convenio.fecha_inicio_incremento, incremento_convenio.status, incremento_convenio.status_oficina, incremento_convenio.cantidad_incremento, incremento_convenio.cantidad_incrementoletra, incremento_convenio.convenio_id as convenioid, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre"))
                ->where(function ($query) use ($psid, $clienteid) {
                    $query->where("ps.id", "like", $psid)
                    ->orWhere("cliente.id", "like", $clienteid);
                })
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->where('incremento_convenio.status', 'Activado')
                ->get();
        }else{
            $incremento_convenio = DB::table('incremento_convenio')
                ->join('convenio', "convenio.id", "=", "incremento_convenio.convenio_id")
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->select(DB::raw("incremento_convenio.id, incremento_convenio.folio, incremento_convenio.firma, incremento_convenio.fecha_inicio_incremento, incremento_convenio.status, incremento_convenio.status_oficina, incremento_convenio.cantidad_incremento, incremento_convenio.cantidad_incrementoletra, incremento_convenio.convenio_id as convenioid, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre"))
                ->where("ps.id", "like", $psid)
                ->where("cliente.id", "like", $clienteid)
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->where('incremento_convenio.status', 'Activado')
                ->get();
        }

        if (auth()->user()->is_cliente) {
            $clienteid = $cliente_con->id;
            $incremento_convenio = DB::table('incremento_convenio')
                ->join('convenio', "convenio.id", "=", "incremento_convenio.convenio_id")
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->select(DB::raw("incremento_convenio.id, incremento_convenio.folio, incremento_convenio.firma, incremento_convenio.fecha_inicio_incremento, incremento_convenio.status, incremento_convenio.status_oficina, incremento_convenio.cantidad_incremento, incremento_convenio.cantidad_incrementoletra, incremento_convenio.convenio_id as convenioid, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre"))
                ->where("ps.id", "like", $psid)
                ->where("cliente.id", "like", $clienteid)
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->where('incremento_convenio.status', 'Activado')
                ->get();
        }

        return datatables()->of($incremento_convenio)->addColumn('btn', 'incrementoconvenio.buttons')->rawColumns(['btn'])->toJson();
    }

    public function getConvenioPendiente()
    {
        
        $psid = session('psid');
        $clienteid = session('clienteid');
        $codigo = session('codigo_oficina');

        if (auth()->user()->is_ps_gold || auth()->user()->is_ps_bronze) {
            $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();            
            $psid = $ps_cons->id;
        }

        $cliente_con = Cliente::select()->where("correo_institucional", auth()->user()->correo)->first();
        if (strlen($cliente_con) > 0) {
            $clienteid = $cliente_con->id;

            $incremento_convenio = DB::table('incremento_convenio')
                ->join('convenio', "convenio.id", "=", "incremento_convenio.convenio_id")
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->select(DB::raw("incremento_convenio.id, incremento_convenio.folio, incremento_convenio.firma, incremento_convenio.fecha_inicio_incremento, incremento_convenio.status, incremento_convenio.status_oficina, incremento_convenio.cantidad_incremento, incremento_convenio.cantidad_incrementoletra, incremento_convenio.convenio_id as convenioid, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre"))
                ->where(function ($query) use ($psid, $clienteid) {
                    $query->where("ps.id", "like", $psid)
                    ->orWhere("cliente.id", "like", $clienteid);
                })
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->where('incremento_convenio.status', 'Pendiente de activación')
                ->get();
        }else{
            $incremento_convenio = DB::table('incremento_convenio')
                ->join('convenio', "convenio.id", "=", "incremento_convenio.convenio_id")
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->select(DB::raw("incremento_convenio.id, incremento_convenio.folio, incremento_convenio.firma, incremento_convenio.fecha_inicio_incremento, incremento_convenio.status, incremento_convenio.status_oficina, incremento_convenio.cantidad_incremento, incremento_convenio.cantidad_incrementoletra, incremento_convenio.convenio_id as convenioid, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre"))
                ->where("ps.id", "like", $psid)
                ->where("cliente.id", "like", $clienteid)
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->where('incremento_convenio.status', 'Pendiente de activación')
                ->get();
        }

        if (auth()->user()->is_cliente) {
            $clienteid = $cliente_con->id;
            $incremento_convenio = DB::table('incremento_convenio')
                ->join('convenio', "convenio.id", "=", "incremento_convenio.convenio_id")
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->select(DB::raw("incremento_convenio.id, incremento_convenio.folio, incremento_convenio.firma, incremento_convenio.fecha_inicio_incremento, incremento_convenio.status, incremento_convenio.status_oficina, incremento_convenio.cantidad_incremento, incremento_convenio.cantidad_incrementoletra, incremento_convenio.convenio_id as convenioid, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre"))
                ->where("ps.id", "like", $psid)
                ->where("cliente.id", "like", $clienteid)
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->where('incremento_convenio.status', 'Pendiente de activación')
                ->get();
        }

        return datatables()->of($incremento_convenio)->addColumn('btn', 'incrementoconvenio.buttons')->rawColumns(['btn'])->toJson();
    }

    public function addConvenio(Request $request)
    {
        if ($request->ajax()) {

            $request->validate([
                'folio' => 'required|unique:incremento_convenio',
                'firma' => 'required',
                'fecha_inicio' => 'required|date',
                'status' => 'required',
                'ps_id' => 'required',
                'cliente_id' => 'required',
                'monto_incremento' => 'required',
                'montoincremento_letra' => 'required',
                'convenio_id' => 'required',
            ]);

            $incremento_convenio = new IncrementoConvenio;
            $incremento_convenio->folio = $request->folio;
            $incremento_convenio->firma = $request->firma;
            $incremento_convenio->fecha_inicio_incremento = $request->fecha_inicio;
            $incremento_convenio->fecha_carga = date('Y-m-d H:i:s', strtotime("now"));
            $incremento_convenio->status = $request->status;
            $incremento_convenio->cantidad_incremento = $request->monto_incremento;
            $incremento_convenio->cantidad_incrementoletra = $request->montoincremento_letra;
            $incremento_convenio->convenio_id  = $request->convenio_id;
            if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
                $incremento_convenio->status_oficina = "Activado";
            }else{
                $incremento_convenio->status_oficina = "Pendiente";
            }
            $incremento_convenio->save();

            $convenio_id = $incremento_convenio->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;
            $log->tipo_accion = "Inserción";
            $log->tabla = "IncrementoConvenio";
            $log->id_tabla = $convenio_id;
            $log->bitacora_id = $bitacora_id;
            $log->save();

            if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
                \Telegram::sendMessage([
                    'chat_id' => '-1001976160071',
                    'parse_mode' => 'HTML',
                    'text' => "Se generó un incremento de convenio con folio: $request->folio. Desde oficina central, a espera de tu activación."
                ]);

                $notificacion = new Notificacion;
                $notificacion->titulo = "Nuevo incremento de convenio";
                $notificacion->mensaje = "El incremento de convenio con folio $request->folio ha sido generado";
                $notificacion->status = "Pendiente";
                $notificacion->user_id = 3;
                $notificacion->save();

            }else if (auth()->user()->is_ps_diamond) {
                $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();            
                $oficina = Oficina::find($ps_cons->oficina_id);
                $oficina = $oficina->ciudad;

                \Telegram::sendMessage([
                    'chat_id' => env('TELEGRAM_CHANNEL_ID_CONVENIOS'),
                    'parse_mode' => 'HTML',
                    'text' => "El incremento de convenio con folio $request->folio ha sido creado desde la oficina de $oficina"
                ]);

                $notificacion = new Notificacion;
                $notificacion->titulo = "La oficina de $oficina generó un nuevo incremento de convenio";
                $notificacion->mensaje = "El incremento de convenio con folio $request->folio ha sido generado desde la oficina de $oficina";
                $notificacion->status = "Pendiente";
                $notificacion->user_id = 1;
                $notificacion->save();

                $notificacion = new Notificacion;
                $notificacion->titulo = "La oficina de $oficina generó un nuevo incremento de convenio";
                $notificacion->mensaje = "El incremento de convenio con folio $request->folio ha sido generado desde la oficina de $oficina";
                $notificacion->status = "Pendiente";
                $notificacion->user_id = 234;
                $notificacion->save();

                $notificacion = new Notificacion;
                $notificacion->titulo = "La oficina de $oficina generó un nuevo incremento de convenio";
                $notificacion->mensaje = "El incremento de convenio con folio $request->folio ha sido generado desde la oficina de $oficina";
                $notificacion->status = "Pendiente";
                $notificacion->user_id = 235;
                $notificacion->save();
            }

            return response($incremento_convenio);
        }
    }

    public function editConvenio(Request $request)
    {
        if ($request->ajax()) {

            $request->validate([
                'folio' => 'required',
                'firma' => 'required',
                'fecha_inicio' => 'required|date',
                'status' => 'required',
                'ps_id' => 'required',
                'cliente_id' => 'required',
                'monto_incremento' => 'required',
                'montoincremento_letra' => 'required',
                'convenio_id' => 'required',
            ]);

            $incremento_convenio = IncrementoConvenio::find($request->id);
            $incremento_convenio->folio = $request->folio;
            $incremento_convenio->firma = $request->firma;
            $incremento_convenio->fecha_inicio_incremento = $request->fecha_inicio;
            $incremento_convenio->status = $request->status;
            $incremento_convenio->cantidad_incremento = $request->monto_incremento;
            $incremento_convenio->cantidad_incrementoletra = $request->montoincremento_letra;
            $incremento_convenio->convenio_id  = $request->convenio_id;
            $incremento_convenio->update();

            $convenio_id = $incremento_convenio->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;
            $log->tipo_accion = "Actualización";
            $log->tabla = "IncrementoConvenio";
            $log->id_tabla = $convenio_id;
            $log->bitacora_id = $bitacora_id;
            $log->save();

            return response($incremento_convenio);
        }
    }

    public function deleteConvenio(Request $request)
    {
        $convenio_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Eliminación";
        $log->tabla = "IncrementoConvenio";
        $log->id_tabla = $convenio_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            if ($request->ajax()) {
                IncrementoConvenio::destroy($request->id);
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
        $incremento_convenio = IncrementoConvenio::find($request->id);
        $id_user = auth()->user()->id;

        if($request->status == "Activado"){
            \Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHANNEL_ID_CONVENIOS'),
                'parse_mode' => 'HTML',
                'text' => "El incremento del convenio con folio $incremento_convenio->folio ha sido activado por Jorge"
            ]);
            
            $incremento_convenio->memo_status = "Incremento de convenio activado por id:1";

            $notificacion = new Notificacion;
            $notificacion->titulo = "Jorge activó un nuevo incremento de convenio";
            $notificacion->mensaje = "El incremento de convenio con folio $incremento_convenio->folio ha sido activado";
            $notificacion->status = "Pendiente";
            $notificacion->user_id = 1;
            $notificacion->save();

            $notificacion = new Notificacion;
            $notificacion->titulo = "Jorge activó un nuevo incremento del convenio";
            $notificacion->mensaje = "El incremento de convenio con folio $incremento_convenio->folio ha sido activado por Jorge";
            $notificacion->status = "Pendiente";
            $notificacion->user_id = 4;
            $notificacion->save();

            $notificacion = new Notificacion;
            $notificacion->titulo = "Jorge activó un nuevo incremento del convenio";
            $notificacion->mensaje = "El incremento de convenio con folio $incremento_convenio->folio ha sido activado por Jorge";
            $notificacion->status = "Pendiente";
            $notificacion->user_id = 234;
            $notificacion->save();

            $notificacion = new Notificacion;
            $notificacion->titulo = "Jorge activó un nuevo incremento del convenio";
            $notificacion->mensaje = "El incremento de convenio con folio $incremento_convenio->folio ha sido activado por Jorge";
            $notificacion->status = "Pendiente";
            $notificacion->user_id = 235;
            $notificacion->save();

        }elseif($request->status == "Pendiente de activación"){
            $incremento_convenio->memo_status = "Incremento del convenio desactivado por id:$id_user";
        }

        $incremento_convenio->status = $request->status;
        $incremento_convenio->update();

        return response($incremento_convenio);
    }

    public function getPreview(Request $request)
    {
        $id = $request->id;

        $convenio = DB::table('incremento_convenio')
            ->where('id', '=', $id)
            ->get();

        return view('incrementoconvenio.preview', compact('convenio'));
    }

    public function imprimirConvenio(Request $request)
    {

        $incremento_convenio = DB::table('incremento_convenio')
            ->join('convenio', 'convenio.id', '=', 'incremento_convenio.convenio_id')
            ->join('ps', 'ps.id', '=', 'convenio.ps_id')
            ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
            ->select(DB::raw("incremento_convenio.id, incremento_convenio.folio, incremento_convenio.firma, incremento_convenio.fecha_inicio_incremento, incremento_convenio.status, incremento_convenio.cantidad_incremento, incremento_convenio.cantidad_incrementoletra, incremento_convenio.convenio_id as convenioid, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, convenio.fecha_inicio, convenio.monto, convenio.folio AS folioinicio"))
            ->where('incremento_convenio.id', '=', $request->id)
            ->get();

        if(!empty($incremento_convenio[0]->memo_status)){
            $memo = explode(":", $incremento_convenio[0]->memo_status);
            $holograma_fecha = strtotime($incremento_convenio[0]->fecha_inicio);

            if (isset($memo[1])) {
                $holograma2 = $holograma_fecha."U".$incremento_convenio[0]->monto."P".$memo[1];
            }else{
                $holograma2 = "";
            }

        }else{
            $holograma2 = "";
        }

        $pdf = PDF::loadView('incrementoconvenio.imprimir', ['convenio' => $incremento_convenio, 'convenio2' => $incremento_convenio, 'holograma2' => $holograma2]);

        $fecha_hoy = Carbon::now();
        $nombreDescarga = $incremento_convenio[0]->folio.'_'.$incremento_convenio[0]->clientenombre.'_'.$fecha_hoy->format('d-m-Y').'.pdf';

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

                $id_convenios = DB::table("convenio")->select("id")->where("cliente_id", "=", $id)->get();

                $cliente = DB::table("cliente")->select("codigoCliente")->where("id", "=", $id)->get();
                $codigoCliente = $cliente[0]->codigoCliente;
                $codigoCliente = explode("-", $codigoCliente);
                $codigoCliente = $codigoCliente[2];

                $convenios = Convenio::where("cliente_id", $id)->count();

                foreach ($id_convenios as $id_convenio) {
                    $incremento_convenio = IncrementoConvenio::where("convenio_id", $id_convenio->id)->count();
                    $convenios = $convenios + $incremento_convenio;
                }

                $convenios++;

                $convenios = str_pad($convenios, 2, "0", STR_PAD_LEFT);
                $convenios = "-MAM-$convenios";

                return response($codigoCliente . $convenios . '-00', 200);
            } elseif ($opc == 2) {
                $ps = Ps::where("id", $id)->get();

                $oficina_id = $ps[0]->oficina_id;
                $oficina = Oficina::where("id", $oficina_id)->get();
                $codigo_oficina = $oficina[0]->codigo_oficina;

                return response($codigo_oficina, 200);
            } elseif ($opc == 3) {
                $convenio = DB::table("convenio")->select("folio")->where("cliente_id", $id)->orderBy("id", "DESC")->first();
                $convenio_completo = DB::table("convenio")->select()->where("id", $request->id_convenio)->first();

                $data = array(
                    "folio" => $convenio->folio,
                    "convenio" => $convenio_completo
                );

                return response()->json($data);
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
        $incremento_convenio = IncrementoConvenio::find($request->id);
        $incremento_convenio->status_oficina = $request->status;
        $incremento_convenio->update();

        \Telegram::sendMessage([
            'chat_id' => '-1001976160071',
            'parse_mode' => 'HTML',
            'text' => "La oficina central ha autorizado la información del convenio con folio $convenio->folio para su activación."
        ]);

        $notificacion = new Notificacion;
        $notificacion->titulo = "La oficina central autorizó la información";
        $notificacion->mensaje = "La oficina central ha autorizado la información del incremento de convenio con folio $incremento_convenio->folio para su activación";
        $notificacion->status = "Pendiente";
        $notificacion->user_id = 1;
        $notificacion->save();

        $notificacion = new Notificacion;
        $notificacion->titulo = "La oficina central autorizó la información";
        $notificacion->mensaje = "La oficina central ha autorizado la información del incremento de convenio con folio $incremento_convenio->folio para su activación";
        $notificacion->status = "Pendiente";
        $notificacion->user_id = 3;
        $notificacion->save();

        return response($incremento_convenio);
    }

}