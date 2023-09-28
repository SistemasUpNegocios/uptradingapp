<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Mail\ReportesEmail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
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

        if(empty($serie)){
            $serie = "00";
        }else{
            $serie = str_pad($serie->serie, 2, "0", STR_PAD_LEFT);
        }

        $fecha_inicio = Carbon::parse($request->fecha_inicio)->formatLocalized('%d de %B de %Y');
        $request->fecha_aumento == '' ? $fecha_aumento = 'NA' : $fecha_aumento = Carbon::parse($request->fecha_aumento)->formatLocalized('%d de %B de %Y');

        $data = array(
            "convenio_id" => $request->id,
            "folio" => $request->folio,
            "loggin" => $request->loggin,
            "cliente" => $request->cliente,
            "fecha_inicio" => $fecha_inicio,
            "fecha_fin" => $request->fecha_fin,
            "capital" => number_format($request->capital, 2),
            "aumento" => number_format($request->aumento, 2),
            "fecha_aumento" => $fecha_aumento,
            "balance" => number_format($request->balance, 2),
            "flotante" => number_format($request->flotante, 2),
            "retiro" => number_format($request->retiro, 2),
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

    public function import(Request $request) 
    {
        $file = $request->file('file');

        $reader = new Xlsx();
        $excel = $reader->load($file);
        $numeroFilas = $excel->setActiveSheetIndex(0)->getHighestRow();
        
        for ($i = 2; $i <= $numeroFilas; $i++) { 
            $fecha_inicio = Carbon::instance(Date::excelToDateTimeObject($excel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()))->formatLocalized('%d de %B de %Y');
            $periodo = $excel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
            $periodo == '' ? $periodo = 0 : $periodo = $periodo;
            $loggin = $excel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
            $cliente = $excel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
            $correo = $excel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
            $capital = number_format($excel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue(), 2);
            $aumento = number_format($excel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue(), 2);
            $excel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue() == '' ? $fecha_aumento = 'NA' : $fecha_aumento = Carbon::instance(Date::excelToDateTimeObject($excel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue()))->formatLocalized('%d de %B de %Y');
            $balance = number_format($excel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue(), 2);
            $flotante = number_format($excel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue(), 2);
            $retiro = number_format($excel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue(), 2);
            $fecha_impresion = Carbon::instance(Date::excelToDateTimeObject($excel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue()))->formatLocalized('%d de %B de %Y');

            if ($fecha_inicio != '' && $periodo != '' && $loggin != '' && $cliente != '' && $correo != '' && $capital != '' && $aumento != '' && $fecha_aumento != '' && $balance != '' && $flotante != '' && $retiro != '' && $fecha_impresion != '') {
                $convenio = Convenio::where("loggin", $loggin)->first();
                $folio = $convenio->folio;

                $data = array(
                    "folio" => $folio,
                    "loggin" => $loggin,
                    "cliente" => $cliente,
                    "fecha_inicio" => $fecha_inicio,
                    "capital" => $capital,
                    "aumento" => $aumento,
                    "fecha_aumento" => $fecha_aumento,
                    "balance" => $balance,
                    "flotante" => $flotante,
                    "retiro" => $retiro,
                    "fecha_impresion" => $fecha_impresion,
                    "serie" => "($periodo/12)",
                );

                $fecha = Carbon::now()->formatLocalized('%d de %B de %Y');

                $pdf = PDF::loadView('cuentasmam.pdf', $data);

                $nombreDescarga = "MAM $cliente $fecha.pdf";
                $visualizacion = $pdf->stream($nombreDescarga);

                Storage::disk('reportes')->put($nombreDescarga, $visualizacion);

                Mail::to($correo)->send(new ReportesEmail($cliente, $nombreDescarga));
            }
        }

        return response($numeroFilas);
    }
}