<?php
namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Pedidos;
use App\Producto;
use App\Events\ChangeStateOrderEvent;
use App\TransCulqi;
use Illuminate\Support\Facades\Mail;
use App\Mail\Email_PagadoCulqi;
use App\Empresa;

class PedidosController extends Controller
{
    public function show($id){
        $detalle = DB::table('detalle_pedidos')
            ->join('productos', 'productos.id', '=', 'detalle_pedidos.producto_id')
            ->where('detalle_pedidos.pedido_id', '=', $id)
            ->get();
            return response()->json(["detalle" => $detalle], 200);
    }

	public function vista_asignar(Request $request){
		return view('admin.pedidos.asignacionDelivery', ["empresa" => session('empresa')]);
	}
	public function vista_estado(Request $request){
		return view('admin.pedidos.estadoPedido', ["empresa" => session('empresa')]);
	}
	public function vista_cocina(Request $request){
		return view('admin.pedidos.pedidosRecepcion', ["empresa" => session('empresa')]);
	}
	public function vista_pedidos(Request $request){
		return view('admin.pedidos.pedidos',  ["empresa" => session('empresa')]);
	}
	/*
	public function fn2($funcion='', Request $request){//vista_cocina
		return $this->fn('2', $request);
	}
	public function fn3($funcion='', Request $request){//vista_asignar
		return $this->fn('3', $request);
	}
	public function fn4($funcion='', Request $request){//vista_estado
		return $this->fn('4', $request);
	}
	public function fn5($funcion='', Request $request){
		return $this->fn('5', $request);
	}
	*/
	/*
    public function fn($funcion='', Request $request){
		if ($funcion == 'listartodo') return $this->listartodo($request);
		else if ($funcion == 'listarrecepcion') return $this->listarrecepcion($request);
		else if ($funcion == 'listardelivery') return $this->listardelivery($request);
		else if ($funcion == 'listarempleados') return $this->listarempleados($request);
		else if ($funcion == 'aceptar') return $this->aceptar($request);
		else if ($funcion == 'cancelar') return $this->cancelar($request);
		else if ($funcion == 'entregar') return $this->entregar($request);
		else if ($funcion == 'asignar') return $this->asignar($request);
		else if ($funcion == 'cancelartodos') return $this->cancelartodos($request);
		else if ($funcion == 'ListaPedidos') return $this->ListaPedidos($request);
		else if ($funcion == 'montoPedido') return $this->montoPedido($request);
		else if ($funcion == 'MontoAsignacion') return $this->MontoAsignacion($request);
		else if ($funcion == 'ListaAsignaciones') return $this->ListaAsignaciones($request);
		else if ($funcion == '2') return view('admin.pedidos.pedidosRecepcion', ["empresa" => session('empresa')]);
		else if ($funcion == '3') return view('admin.pedidos.asignacionDelivery', ["empresa" => session('empresa')]);
		else if ($funcion == '4') return view('admin.pedidos.estadoPedido', ["empresa" => session('empresa')]);
		else return view('admin.pedidos.pedidos',  ["empresa" => session('empresa')]);
	}
	*/

	static function DetalleAsignacion($funcion)
	{
		return view('admin.pedidos.detalleAsignacion',
			[
				"empresa" => session('empresa'),
				"asignacion" => $funcion
			]);
	}
	static function montoPedido(Request $request)
	{
		return  DB::table('Pedidos')
		->join('detalle_pedidos', 'detalle_pedidos.pedido_id', '=', 'Pedidos.id')
		->select(DB::raw('SUM(detalle_pedidos.cantidad*detalle_pedidos.precio_unit) as mount'))
		->where('Pedidos.id','=',$request->get('idpedido'))
		->get();
	}
	static function ListaPedidos(Request $request)
	{
			try {
				$lista= DB::table('asignacion')
		->join('users', 'users.id', '=', 'asignacion.user_id')
				->join('pedidos_users', 'asignacion.id', '=', 'pedidos_users.asignacion_id')
				->join('pedidos', 'pedidos.id', '=', 'pedidos_users.pedidos_id')
				->join('detalle_pedidos as dp', 'dp.pedido_id', '=', 'pedidos.id')
				->join('users as u', 'u.id', '=', 'pedidos.user_id')
				->join('personas as personas', 'personas.id', '=', 'u.persona_id')
				->join('tipo_entregas as te', 'te.id', '=', 'pedidos.tipo_id')
				->select(
					'pedidos.id as idpedido',
					'personas.id as idusuario',
					DB::raw("CONCAT(personas.appaterno, ' ', personas.apmaterno, ', ', personas.nombres) as nombres"),
					'personas.celular',
					'personas.direccion',
					'pedidos.estado as state',
					'te.nombre as tipo_entrega'
					)
		->where(
					[
						['asignacion.id','=',$request->get('id')]
					]
					)
				->groupBy('pedidos.id')
				->get();

			foreach ($lista as $key => $value) {
				$value->productos=	Producto::listarProductosDePedido2($value->idpedido);
			}

			return $lista;
		} catch (\Exception  $e) {
				return [
					'Message'=> $e->getMessage(),
					'success'=>false
				];
		}
	}
	static function MontoAsignacion(Request $request)
	{
		try {
				return DB::table('asignacion')
		->join('users', 'users.id', '=', 'asignacion.user_id')
				->join('pedidos_users', 'asignacion.id', '=', 'pedidos_users.asignacion_id')
				->join('pedidos', 'pedidos.id', '=', 'pedidos_users.pedidos_id')
				->join('detalle_pedidos', 'detalle_pedidos.pedido_id', '=', 'pedidos.id')
				->select(DB::raw('SUM(detalle_pedidos.cantidad*detalle_pedidos.precio_unit) as mount'))
		->where(
					[
						['asignacion.id','=',$request->get('idAsignacion')]
					]
					)
				->get();


		} catch (\Exception  $e) {
				return [
					'Message'=> $e->getMessage(),
					'success'=>false
				];
		}
	}
	static function ListaAsignaciones(Request $request)
	{
		try {
			return DB::table('asignacion')
		->join('users', 'users.id', '=', 'asignacion.user_id')
				->join('pedidos_users', 'asignacion.id', '=', 'pedidos_users.asignacion_id')
				->select(
					'asignacion.id as IdAsignacion'
					,'asignacion.created_at as date'
					)
		->where(
					[
						['asignacion.created_at','like','%'.$request->get('fecha').'%'],
						['asignacion.user_id','=',$request->get('user')]
					]
					)
				->get();

		} catch (\Exception  $e) {
				return [
					'Message'=> $e->getMessage(),
					'success'=>false
				];
		}

	}
	static function listartodo(Request $request){
		return static::listarPedidos('Todo', 'Hoy', $request);
	}

	static function listarrecepcion(Request $request){
		return static::listarPedidos('Recepcion', 'Hoy', $request);
	}

	static function listardelivery(Request $request){
		return static::listarPedidos('Delivery', 'Hoy', $request);
	}

	static function listarentregadofecha($fecha, Request $request){
		return static::listarPedidos('Entregado', $fecha, $request);
	}

	static function listarPedidos($tipo, $fecha, $request){
        $empresa_id = session('empresa');
		$datos = array();
		$datos['pedidos'] = Pedidos::listar($empresa_id, $tipo, $fecha);
		$datos['productos_pedido'] = Producto::listarProductosDePedido($empresa_id);
		if ($tipo == 'Todo')
			$datos['categorias_productos'] = CategoriasMenusController::listarvselect($request)->original;
		//return (CategoriasMenusController::listarvselect($request));
        return response()->json($datos, 200);
	}

	static function listarempleados(Request $request){
		$empresa_id = session('empresa');
		return Pedidos::listarEmpleados($empresa_id);
	}

	static function asignar(Request $request){
		$idrepartidor = $request->get('idrepartidor');
		$pedidos = $request->get('pedidos');
		Pedidos::asignar($pedidos, $idrepartidor);
		foreach ($pedidos as $item) {
			$idCliente = $item['idusuario'];
			try { event( new ChangeStateOrderEvent(["pedido" => $item, "state" => 'ENVIANDO'], $idCliente));} catch (\Throwable $th) {}
		}
	}
	/*
	static function asignar(Request $request){
        $idpedido = $request->get('idpedido');
        $idCliente = $request->get('idusuario');
		$idrepartidor = $request->get('idrepartidor');
        Pedidos::asignar($idpedido, $idrepartidor);
        try { event( new ChangeStateOrderEvent(["pedido" => $request->pedido, "state" => 'ENVIANDO'], $idCliente));} catch (\Throwable $th) {}
	}
	*/

	public static function entregar(Request $request){
        //$empresa_id = $request->get('empresa');
		$empresa_id = session('empresa');
		$idpedido = $request->get('idpedido');
        if (Pedidos::entregar($idpedido, $empresa_id) == false)
            return response()->json(["Message" => "Error"], 500);
        return response()->json(["Message" => "ok"], 200);
	}

	static function aceptar(Request $request){
        $idpedido = $request->get('idpedido');
        $idCliente = $request->get('idusuario');
        Pedidos::aceptar($idpedido);
        try { event( new ChangeStateOrderEvent(["pedido" => $request->pedido, "state" => 'ACEPTADO'], $idCliente));} catch (\Throwable $th) {}
    }

    static function cancelaByRepartidor(Request $request){
        $pedido = Pedidos::where('id', $request->pedido)->update(['estado' => 'REPORTADO','comentario' => 'Problemas en la entrega']);
        return response()->json([$pedido]);
    }

	static function cancelar(Request $request){

		DB::beginTransaction();
		try {
			DB::commit();
			$idpedido = $request->get('idpedido');
			$comentario = $request->get('comentario');
			$idCliente = $request->get('idusuario');
			Pedidos::cancelar($idpedido, $comentario);
			$id_tipopago = $request->get('pedido')['id_tipopago'];
			if ($id_tipopago == Pedidos::$PAGO_CULQI){
				$id_regpago = $request->get('pedido')['id_regpago'];
				$transaccion = TransCulqi::devolver($id_regpago);
				Pedidos::devolverPago($idpedido);
				//mensaje via email
				$email = $transaccion->email;
				$objDemo = new \stdClass();
				$objDemo->accion = "Devolución";
				$objDemo->email = $email;
				$objDemo->empresa = Empresa::find(Session('empresa'))->nombre;
				$objDemo->comentario = $comentario;
				$objDemo->idPedido = $idpedido;
				$objDemo->precio = $transaccion->amount;
				$objDemo->tipopago = $request->get('pedido')['tipopago_nombre'];
				$objDemo->codTransact = $transaccion->transId.' / '.$transaccion->id;
				$objDemo->codTransactRefund = $transaccion->idRefund;
				//Mail::to("jaironavezaroca@gmail.com")->send(new Email_PagadoCulqi($objDemo));
				Mail::to($email)->send(new Email_PagadoCulqi($objDemo));
			}
		}
		catch (\Exception $e) {
			dd($e);
			$mensaje = 'Hubo un error, intente nuevamente más tarde';
			return $mensaje;
			DB::rollback();
		}
        try { event( new ChangeStateOrderEvent(["pedido" => $request->pedido, "state" => 'CANCELADO', "comentario" => $comentario], $idCliente));} catch (\Throwable $th) {}
	}

	static function cancelartodos(Request $request){
		$comentario = $request->get('comentario');
		$pedidos = $request->get('pedidos');
		$id_pedidos = array();
		foreach ($pedidos as $item) {
			$id_pedidos[] = $item['idpedido'];
		}
		Pedidos::cancelarvarios($id_pedidos, $comentario);
		foreach ($pedidos as $item) {
			$idCliente = $item['idusuario'];
			try { event( new ChangeStateOrderEvent(["pedido" => $item, "state" => 'CANCELADO', "comentario" => $comentario], $idCliente));} catch (\Throwable $th) {}
		}
	}

	static function funcion(Request $request){
	}
}
