<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Mail\ReportesEmail;
use App\Models\BeneficiarioConvenio;
use App\Models\IncrementoConvenio;
use App\Models\PagoPSConvenio;
use App\Models\Notificacion;
use App\Models\Convenio;
use App\Models\Cliente;
use App\Models\Oficina;
use App\Models\Banco;
use App\Models\Log;
use App\Models\Ps;
use Carbon\Carbon;

class CuentaMamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
            return response()->view('cuentasmam.show');
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getCuentasMam()
    {

        $convenio = DB::table('convenio')
            ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
            ->select(DB::raw("convenio.id, convenio.folio, convenio.loggin, convenio.monto, convenio.fecha_inicio, convenio.fecha_fin, convenio.fecha_carga, CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, cliente.correo_personal"))
            ->where("convenio.status", "Activado")
            ->orderBy("cliente.id", "desc")
            ->get();

        return datatables()->of($convenio)->addColumn('btn', 'cuentasmam.buttons')->rawColumns(['btn'])->toJson();
    }

    public function generarCuentaMam(Request $request)
    {

        $fecha_actual = Carbon::now()->format("Y-m");
        $serie = PagoPSConvenio::where("convenio_id", $request->id)->where("fecha_pago", "like", "$fecha_actual%")->first();
        $serie = str_pad($serie->serie, 2, "0", STR_PAD_LEFT);

        $aumento = IncrementoConvenio::where("convenio_id", $request->id)->get();
        if(count($aumento) > 0){
            $aumento = $aumento[0]->cantidad_incremento;
        }else{
            $aumento = 0;
        }

        $fecha_inicio = Carbon::parse($request->fecha_inicio)->formatLocalized('%d de %B de %Y');

        $data = array(
            "convenio_id" => $request->id,
            "folio" => $request->folio,
            "cliente" => $request->cliente,
            "fecha_inicio" => $fecha_inicio,
            "fecha_fin" => $request->fecha_fin,
            "capital" => $request->capital,
            "aumento" => $aumento,
            "balance" => $request->balance,
            "flotante" => $request->flotante,
            "retiro" => $request->retiro,
            "fecha_impresion" => Carbon::now()->formatLocalized('%d de %B de %Y'),
            "serie" => "($serie/12)",
        );

        $fecha = Carbon::now()->formatLocalized('%d de %B de %Y');

        $pdf = PDF::loadView('cuentasmam.pdf', $data);

        $nombreDescarga = "MAM $request->cliente $fecha.pdf";
        $visualizacion = $pdf->stream($nombreDescarga);
            
        Storage::disk('reportes')->put($nombreDescarga, $visualizacion);

        Mail::to($request->correo)->send(new ReportesEmail($request->cliente, $nombreDescarga));

        return response("success");
    }
}
