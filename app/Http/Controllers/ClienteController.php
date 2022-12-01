<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\User;
use App\Models\Ps;
use App\Models\Oficina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Http;
use App\Models\Formulario;
use App\Models\Log;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {

        $codigo = session('codigo_oficina');
        $numeroCliente = "MXN-" . $codigo . "-";

        $lista_form = Formulario::select()->where('codigoCliente', 'like', "$numeroCliente%")->get();

        return view('cliente.show', compact("lista_form"));
    }

    public function getCliente()
    {

        $codigo = session('codigo_oficina');
        $numeroCliente = "MXN-" . $codigo . "-";

        $cliente = Cliente::select()->where('codigoCliente', 'like', "$numeroCliente%")->get();

        return datatables()->of($cliente)->addColumn('btn', 'cliente.buttons')->rawColumns(['btn'])->toJson();
    }

    public function addCliente(Request $request)
    {
        if ($request->ajax()) {

            $convenio_mam = $request->input('convenio_mam');

            if(!empty($convenio_mam)){
                $request->validate([
                    'nombre' => 'required|string',
                    'apellidop' => 'required|string',
                ]);
            }else{
                $request->validate([
                    'codigocliente' => 'required|unique:cliente',
                    'nombre' => 'required|string',
                    'apellidop' => 'required|string',
                    'fechanac' => 'required|date',
                    'nacionalidad' => 'required',
                    'direccion' => 'required',
                    'colonia' => 'required',
                    'cp' => 'required|numeric|digits:5',
                    'ciudad' => 'required|string',
                    'estado' => 'required|string',
                    'celular' => 'required|numeric|digits:10',
                    'correo_institucional' => 'required|email|unique:cliente',
                    'correo_personal' => 'required|email',
                ]);
            }

            if(!empty($request->input('ine'))){
                $request->validate([
                    'ine' => 'required|digits_between:10,20',
                ]);
            }

            //Añadir registros a la tabla clientes
            $cliente = new Cliente;

            $cliente->codigoCliente = $request->input('codigocliente');
            $cliente->nombre = strtoupper($request->input('nombre'));
            $cliente->apellido_p = strtoupper($request->input('apellidop'));
            $cliente->apellido_m = strtoupper($request->input('apellidom'));
            $cliente->fecha_nac = $request->input('fechanac');
            $cliente->nacionalidad = strtoupper($request->input('nacionalidad'));
            $cliente->direccion = strtoupper($request->input('direccion'));
            $cliente->colonia = strtoupper($request->input('colonia'));
            $cliente->cp = $request->input('cp');
            $cliente->ciudad = strtoupper($request->input('ciudad'));
            $cliente->estado = strtoupper($request->input('estado'));
            $cliente->celular = $request->input('celular');
            $cliente->correo_personal = strtolower($request->input('correo_personal'));
            $cliente->correo_institucional = strtolower($request->input('correo_institucional'));
            $cliente->ine = $request->input('ine');
            $cliente->pasaporte = strtoupper($request->input('pasaporte'));
            $cliente->vencimiento_pasaporte = $request->input('fechapas');
            $cliente->swift = strtoupper($request->input('swift'));
            $cliente->iban = strtoupper($request->input('iban'));

            $tarjeta = $request->input('tarjeta');
            
            if(!empty($tarjeta)){
                $cliente->tarjeta = "SI";
            }else{
                $cliente->tarjeta = "NO";
            }

            $nombreDocs = $request->codigocliente;
            $nombreDocs = explode("-", $request->codigocliente);
            $nombreDocs = $nombreDocs[1] . "-" . $nombreDocs[2];
            if ($request->hasFile('ine_documento')) {
                $file = $request->file('ine_documento');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_ine" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->ine_documento = $filename;
            }

            if ($request->hasFile('pasaporte_documento')) {
                $file = $request->file('pasaporte_documento');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_pasaporte" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->pasaporte_documento = $filename;
            }

            if ($request->hasFile('comprobante_domicilio')) {
                $file = $request->file('comprobante_domicilio');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_comprobante_domicilio" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->comprobante_domicilio = $filename;
            }

            if ($request->hasFile('lpoa_documento')) {
                $file = $request->file('lpoa_documento');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_lpoa" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->lpoa_documento = $filename;
            }

            if ($request->hasFile('formulario_apertura')) {
                $file = $request->file('formulario_apertura');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_formapertura" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->formulario_apertura = $filename;
            }

            if ($request->hasFile('formulario_riesgos')) {
                $file = $request->file('formulario_riesgos');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = strtolower($nombreDocs . "_formriesgos" . $ext);

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->formulario_riesgos = $filename;
            }

            $cliente->save();

            $cliente_id = $cliente->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Inserción";
            $log->tabla = "Cliente";
            $log->id_tabla = $cliente_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();

            //Añadir registros a la tabla users
            $verificacion = User::where("correo", strtolower($request->correo_institucional))->count();
            if ($verificacion == 0) {
                $user = new User;
                $user->nombre = strtoupper($request->nombre);
                $user->apellido_p = strtoupper($request->apellidop);
                $user->apellido_m = strtoupper($request->apellidom);
                $user->correo = strtolower($request->correo_institucional);
                $userId = User::select('id')->orderBy('id', 'desc')->first();
                $userId = intval($userId->id) + 1;
                $pass = explode("@", $request->correo_institucional);
                $user->password = $userId . $pass[0];

                $ps = Ps::select()->where("correo_institucional", strtolower($request->correo_institucional))->first();
                $oficina = Oficina::select()->where("codigo_oficina", "007")->first();

                if (!empty($ps)) {
                    if ($oficina->id == $ps->oficina_id) {
                        $user->privilegio = 'cliente_ps_encargado';
                    } else {
                        $user->privilegio = 'cliente_ps_asistente';
                    }
                } else {
                    $user->privilegio = 'cliente';
                }
                $user->save();
            } else {
                $ps = Ps::select()->where("correo_institucional", strtolower($request->correo_institucional))->first();
                $oficina = Oficina::select()->where("codigo_oficina", "007")->first();

                if (!empty($ps)) {
                    if ($oficina->id == $ps->oficina_id) {
                        $privilegio = 'cliente_ps_encargado';
                    } else {
                        $privilegio = 'cliente_ps_asistente';
                    }
                } else {
                    $privilegio = 'cliente';
                }

                User::where('correo', strtolower($request->input('correo_institucional')))
                    ->update([
                        'nombre' => strtoupper($request->nombre),
                        "apellido_p" => strtoupper($request->apellidop),
                        "apellido_m" => strtoupper($request->apellidom),
                        "privilegio" => $privilegio
                    ]);
            }
            return response($cliente);
        }
    }

    public function editCliente(Request $request)
    {
        if ($request->ajax()) {
            
            $convenio_mam = $request->input('convenio_mam');
            if(!empty($convenio_mam)){
                $request->validate([
                    'nombre' => 'required|string',
                    'apellidop' => 'required|string',
                ]);
            }else{
                $request->validate([
                    'codigocliente' => 'required',
                    'nombre' => 'required|string',
                    'apellidop' => 'required|string',
                    'fechanac' => 'required|date',
                    'nacionalidad' => 'required',
                    'direccion' => 'required',
                    'colonia' => 'required',
                    'cp' => 'required|numeric|digits:5',
                    'ciudad' => 'required|string',
                    'estado' => 'required|string',
                    'celular' => 'required|numeric|digits:10',
                    'correo_institucional' => 'required|email',
                    'correo_personal' => 'required|email',
                ]);
            }

            if(!empty($request->input('ine'))){
                $request->validate([
                    'ine' => 'required|digits_between:10,20',
                ]);
            }

            //Editar registros en la tabla clientes
            $cliente = Cliente::find($request->id);
            $cliente->codigoCliente = $request->input('codigocliente');
            $cliente->nombre = strtoupper($request->input('nombre'));
            $cliente->apellido_p = strtoupper($request->input('apellidop'));
            $cliente->apellido_m = strtoupper($request->input('apellidom'));
            $cliente->fecha_nac = $request->input('fechanac');
            $cliente->nacionalidad = strtoupper($request->input('nacionalidad'));
            $cliente->direccion = strtoupper($request->input('direccion'));
            $cliente->colonia = strtoupper($request->input('colonia'));
            $cliente->cp = $request->input('cp');
            $cliente->ciudad = strtoupper($request->input('ciudad'));
            $cliente->estado = strtoupper($request->input('estado'));
            $cliente->celular = $request->input('celular');
            $cliente->correo_personal = strtolower($request->input('correo_personal'));
            $cliente->correo_institucional = strtolower($request->input('correo_institucional'));
            $cliente->ine = $request->input('ine');
            $cliente->pasaporte = strtoupper($request->input('pasaporte'));
            $cliente->vencimiento_pasaporte = $request->input('fechapas');
            $cliente->swift = strtoupper($request->input('swift'));
            $cliente->iban = $request->input('iban');

            $tarjeta = $request->input('tarjeta');
            
            if(!empty($tarjeta)){
                $cliente->tarjeta = "SI";
            }else{
                $cliente->tarjeta = "NO";
            }

            $nombreDocs = $request->codigocliente;
            $nombreDocs = explode("-", $request->codigocliente);
            $nombreDocs = $nombreDocs[1] . "-" . $nombreDocs[2];
            if ($request->hasFile('ine_documento')) {
                $file = $request->file('ine_documento');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_ine" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->ine_documento = $filename;
            }

            if ($request->hasFile('pasaporte_documento')) {
                $file = $request->file('pasaporte_documento');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_pasaporte" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->pasaporte_documento = $filename;
            }

            if ($request->hasFile('comprobante_domicilio')) {
                $file = $request->file('comprobante_domicilio');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_comprobante_domicilio" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->comprobante_domicilio = $filename;
            }

            if ($request->hasFile('lpoa_documento')) {
                $file = $request->file('lpoa_documento');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_lpoa" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->lpoa_documento = $filename;
            }

            if ($request->hasFile('formulario_apertura')) {
                $file = $request->file('formulario_apertura');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_formapertura" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->formulario_apertura = $filename;
            }

            if ($request->hasFile('formulario_riesgos')) {
                $file = $request->file('formulario_riesgos');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = strtolower($nombreDocs . "_formriesgos" . $ext);

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->formulario_riesgos = $filename;
            }

            // Schema::enableForeignKeyConstraints();
            $cliente->update();

            $cliente_id = $cliente->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Actualización";
            $log->tabla = "Cliente";
            $log->id_tabla = $cliente_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();

            //editar user
            User::where('correo', $request->correo_temp)
                ->update([
                    'nombre' => strtoupper($request->nombre),
                    "apellido_p" => strtoupper($request->apellidop),
                    "apellido_m" => strtoupper($request->apellidom),
                    "correo" => strtolower($request->input('correo_institucional'))
                ]);

            return response($cliente);
        }
    }

    public function deleteCliente(Request $request)
    {
        if ($request->ajax()) {

            $cliente = DB::table('cliente')->where('id', $request->id)->first();
            $users = DB::table('users')->where('correo', $cliente->correo_institucional)->first();

            $cliente_id = $request->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Eliminación";
            $log->tabla = "Cláusula";
            $log->id_tabla = $cliente_id;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {
                Cliente::destroy($request->id);
            }
        }
    }

    public function numCliente(Request $request)
    {

        $numeroOficina = session('codigo_oficina');

        if ($numeroOficina == "%") {
            $numeroOficina = "001";
        }

        $codigoForm = Formulario::select('codigoCliente')->orderBy('id', 'desc')->first();
        $codigoCliente = Cliente::select('codigoCliente')->orderBy('id', 'desc')->first();
        
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
            $numeroCliente = "MXN-$numeroOficina-$numeroCliente-000-00";
            return response($numeroCliente);
        } else {
            $numeroCliente = "MXN-$numeroOficina-00001-000-00";
            return response($numeroCliente);
        }
    }

    public function getFormulario(Request $request)
    {
        $formulario = DB::table('formulario')
            ->select()
            ->where("id", "=", $request->id)
            ->get();

        return response($formulario);
    }
}