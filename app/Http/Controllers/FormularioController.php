<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use Illuminate\Http\Request;
use App\Models\Ps;
use App\Models\Oficina;
use Illuminate\Support\Facades\DB;
use App\Models\Contrato;
use App\Models\Cliente;
use App\Models\Log;

class FormularioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {

        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_ps_gold || auth()->user()->is_ps_diamond || auth()->user()->is_ps_bronze){
            $codigo = session("codigo_oficina");
            $lista_ps = Ps::select()->where('codigoPS', 'like', "$codigo%")->get();
            return response()->view('formulario.show', compact("lista_ps"));
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getFormulario()
    {

        $psid = session('psid');
        $codigo = session('codigo_oficina');
        $numeroCliente = "MXN-" . $codigo . "-";

        if (auth()->user()->is_ps_gold || auth()->user()->is_ps_bronze) {
            $ps_cons = PS::select()->where("correo_institucional", auth()->user()->correo)->first();
            $psid = $ps_cons->id;
        }

        $formulario = Formulario::join('ps', 'ps.id', '=', 'formulario.ps_id')
            ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, formulario.id as formularioid, formulario.codigoCliente, formulario.nombre, formulario.apellido_p, formulario.apellido_m, formulario.estado_civil, formulario.fecha_nacimiento, formulario.pasaporte, formulario.ine, formulario.nacionalidad, formulario.direccion, formulario.colonia, formulario.cp, formulario.ciudad, formulario.estado, formulario.pais, formulario.celular, formulario.correo_personal, formulario.correo_institucional, formulario.ine_documento, formulario.pasaporte_documento, formulario.comprobante_domicilio, formulario.fuera_mexico, formulario.situacion_laboral, formulario.nombre_direccion, formulario.giro_empresa, formulario.puesto, formulario.sector_empresa, formulario.personas_cargo, formulario.porcentaje_acciones, formulario.monto_anio, formulario.pagina_web, formulario.ultimo_empleo, formulario.ultimo_empleador, formulario.status_anterior, formulario.monto_mensual_jubilacion, formulario.escuela_universidad, formulario.campo_facultad, formulario.especificacion_trabajo, formulario.funcion_publica, formulario.descripcion_funcion_publica, formulario.residencia, formulario.rfc, formulario.deposito_inicial, formulario.origen_dinero, formulario.ps_id"))
            ->where('formulario.codigoCliente', 'like', "$numeroCliente%")
            ->where("formulario.ps_id", 'like', $psid)
            ->orderBy('formulario.id', 'DESC')->get();

        return datatables()->of($formulario)->addColumn('btn', 'formulario.buttons')->rawColumns(['btn'])->toJson();
    }

    public function getFormularioFiltro(Request $request)
    {
        if($request->id == "todos"){
            $formulario = Formulario::join('ps', 'ps.id', '=', 'formulario.ps_id')
            ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, formulario.id as formularioid, formulario.codigoCliente, formulario.nombre, formulario.apellido_p, formulario.apellido_m, formulario.estado_civil, formulario.fecha_nacimiento, formulario.pasaporte, formulario.ine, formulario.nacionalidad, formulario.direccion, formulario.colonia, formulario.cp, formulario.ciudad, formulario.estado, formulario.pais, formulario.celular, formulario.correo_personal, formulario.correo_institucional, formulario.ine_documento, formulario.pasaporte_documento, formulario.comprobante_domicilio, formulario.fuera_mexico, formulario.situacion_laboral, formulario.nombre_direccion, formulario.giro_empresa, formulario.puesto, formulario.sector_empresa, formulario.personas_cargo, formulario.porcentaje_acciones, formulario.monto_anio, formulario.pagina_web, formulario.ultimo_empleo, formulario.ultimo_empleador, formulario.status_anterior, formulario.monto_mensual_jubilacion, formulario.escuela_universidad, formulario.campo_facultad, formulario.especificacion_trabajo, formulario.funcion_publica, formulario.descripcion_funcion_publica, formulario.residencia, formulario.rfc, formulario.deposito_inicial, formulario.origen_dinero, formulario.ps_id"))
            ->orderBy('formulario.id', 'DESC')->get();
        }else{
            $formulario = Formulario::join('ps', 'ps.id', '=', 'formulario.ps_id')
            ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, formulario.id as formularioid, formulario.codigoCliente, formulario.nombre, formulario.apellido_p, formulario.apellido_m, formulario.estado_civil, formulario.fecha_nacimiento, formulario.pasaporte, formulario.ine, formulario.nacionalidad, formulario.direccion, formulario.colonia, formulario.cp, formulario.ciudad, formulario.estado, formulario.pais, formulario.celular, formulario.correo_personal, formulario.correo_institucional, formulario.ine_documento, formulario.pasaporte_documento, formulario.comprobante_domicilio, formulario.fuera_mexico, formulario.situacion_laboral, formulario.nombre_direccion, formulario.giro_empresa, formulario.puesto, formulario.sector_empresa, formulario.personas_cargo, formulario.porcentaje_acciones, formulario.monto_anio, formulario.pagina_web, formulario.ultimo_empleo, formulario.ultimo_empleador, formulario.status_anterior, formulario.monto_mensual_jubilacion, formulario.escuela_universidad, formulario.campo_facultad, formulario.especificacion_trabajo, formulario.funcion_publica, formulario.descripcion_funcion_publica, formulario.residencia, formulario.rfc, formulario.deposito_inicial, formulario.origen_dinero, formulario.ps_id"))
            ->where("formulario.ps_id", $request->id)
            ->orderBy('formulario.id', 'DESC')->get();
        }

        return datatables()->of($formulario)->addColumn('btn', 'formulario.buttons')->rawColumns(['btn'])->toJson();
    }

    public function addFormulario(Request $request)
    {
        if ($request->ajax()) {

            $request->validate([
                'codigocliente' => 'required|unique:formulario',
                'nombre' => 'required|string',
                'apellido_p' => 'required|string',
                'correo_institucional' => 'required|email|unique:formulario',
                'ps_id' => 'required',
            ]);

            $formulario = new Formulario;

            $codigo_cliente = strtoupper($request->codigocliente);
            $codigo_cliente = explode("-", $codigo_cliente);
            $codigo_cliente = $codigo_cliente[2];

            $codigo_cliente_sql = Formulario::where('codigoCliente', 'like', "%$codigo_cliente%")->get();
            
            if(sizeof($codigo_cliente_sql) <= 0){
                $formulario->codigoCliente = strtoupper($request->codigocliente);
                $formulario->nombre = strtoupper($request->nombre);
                $formulario->apellido_p = strtoupper($request->apellido_p);
                $formulario->apellido_m = strtoupper($request->apellido_m);
                $formulario->estado_civil = strtoupper($request->estado_civil);
                $formulario->fecha_nacimiento = $request->fecha_nacimiento;
                $formulario->pasaporte = strtoupper($request->pasaporte);
                $formulario->ine = strtoupper($request->ine);
                $formulario->nacionalidad = strtoupper($request->nacionalidad);
                $formulario->direccion = strtoupper($request->direccion);
                $formulario->colonia = strtoupper($request->colonia);
                $formulario->cp = $request->cp;
                $formulario->ciudad = strtoupper($request->ciudad);
                $formulario->estado = strtoupper($request->estado);
                $formulario->pais = strtoupper($request->pais);
                $formulario->celular = $request->celular;
                $formulario->correo_personal = strtoupper($request->correo_personal);
                $formulario->correo_institucional = strtoupper($request->correo_institucional);
                $formulario->fuera_mexico = strtoupper($request->fuera_mexico);
                $formulario->situacion_laboral = strtoupper($request->situacion_laboral);
                if (!empty($request->nombre_direccion)) {
                    $formulario->nombre_direccion = strtoupper($request->nombre_direccion);
                } else {
                    $formulario->nombre_direccion = strtoupper($request->nombre_direccion2);
                }
                $formulario->giro_empresa = strtoupper($request->giro_empresa);
                if (!empty($request->puesto)) {
                    $formulario->puesto = strtoupper($request->puesto);
                } else {
                    $formulario->puesto = strtoupper($request->puesto2);
                }
                $formulario->sector_empresa = strtoupper($request->sector_empresa);
                $formulario->personas_cargo = $request->personas_cargo;
                $formulario->porcentaje_acciones = $request->porcentaje_acciones;

                if (!empty($request->monto_anio)) {
                    $monto_anio = str_replace(array("$", ","), "", $request->monto_anio);
                    $formulario->monto_anio = $monto_anio;
                }

                $formulario->pagina_web = $request->pagina_web;
                if (!empty($request->ultimo_empleo)) {
                    $formulario->ultimo_empleo = strtoupper($request->ultimo_empleo);
                } else {
                    $formulario->ultimo_empleo = strtoupper($request->ultimo_empleo2);
                }
                $formulario->ultimo_empleador = strtoupper($request->ultimo_empleador);
                $formulario->status_anterior = strtoupper($request->status_anterior);

                if (!empty($request->monto_mensual_jubilacion)) {
                    $monto_mensual_jubilacion = str_replace(array("$", ","), "", $request->monto_mensual_jubilacion);
                    $formulario->monto_mensual_jubilacion = $monto_mensual_jubilacion;
                }

                $formulario->escuela_universidad = strtoupper($request->escuela_universidad);
                $formulario->campo_facultad = strtoupper($request->campo_facultad);
                $formulario->especificacion_trabajo = strtoupper($request->especificacion_trabajo);
                $formulario->funcion_publica = strtoupper($request->funcion_publica);
                $formulario->descripcion_funcion_publica = strtoupper($request->descripcion_funcion_publica);
                $formulario->residencia = strtoupper($request->residencia);
                $formulario->rfc = strtoupper($request->rfc);

                if (!empty($request->deposito_inicial)) {
                    $deposito_inicial = str_replace(array("$", ","), "", $request->deposito_inicial);
                    $formulario->deposito_inicial = $deposito_inicial;
                }

                $formulario->origen_dinero = strtoupper($request->origen_dinero);
                $formulario->ps_id = $request->ps_id;

                $nombreDocs = explode("-", $request->codigocliente);
                $nombreDocs = $nombreDocs[1] . "-" . $nombreDocs[2];
                if ($request->hasFile('ine_documento')) {
                    $file = $request->file('ine_documento');
                    $ext = $file->getClientOriginalName();
                    $ext = substr($ext, strpos($ext, "."));
                    $filename = $nombreDocs . "_ine" . $ext;

                    $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                    $formulario->ine_documento = $filename;
                }

                if ($request->hasFile('pasaporte_documento')) {
                    $file = $request->file('pasaporte_documento');
                    $ext = $file->getClientOriginalName();
                    $ext = substr($ext, strpos($ext, "."));
                    $filename = $nombreDocs . "_pasaporte" . $ext;

                    $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                    $formulario->pasaporte_documento = $filename;
                }

                if ($request->hasFile('comprobante_domicilio')) {
                    $file = $request->file('comprobante_domicilio');
                    $ext = $file->getClientOriginalName();
                    $ext = substr($ext, strpos($ext, "."));
                    $filename = $nombreDocs . "_comprobante_domicilio" . $ext;

                    $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                    $formulario->comprobante_domicilio = $filename;
                }

                $formulario->save();

                $formulario_id = $formulario->id;
                $bitacora_id = session('bitacora_id');

                $log = new Log;

                $log->tipo_accion = "Inserción";
                $log->tabla = "Formulario";
                $log->id_tabla = $formulario_id;
                $log->bitacora_id = $bitacora_id;

                $log->save();

                return response($formulario);
            }else{
                return response()->json(
                    [
                        'errors' => [
                            "codigocliente" => ["El código de cliente ya está en uso."]
                        ]
                    ], 
                    422
                );
            }
        }
    }

    public function editFormulario(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'codigocliente' => 'required',
                'nombre' => 'required|string',
                'apellido_p' => 'required|string',
                'correo_institucional' => 'required|email',
                'ps_id' => 'required',
            ]);

            $formulario = Formulario::find($request->id);
        
            $formulario->codigoCliente = strtoupper($request->codigocliente);
            $formulario->nombre = strtoupper($request->nombre);
            $formulario->apellido_p = strtoupper($request->apellido_p);
            $formulario->apellido_m = strtoupper($request->apellido_m);
            $formulario->estado_civil = strtoupper($request->estado_civil);
            $formulario->fecha_nacimiento = $request->fecha_nacimiento;
            $formulario->pasaporte = strtoupper($request->pasaporte);
            $formulario->ine = strtoupper($request->ine);
            $formulario->nacionalidad = strtoupper($request->nacionalidad);
            $formulario->direccion = strtoupper($request->direccion);
            $formulario->colonia = strtoupper($request->colonia);
            $formulario->cp = $request->cp;
            $formulario->ciudad = strtoupper($request->ciudad);
            $formulario->estado = strtoupper($request->estado);
            $formulario->pais = strtoupper($request->pais);
            $formulario->celular = $request->celular;
            $formulario->correo_personal = strtoupper($request->correo_personal);
            $formulario->correo_institucional = strtoupper($request->correo_institucional);
            $formulario->fuera_mexico = strtoupper($request->fuera_mexico);
            $formulario->situacion_laboral = strtoupper($request->situacion_laboral);
            if (!empty($request->nombre_direccion)) {
                $formulario->nombre_direccion = strtoupper($request->nombre_direccion);
            } else {
                $formulario->nombre_direccion = strtoupper($request->nombre_direccion2);
            }
            $formulario->giro_empresa = strtoupper($request->giro_empresa);
            if (!empty($request->puesto)) {
                $formulario->puesto = strtoupper($request->puesto);
            } else {
                $formulario->puesto = strtoupper($request->puesto2);
            }
            $formulario->sector_empresa = strtoupper($request->sector_empresa);
            $formulario->personas_cargo = $request->personas_cargo;
            $formulario->porcentaje_acciones = $request->porcentaje_acciones;

            if (!empty($request->monto_anio)) {
                $monto_anio = str_replace(array("$", ","), "", $request->monto_anio);
                $formulario->monto_anio = $monto_anio;
            }

            $formulario->pagina_web = $request->pagina_web;
            if (!empty($request->ultimo_empleo)) {
                $formulario->ultimo_empleo = strtoupper($request->ultimo_empleo);
            } else {
                $formulario->ultimo_empleo = strtoupper($request->ultimo_empleo2);
            }
            $formulario->ultimo_empleador = strtoupper($request->ultimo_empleador);
            $formulario->status_anterior = strtoupper($request->status_anterior);

            if (!empty($request->monto_mensual_jubilacion)) {
                $monto_mensual_jubilacion = str_replace(array("$", ","), "", $request->monto_mensual_jubilacion);
                $formulario->monto_mensual_jubilacion = $monto_mensual_jubilacion;
            }

            $formulario->escuela_universidad = strtoupper($request->escuela_universidad);
            $formulario->campo_facultad = strtoupper($request->campo_facultad);
            $formulario->especificacion_trabajo = strtoupper($request->especificacion_trabajo);
            $formulario->funcion_publica = strtoupper($request->funcion_publica);
            $formulario->descripcion_funcion_publica = strtoupper($request->descripcion_funcion_publica);
            $formulario->residencia = strtoupper($request->residencia);
            $formulario->rfc = strtoupper($request->rfc);

            if (!empty($request->deposito_inicial)) {
                $deposito_inicial = str_replace(array("$", ","), "", $request->deposito_inicial);
                $formulario->deposito_inicial = $deposito_inicial;
            }

            $formulario->origen_dinero = strtoupper($request->origen_dinero);
            $formulario->ps_id = $request->ps_id;

            $nombreDocs = explode("-", $request->codigocliente);
            $nombreDocs = $nombreDocs[1] . "-" . $nombreDocs[2];
            if ($request->hasFile('ine_documento')) {
                $file = $request->file('ine_documento');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_ine" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $formulario->ine_documento = $filename;
            }

            if ($request->hasFile('pasaporte_documento')) {
                $file = $request->file('pasaporte_documento');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_pasaporte" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $formulario->pasaporte_documento = $filename;
            }

            if ($request->hasFile('comprobante_domicilio')) {
                $file = $request->file('comprobante_domicilio');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_comprobante_domicilio" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $formulario->comprobante_domicilio = $filename;
            }

            $formulario->save();

            $formulario_id = $formulario->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Actualización";
            $log->tabla = "Formulario";
            $log->id_tabla = $formulario_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();

            return response($formulario);
        }
    }

    public function deleteFormulario(Request $request)
    {
        $formulario_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Eliminación";
        $log->tabla = "Formulario";
        $log->id_tabla = $formulario_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            if ($request->ajax()) {
                Formulario::destroy($request->id);
            }
        }
    }

    public function numCliente(Request $request)
    {

        $numeroOficina = session('codigo_oficina');

        if ($numeroOficina == "%") {
            $numeroOficina = "001";
        }

        $codigoForm = Formulario::select('codigoCliente')->orderBy('id', 'DESC')->first();
        $codigoCliente = Cliente::select('codigoCliente')->orderBy('id', 'DESC')->first();

        if (!empty($codigoForm) && !empty($codigoCliente)) {

            $codigoForm = explode("-", $codigoForm);            
            $codigoCliente = explode("-", $codigoCliente);

            if($codigoForm[2] >= $codigoCliente[2]){
                $cliente = intval($codigoForm[2]) + 1;
            }else if($codigoForm[2] < $codigoCliente[2]){
                $cliente = intval($codigoCliente[2]) + 1;
            }else{
                $cliente = intval($codigoForm[2]) + 1;
            }
            
            $numeroCliente = str_pad($cliente, 5, "0", STR_PAD_LEFT);
            $numeroClienteCompleto = "MXN-$numeroOficina-$numeroCliente-000-00";
        } else {
            $numeroCliente = "00001";
            $numeroClienteCompleto = "MXN-$numeroOficina-00001-000-00";
        }

        $data = array(
            "numeroCliente" => $numeroClienteCompleto,
            "correoCliente" => "mxa_" . $numeroCliente . "@uptradingexperts.com"
        );

        return response($data);
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
}
