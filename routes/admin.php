<?php

use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Ruta principal
Route::get('/admin/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

// Rutas para gestión de admin
Route::get('/admin/usuario', [App\Http\Controllers\UsuarioController::class, 'index'])->name('usuario');
Route::get('/admin/showUsuario', [App\Http\Controllers\UsuarioController::class, 'getUsuario']);
Route::post('/admin/addUsuario', [App\Http\Controllers\UsuarioController::class, 'addUsuario']);
Route::post('/admin/editUsuario', [App\Http\Controllers\UsuarioController::class, 'editUsuario']);
Route::post('/admin/deleteUsuario', [App\Http\Controllers\UsuarioController::class, 'deleteUsuario']);

// Rutas para gestión de menú para amortizacion
Route::get('/admin/amortizacion', [App\Http\Controllers\AmortizacionController::class, 'index'])->name('amortizacion');
Route::get('/admin/showContratosA', [App\Http\Controllers\AmortizacionController::class, 'getContratos']);
Route::get('/admin/amortizacion/imprimirAmortizacion', [App\Http\Controllers\AmortizacionController::class, 'pdfAmortizacion']);

// Ruta para verificar que hayan amortizaciones para ese contrato
Route::post('/admin/existAmortizaciones', [App\Http\Controllers\AmortizacionController::class, 'ifExists']);
Route::get('/admin/showAmortizaciones', [App\Http\Controllers\AmortizacionController::class, 'getAmortizaciones']);
Route::post('/admin/editAmortizacion', [App\Http\Controllers\AmortizacionController::class, 'editAmortizacion']);

// Rutas para gestión de banco
Route::get('/admin/banco', [App\Http\Controllers\BancoController::class, 'index'])->name('banco');
Route::get('/admin/showBanco', [App\Http\Controllers\BancoController::class, 'getBanco']);
Route::post('/admin/addBanco', [App\Http\Controllers\BancoController::class, 'addBanco']);
Route::post('/admin/editBanco', [App\Http\Controllers\BancoController::class, 'editBanco']);
Route::post('/admin/deleteBanco', [App\Http\Controllers\BancoController::class, 'deleteBanco']);

// Rutas para gestión de bitacora
Route::get('/admin/bitacora', [App\Http\Controllers\BitacoraController::class, 'index'])->name('bitacora');
Route::get('/admin/showBitacora', [App\Http\Controllers\BitacoraController::class, 'getBitacora']);
Route::post('/admin/addBitacora', [App\Http\Controllers\BitacoraController::class, 'addBitacora']);
Route::post('/admin/editBitacora', [App\Http\Controllers\BitacoraController::class, 'editBitacora']);
Route::post('/admin/deleteBitacora', [App\Http\Controllers\BitacoraController::class, 'deleteBitacora']);

// Rutas para gestión de cliente
Route::get('/admin/cliente', [App\Http\Controllers\ClienteController::class, 'index'])->name('cliente');
Route::get('/admin/showCliente', [App\Http\Controllers\ClienteController::class, 'getCliente']);
Route::post('/admin/addCliente', [App\Http\Controllers\ClienteController::class, 'addCliente']);
Route::post('/admin/editCliente', [App\Http\Controllers\ClienteController::class, 'editCliente']);
Route::post('/admin/deleteCliente', [App\Http\Controllers\ClienteController::class, 'deleteCliente']);
Route::get('/admin/showNumCliente', [App\Http\Controllers\ClienteController::class, 'numCliente']);
Route::get('/admin/showFormCliente', [App\Http\Controllers\ClienteController::class, 'getFormulario']);

// Rutas para gestión de menú para pagos a cliente (rendimiento compuesto y mensual)
Route::get('/admin/pagosCliente', [App\Http\Controllers\PagoClienteController::class, 'index'])->name('pagocliente');
Route::get('/admin/showClientePago', [App\Http\Controllers\PagoClienteController::class, 'getCliente']);
Route::get('/admin/showContratosCliente', [App\Http\Controllers\PagoClienteController::class, 'getContratos']);
Route::post('/admin/existPagosCliente', [App\Http\Controllers\PagoClienteController::class, 'ifExists']);
Route::get('/admin/showPagosCliente', [App\Http\Controllers\PagoClienteController::class, 'getPagosCliente']);
Route::post('/admin/editPagosCliente', [App\Http\Controllers\PagoClienteController::class, 'editPagoCliente']);

// Rutas para gestión de menú para reporte de pagos a cliente (rendimiento compuesto y mensual)
Route::get('/admin/reportePagosCliente', [App\Http\Controllers\ReportePagoClienteController::class, 'index'])->name('reportepagocliente');
Route::get('/admin/getResumenPagoCliente', [App\Http\Controllers\ReportePagoClienteController::class, 'getResumenPagoCliente']);
Route::get('/admin/getResumenPagoClienteDia', [App\Http\Controllers\ReportePagoClienteController::class, 'getResumenPagoClienteDia']);
Route::get('/admin/imprimirResumenCliente', [App\Http\Controllers\ReportePagoClienteController::class, 'imprimirResumenCliente']);
Route::get('/admin/imprimirReporteCliente', [App\Http\Controllers\ReportePagoClienteController::class, 'getReportePago']);
Route::get('/admin/exportarResumenCliente', [App\Http\Controllers\ReportePagoClienteController::class, 'export']);

// Rutas para gestión de menú para reporte de pagos a cliente (rendimiento compuesto y mensual) por oficina
Route::get('/admin/reportePagosClienteOficina', [App\Http\Controllers\ReportePagoClienteOficinaController::class, 'index'])->name('reportepagoclienteoficina');
Route::get('/admin/getResumenClienteOficina', [App\Http\Controllers\ReportePagoClienteOficinaController::class, 'getResumenClienteOficina']);
Route::get('/admin/imprimirResumenClienteOficina', [App\Http\Controllers\ReportePagoClienteOficinaController::class, 'imprimirResumenClienteOficina']);

// Rutas para gestión de contrato
Route::get('/admin/contrato', [App\Http\Controllers\ContratoController::class, 'index'])->name('contrato');
Route::get('/admin/showContrato', [App\Http\Controllers\ContratoController::class, 'getContrato']);
Route::post('/admin/addContrato', [App\Http\Controllers\ContratoController::class, 'addContrato']);
Route::post('/admin/editContrato', [App\Http\Controllers\ContratoController::class, 'editContrato']);
Route::post('/admin/deleteContrato', [App\Http\Controllers\ContratoController::class, 'deleteContrato']);
Route::get('/admin/getBeneficiarios', [App\Http\Controllers\ContratoController::class, 'getBeneficiarios']);
Route::get('/admin/showClave', [App\Http\Controllers\ContratoController::class, 'getClave']);
Route::get('/admin/showListaPendientes', [App\Http\Controllers\ContratoController::class, 'getPendientes']);
Route::get('/admin/showPendiente', [App\Http\Controllers\ContratoController::class, 'getPendiente']);
Route::get('/admin/showNumeroCliente', [App\Http\Controllers\ContratoController::class, 'getNumCliente']);
Route::get('/admin/editStatus', [App\Http\Controllers\ContratoController::class, 'editStatus']);
Route::get('/admin/checkScanner', [App\Http\Controllers\ContratoEscaneadoController::class, 'checkScanner']);
Route::post('/admin/addScanner', [App\Http\Controllers\ContratoEscaneadoController::class, 'addScanner']);
Route::post('/admin/editScanner', [App\Http\Controllers\ContratoEscaneadoController::class, 'editScanner']);


// Rutas para gestión de contrato terminado
Route::get('/admin/contratoTerminado', [App\Http\Controllers\ContratoTerminadoController::class, 'index'])->name('contratoTerminado');
Route::get('/admin/showContratoTerminado', [App\Http\Controllers\ContratoTerminadoController::class, 'getContrato']);
Route::post('/admin/editContratoTerminado', [App\Http\Controllers\ContratoTerminadoController::class, 'editContrato']);
Route::post('/admin/deleteContratoTerminado', [App\Http\Controllers\ContratoTerminadoController::class, 'deleteContrato']);
Route::get('/admin/getBeneficiariosTerminido', [App\Http\Controllers\ContratoTerminadoController::class, 'getBeneficiarios']);
Route::get('/admin/showClaveTerminado', [App\Http\Controllers\ContratoTerminadoController::class, 'getClave']);
Route::get('/admin/editStatusTerminado', [App\Http\Controllers\ContratoTerminadoController::class, 'editStatus']);

// Rutas para gestión de convenio MAM
Route::get('/admin/convenio', [App\Http\Controllers\ConvenioController::class, 'index'])->name('conveniomam');
Route::get('/admin/showConvenio', [App\Http\Controllers\ConvenioController::class, 'getConvenio']);
Route::post('/admin/addConvenio', [App\Http\Controllers\ConvenioController::class, 'addConvenio']);
Route::post('/admin/editConvenio', [App\Http\Controllers\ConvenioController::class, 'editConvenio']);
Route::post('/admin/deleteConvenio', [App\Http\Controllers\ConvenioController::class, 'deleteConvenio']);
Route::get('/admin/validateClaveConvenio', [App\Http\Controllers\ConvenioController::class, 'validateClave']);
Route::get('/admin/editStatusConvenio', [App\Http\Controllers\ConvenioController::class, 'editStatus']);
Route::get('/admin/getFolioConvenio', [App\Http\Controllers\ConvenioController::class, 'getFolioConvenio']);

// Rutas para gestión de modelo
Route::get('/admin/modelo', [App\Http\Controllers\ModeloController::class, 'index'])->name('modelo');
Route::get('/admin/showModelo', [App\Http\Controllers\ModeloController::class, 'getModelo']);
Route::post('/admin/addModelo', [App\Http\Controllers\ModeloController::class, 'addModelo']);
Route::post('/admin/editModelo', [App\Http\Controllers\ModeloController::class, 'editModelo']);
Route::post('/admin/deleteModelo', [App\Http\Controllers\ModeloController::class, 'deleteModelo']);

// Rutas para gestión de PS
Route::get('/admin/ps', [App\Http\Controllers\PsController::class, 'index'])->name('ps');
Route::get('/admin/showPs', [App\Http\Controllers\PsController::class, 'getPs']);
Route::post('/admin/addPs', [App\Http\Controllers\PsController::class, 'addPs']);
Route::post('/admin/editPs', [App\Http\Controllers\PsController::class, 'editPs']);
Route::post('/admin/deletePs', [App\Http\Controllers\PsController::class, 'deletePs']);

// Rutas para gestión de oficinas
Route::get('/admin/oficina', [App\Http\Controllers\OficinaController::class, 'index'])->name('oficinas');
Route::get('/admin/showOficina', [App\Http\Controllers\OficinaController::class, 'getOficina']);
Route::post('/admin/addOficina', [App\Http\Controllers\OficinaController::class, 'addOficina']);
Route::post('/admin/editOficina', [App\Http\Controllers\OficinaController::class, 'editOficina']);
Route::post('/admin/deleteOficina', [App\Http\Controllers\OficinaController::class, 'deleteOficina']);

// Rutas para gestión de PS de oficina
Route::get('/admin/psOficina', [App\Http\Controllers\PsOficinaController::class, 'index'])->name('psoficina');
Route::get('/admin/showPsOficina', [App\Http\Controllers\PsOficinaController::class, 'getPs']);
Route::post('/admin/addPsOficina', [App\Http\Controllers\PsOficinaController::class, 'addPs']);
Route::post('/admin/editPsOficina', [App\Http\Controllers\PsOficinaController::class, 'editPs']);
Route::post('/admin/deletePsOficina', [App\Http\Controllers\PsOficinaController::class, 'deletePs']);
Route::post('/admin/getPsEncargado', [App\Http\Controllers\PsOficinaController::class, 'getPsEncargado']);

// Rutas para gestión de menú para pagos a ps (rendimiento compuesto y mensual)
Route::get('/admin/pagoPS', [App\Http\Controllers\PagoPsController::class, 'index'])->name('pagops');
Route::get('/admin/showPS', [App\Http\Controllers\PagoPsController::class, 'getPS']);
Route::get('/admin/showContratosPS', [App\Http\Controllers\PagoPsController::class, 'getContratos']);
Route::post('/admin/existPagosPS', [App\Http\Controllers\PagoPsController::class, 'ifExists']);
Route::get('/admin/showPagosPS', [App\Http\Controllers\PagoPsController::class, 'getPagosPS']);
Route::post('/admin/editPagosPS', [App\Http\Controllers\PagoPsController::class, 'editPagoPS']);

// Rutas para gestión de menú para pagos a ps (convenio)
Route::get('/admin/pagoPSConvenio', [App\Http\Controllers\PagoPsConvenioController::class, 'index'])->name('pagopsconvenio');
Route::get('/admin/showContratosPSConvenio', [App\Http\Controllers\PagoPsConvenioController::class, 'getConvenios']);
Route::post('/admin/existPagosPSConvenio', [App\Http\Controllers\PagoPsConvenioController::class, 'ifExists']);
Route::get('/admin/showPagosPSConvenio', [App\Http\Controllers\PagoPsConvenioController::class, 'getPagosPS']);
Route::post('/admin/editPagosPSConvenio', [App\Http\Controllers\PagoPsConvenioController::class, 'editPagoPS']);

// Rutas para gestión de tipo de contrato
Route::get('/admin/tipocontrato', [App\Http\Controllers\TipoContratoController::class, 'index'])->name('tipocontrato');
Route::get('/admin/showTipoContratos', [App\Http\Controllers\TipoContratoController::class, 'getTipoContratos']);
Route::get('/admin/showTipoContrato', [App\Http\Controllers\TipoContratoController::class, 'getTipoContrato']);
Route::post('/admin/addTipoContrato', [App\Http\Controllers\TipoContratoController::class, 'addTipoContrato']);
Route::post('/admin/editTipoContrato', [App\Http\Controllers\TipoContratoController::class, 'editTipoContrato']);
Route::post('/admin/deleteTipoContrato', [App\Http\Controllers\TipoContratoController::class, 'deleteTipoContrato']);

//Rutas para registrar al usuario
Route::get('/registro', [App\Http\Controllers\RegisterController::class, 'create'])->name('registro');
Route::post('/registro', [App\Http\Controllers\RegisterController::class, 'store']);

//Rutas para iniciar sesión
Route::get('/', [App\Http\Controllers\SessionController::class, 'create'])->name('login');
Route::post('/', [App\Http\Controllers\SessionController::class, 'store']);
Route::post('/checkLocation', [App\Http\Controllers\SessionController::class, 'checkLocation']);

//Ruta para cerrar sesión
Route::get('/logout', [App\Http\Controllers\SessionController::class, 'destroy'])->middleware('auth', 'auth.admin')->name('logout');

// Rutas para el perfil
Route::get('/admin/perfil', [App\Http\Controllers\PerfilController::class, 'index'])->name('perfil');
Route::post('/admin/editPerfil', [App\Http\Controllers\PerfilController::class, 'editPerfil']);

//Ruta para imprimir los contratos
Route::get('/admin/contrato/vercontrato', [App\Http\Controllers\ImprimirController::class, 'index'])->name('vercontrato');
Route::get('/admin/imprimir', [App\Http\Controllers\ImprimirController::class, 'imprimir']);

//Ruta para imprimir los convenios
Route::get('/admin/convenio/verConvenio', [App\Http\Controllers\ConvenioController::class, 'getPreview']);
Route::get('/admin/imprimirConvenio', [App\Http\Controllers\ConvenioController::class, 'imprimirConvenio']);

//Rutas para cláusulas de tipo de contrato
Route::post('/admin/existClausulas', [App\Http\Controllers\ClausulaController::class, 'ifExists']);
Route::get('/admin/showClausulas', [App\Http\Controllers\ClausulaController::class, 'getClausulas']);
Route::post('/admin/addClausula', [App\Http\Controllers\ClausulaController::class, 'addClausula']);
Route::post('/admin/editClausula', [App\Http\Controllers\ClausulaController::class, 'editClausula']);
Route::post('/admin/deleteClausula', [App\Http\Controllers\ClausulaController::class, 'deleteClausula']);

//Rutas para checklist de los pendientes de los clientes
Route::get('/admin/checklist', [App\Http\Controllers\PendienteController::class, 'index'])->name('pendiente');
Route::get('/admin/showPendientes', [App\Http\Controllers\PendienteController::class, 'listaPendientes']);
Route::get('/admin/showClientes', [App\Http\Controllers\PendienteController::class, 'listaClientes']);
Route::post('/admin/addPendiente', [App\Http\Controllers\PendienteController::class, 'addPendiente']);
Route::post('/admin/editPendiente', [App\Http\Controllers\PendienteController::class, 'editPendiente']);
Route::post('/admin/deletePendiente', [App\Http\Controllers\PendienteController::class, 'deletePendiente']);
Route::post('/admin/generateList', [App\Http\Controllers\PendienteController::class, 'generateList']);

//Rutas para herramienta de intención de inversión
Route::get('/admin/intencionInversion', [App\Http\Controllers\IntencionController::class, 'index'])->name('intencioninversion');
Route::post('/admin/getOpc', [App\Http\Controllers\IntencionController::class, 'getOpc']);
Route::post('/admin/getOpcDividir', [App\Http\Controllers\IntencionController::class, 'getOpcDividir']);
Route::post('/admin/reporteIntencion', [App\Http\Controllers\IntencionController::class, 'reporteIntencion']);
Route::get('/admin/pdfIntencion', [App\Http\Controllers\IntencionController::class, 'pdfIntencion']);
Route::post('/admin/getClientes', [App\Http\Controllers\IntencionController::class, 'getClientes']);
Route::post('/admin/getDatosCliente', [App\Http\Controllers\IntencionController::class, 'getDatosCliente']);

//Rutas para resumen de PS
Route::get('/admin/resumenPS', [App\Http\Controllers\ResumenPSController::class, 'index'])->name('resumenps');
Route::post('/admin/getOficinas', [App\Http\Controllers\ResumenPSController::class, 'getOficinas']);
Route::post('/admin/getListaPS', [App\Http\Controllers\ResumenPSController::class, 'getListaPS']);
Route::get('/admin/getResumen', [App\Http\Controllers\ResumenPSController::class, 'getResumen']);
Route::get('/admin/imprimirResumen', [App\Http\Controllers\ResumenPSController::class, 'imprimirResumen']);
Route::get('/admin/imprimirResumenOficina', [App\Http\Controllers\ResumenPSController::class, 'imprimirResumenOficina']);

//Rutas de notificaciones
Route::get('/admin/notificacion', [App\Http\Controllers\NotificacionController::class, 'index'])->name('notificaciones');
Route::get('/admin/showNotificaciones', [App\Http\Controllers\NotificacionController::class, 'getNotificaciones']);
Route::get('/admin/editNotificaciones', [App\Http\Controllers\NotificacionController::class, 'editNotificaciones']);
Route::post('/admin/deleteNotificaciones', [App\Http\Controllers\NotificacionController::class, 'deleteNotificaciones']);

//Rutas de reporteador de pagos
Route::get('/admin/reporteMesPagoPS', [App\Http\Controllers\ReportePagoController::class, 'ReporteMesPagoPSView'])->name('reportepagops');
Route::get('/admin/reporteFiltroPagoPS', [App\Http\Controllers\ReportePagoController::class, 'ReporteFiltroPagoPSView']);
Route::get('/admin/pdfReporteMesPagoPS', [App\Http\Controllers\ReportePagoController::class, 'pdfReporteMesPagoPS']);
Route::get('/admin/pdfReporteFiltroPagoPS', [App\Http\Controllers\ReportePagoController::class, 'pdfReporteFiltroPagoPS']);

//Rutas de formulario
Route::get('/admin/formulario', [App\Http\Controllers\FormularioController::class, 'index'])->name('formulario');
Route::get('/admin/showFormulario', [App\Http\Controllers\FormularioController::class, 'getFormulario']);
Route::post('/admin/addFormulario', [App\Http\Controllers\FormularioController::class, 'addFormulario']);
Route::post('/admin/editFormulario', [App\Http\Controllers\FormularioController::class, 'editFormulario']);
Route::post('/admin/deleteFormulario', [App\Http\Controllers\FormularioController::class, 'deleteFormulario']);
Route::get('/admin/showNumeroClienteForm', [App\Http\Controllers\FormularioController::class, 'numCliente']);

//Rutas de documentos
Route::get('/admin/documentos', [App\Http\Controllers\DocumentoController::class, 'index'])->name('documentos');
Route::post('/admin/addDocumento', [App\Http\Controllers\DocumentoController::class, 'addDocumento']);
Route::post('/admin/editDocumento', [App\Http\Controllers\DocumentoController::class, 'editDocumento']);
Route::post('/admin/deleteDocumento', [App\Http\Controllers\DocumentoController::class, 'deleteDocumento']);

//Rutas de cuentas Google
Route::get('/admin/cuentasGoogle', [App\Http\Controllers\GoogleController::class, 'redirect'])->name('cuentasgoogle');
Route::get('/admin/cuentasGsuite', [App\Http\Controllers\GoogleController::class, 'index']);
Route::post('/admin/addCuenta', [App\Http\Controllers\GoogleController::class, 'addCuenta']);
Route::post('/admin/editCuenta', [App\Http\Controllers\GoogleController::class, 'editCuenta']);
Route::post('/admin/generarCuentas', [App\Http\Controllers\GoogleController::class, 'generarCuentas']);

//Rutas de bitácora de acceso
Route::get('/admin/bitacoraAcceso', [App\Http\Controllers\BitacoraAccesoController::class, 'index'])->name('bitacoraacceso');
Route::get('/admin/getDetallesBitacora', [App\Http\Controllers\BitacoraAccesoController::class, 'getDetallesBitacora']);

//Rutas de bitácora de acceso
Route::get('/admin/historialCambios', [App\Http\Controllers\LogController::class, 'index'])->name('logs');
Route::get('/admin/showCambios', [App\Http\Controllers\LogController::class, 'getLogs']);
Route::post('/admin/deleteCambio', [App\Http\Controllers\LogController::class, 'deleteCambio']);

//Rutas de tipo de cambio
Route::get('/admin/tipocambio', [App\Http\Controllers\TipoCambioController::class, 'index'])->name('tipocambio');
Route::get('/admin/showTipoCambio', [App\Http\Controllers\TipoCambioController::class, 'getTipoCambio']);
Route::post('/admin/deleteTipoCambio', [App\Http\Controllers\TipoCambioController::class, 'deleteTipoCambio']);
Route::get('/admin/showClaveTipoCambio', [App\Http\Controllers\TipoCambioController::class, 'getClave']);

//Rutas de pregunta
Route::get('/admin/preguntas', [App\Http\Controllers\PreguntaController::class, 'index'])->name('pregunta');
Route::get('/admin/showPreguntas', [App\Http\Controllers\PreguntaController::class, 'getPreguntas']);
Route::get('/admin/buscarPregunta', [App\Http\Controllers\PreguntaController::class, 'buscarPregunta']);
Route::post('/admin/addPregunta', [App\Http\Controllers\PreguntaController::class, 'addPregunta']);
Route::post('/admin/editPregunta', [App\Http\Controllers\PreguntaController::class, 'editPregunta']);
Route::post('/admin/deletePregunta', [App\Http\Controllers\PreguntaController::class, 'deletePregunta']);

// Ruta del chat
Route::get('/admin/auth/user', function () {
	if(auth()->check()){
		return response()->json([ 'authUser' => auth()->user() ]);
		return null;
	}
});
Route::get('/admin/chat/{chat}', [App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
Route::get('/admin/chat/with/{user}', [App\Http\Controllers\ChatController::class, 'chat_with'])->name('chat.with');
Route::get('/admin/chats/with/{user}', [App\Http\Controllers\ChatController::class, 'chats_with'])->name('chats.with');
Route::get('/admin/chat/{chat}/get_users', [App\Http\Controllers\ChatController::class, 'get_users'])->name('chat.get_users');
Route::get('/admin/chat/{chat}/get_messages', [App\Http\Controllers\ChatController::class, 'get_messages'])->name('chat.get_messages');
Route::post('/admin/message/sent', [App\Http\Controllers\MessageController::class, 'sent'])->name('message.sent');

// Rutas de gestión de tickets
Route::get('/admin/tickets', [TicketController::class, 'index']);
Route::post('/admin/addTicket', [TicketController::class, 'addTicket']);

// Rutas de preguntas
Route::get('/admin/showPreguntas', [App\Http\Controllers\PreguntaController::class, 'getPreguntas'])->name('preguntas');
Route::get('/admin/buscarPregunta', [App\Http\Controllers\PreguntaController::class, 'buscarPregunta']);
Route::post('/admin/addPregunta', [App\Http\Controllers\PreguntaController::class, 'addPregunta']);
Route::post('/admin/editPregunta', [App\Http\Controllers\PreguntaController::class, 'editPregunta']);
Route::post('/admin/deletePregunta', [App\Http\Controllers\PreguntaController::class, 'deletePregunta']);

//Rutas auxuliares (usar con cuidado)
//Actualizar todos los pagos a PS, pagos a cliente y amortizaciones (Compuesto y mensual)
Route::get('/auxiliar/actualizarPagos', [App\Http\Controllers\AuxiliarController::class, 'actualizarPagos']);

//Rutas de gestión de porcentajes
Route::get('/admin/porcentaje', [App\Http\Controllers\PorcentajeController::class, 'index'])->name('porcentajes');
Route::get('/admin/getContratosPorcentaje', [App\Http\Controllers\PorcentajeController::class, 'getContratosPorcentaje']);
Route::post('/admin/editPorcentajes', [App\Http\Controllers\PorcentajeController::class, 'editPorcentajes']);

//Rutas de gestión de búsqueda de clientes
Route::post('/admin/buscarCliente', [App\Http\Controllers\BusquedaController::class, 'buscarCliente'])->name('buscarcliente');

//Rutas de gestión de agenda
Route::get('/admin/agenda', [App\Http\Controllers\AgendaController::class, 'index'])->name('agenda');
Route::get('/admin/showAgenda', [App\Http\Controllers\AgendaController::class, 'getAgenda']);
Route::get('/admin/showCita', [App\Http\Controllers\AgendaController::class, 'getCita']);
Route::post('/admin/addAgenda', [App\Http\Controllers\AgendaController::class, 'addAgenda']);
Route::post('/admin/editAgenda', [App\Http\Controllers\AgendaController::class, 'editAgenda']);
Route::post('/admin/deleteAgenda', [App\Http\Controllers\AgendaController::class, 'deleteAgenda']);

//Rutas de gestión de PS Móvil
Route::get('/admin/psmovil', [App\Http\Controllers\PSMovilController::class, 'index'])->name('psmovil');
Route::get('/admin/showPSMovil', [App\Http\Controllers\PSMovilController::class, 'getPsMovil']);
Route::post('/admin/editPSMovil', [App\Http\Controllers\PSMovilController::class, 'editPSMovil']);
Route::post('/admin/addPSMovil', [App\Http\Controllers\PSMovilController::class, 'addPSMovil']);
Route::post('/admin/deletePSMovil', [App\Http\Controllers\PSMovilController::class, 'deletePSMovil']);