<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\IntencionInversion;
use App\Models\Log;
use App\Models\TipoContrato;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\IntencionEmail;

class IntencionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_gold){
            $tipos = TipoContrato::all();
            $data = array(
                "lista_tipos" => $tipos,
            );
            return response()->view('intencioninversion.show', $data, 200);
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getOpc()
    {
        $tipos = TipoContrato::all();
        $data = array(
            "lista_tipos" => $tipos,
        );
        return response()->view('intencioninversion.tipo', $data, 200);
    }

    public function getOpcDividir()
    {
        $tipos = TipoContrato::all();
        $data = array(
            "lista_tipos" => $tipos,
        );
        return response()->view('intencioninversion.tipodividir', $data, 200);
    }

    public function reporteIntencion(Request $request)
    {
        if ($request->isMethod('post')) {
            $intencionInversion = new IntencionInversion;

            $nombre = $request->input('nombre');
            $intencionInversion->nombre = $nombre;

            $telefono = $request->input('telefono');
            $intencionInversion->telefono = $telefono;

            $email = $request->input('email');
            $intencionInversion->email = $email;

            $inversion = $request->input('inversion');
            $intencionInversion->inversion_mxn = $inversion;

            $inversion_us = $request->input('inversion_us');
            $intencionInversion->inversion_usd = $inversion_us;

            $tipo_cambio = $request->input('tipo_cambio');
            $intencionInversion->tipo_cambio = $tipo_cambio;

            $fecha_inicio = $request->input('fecha_inicio');
            $intencionInversion->fecha_inicio = $fecha_inicio;

            $fecha_renovacion = $request->input('fecha_renovacion');
            $intencionInversion->fecha_renovacion = $fecha_renovacion;

            $fecha_pago = $request->input('fecha_pago');
            $intencionInversion->fecha_pago = $fecha_pago;

            $tipo_id = $request->input('tipo_id');
            $tipo_id2 = 0;
            $tipo_contrato2 = 0;
            $rendimiento2 = 0;
            $porcentaje = 0;
            $porcentaje2 = 0;
            $inversionMXN1 = 0;
            $inversionUSD1 = 0;
            $inversionMXN2 = 0;
            $inversionUSD2 = 0;

            if ($request->has('tipo_id2')) {
                if ($request->filled('tipo_id2')) {
                    $tipo_id2 = $request->input('tipo_id2');

                    $sql2 = DB::table("tipo_contrato")
                    ->where("id", "=", $tipo_id2)
                    ->get();
    
                    $tipo_contrato2 = $sql2[0]->tipo;
                    $intencionInversion->tipo_2 = $tipo_contrato2;
                    $rendimiento2 = $sql2[0]->rendimiento;
                    $intencionInversion->porcentaje_tipo_2 = $rendimiento2;
                }
            }

            if ($request->has('porcentaje_inversion_2')) {
                if ($request->filled('porcentaje_inversion_2')) {
                    $porcentaje = $request->input('porcentaje_inversion_1');
                    $porcentaje2 = $request->input('porcentaje_inversion_2');
                    $intencionInversion->porcentaje_inversion_1 = $porcentaje;
                    $intencionInversion->porcentaje_inversion_2 = $porcentaje2;
                }
            } else {
                $intencionInversion->porcentaje_inversion_1 = 100;
            }

            if ($request->has('inversionMXN1')) {
                if ($request->filled('inversionMXN1')) {
                    $inversionMXN1 = $request->input('inversionMXN1');
                }
            }

            if ($request->has('inversionMXN2')) {
                if ($request->filled('inversionMXN2')) {
                    $inversionMXN2 = $request->input('inversionMXN2');
                }
            }

            if ($request->has('inversionUSD1')) {
                if ($request->filled('inversionUSD1')) {
                    $inversionUSD1 = $request->input('inversionUSD1');
                }
            }

            if ($request->has('inversionUSD2')) {
                if ($request->filled('inversionUSD2')) {
                    $inversionUSD2 = $request->input('inversionUSD2');
                }
            }

            $sql = DB::table("tipo_contrato")
                ->where("id", "=", $tipo_id)
                ->get();

            $tipo_contrato = $sql[0]->tipo;
            $intencionInversion->tipo_1 = $tipo_contrato;
            $rendimiento = $sql[0]->rendimiento;
            $intencionInversion->porcentaje_tipo_1 = $rendimiento;

            if ($intencionInversion->save()) {
                $id = $intencionInversion->id;
                return view('intencioninversion.preview', [
                    'id' => $id,
                ]);
            }
        }
    }

    public function pdfIntencion(Request $request)
    {
        if ($request->isMethod('get')) {
            $id = $request->id;

            $data = [
                'id' => $id,
            ];

            $bitacora_id = session('bitacora_id');

            $log = new Log;
    
            $log->tipo_accion = "Inserción";
            $log->tabla = "Intención de inversión";
            $log->bitacora_id = $bitacora_id;
    
            $log->save();

            $pdf = PDF::loadView('intencioninversion.pdf', $data);

            $query = IntencionInversion::where('id', $id)->get();
            $fecha_inicio = $query[0]->fecha_inicio;
            $nombre = $query[0]->nombre;
            $fecha = Carbon::parse($fecha_inicio)->formatLocalized('%d de %B de %Y');
            $correo = $query[0]->email;

            $nombreDescarga = "Intención de inversión ".$fecha_inicio." ".$nombre."_".$request->id.".pdf";
            $visualizacion = $pdf->stream($nombreDescarga);
            
            Storage::disk('intencion')->put($nombreDescarga, $visualizacion);

            Mail::to($correo)->send(new IntencionEmail($nombre, $fecha, $nombreDescarga));

            return $visualizacion;
        }
    }

    public function getClientes()
    {

        $codigo = session('codigo_oficina');
        $numeroCliente = "MXN-".$codigo."-";

        
        $clientes = DB::table("cliente")
        ->orderBy('apellido_p')
        ->where('codigoCliente', 'like', "$numeroCliente%")
        ->get();

        return view('intencioninversion.clientes', ['clientes' => $clientes]);
    }

    public function getDatosCliente(Request $request)
    {
        $id = $request->id;

        $query = Cliente::where('id', $id)->get();
        // $telefono = $query[0]->celular;

        return response($query);
    }

    public function intencion(Request $request)
    {
        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
            return view('intencioninversion.tabla');
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getIntencion(Request $request)
    {
        $intencion = IntencionInversion::all();

        return datatables()->of($intencion)->addColumn('btn', 'intencioninversion.buttons')->rawColumns(['btn'])->toJson();
    }

    public function deleteIntencion(Request $request)
    {
        if ($request->ajax()) {
            $intencion = $request->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Eliminación";
            $log->tabla = "Intención de Inversión";
            $log->id_tabla = $intencion;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {

                $intencion = IntencionInversion::find($request->id);
                $nombre = "Intención de inversión ".$intencion->fecha_inicio." ".$intencion->nombre."_".$request->id.".pdf";
                Storage::disk('intencion')->delete($nombre);

                IntencionInversion::destroy($request->id);
            }
        }
    }
}