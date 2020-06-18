<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\PedidosUsers;

class Pedidos extends Model
{
	protected $table = 'pedidos';
	protected $fillable = [
		'id',
		'empresa_id',
		'estado',
		'comentario',
		'latitud',
		'longitud',
		'direccion',
		'meta_latitud',
		'meta_longitud',
		'user_id',
		'tipo_id',
		'created_at',
		'updated_at'
	];
	//update_at as fecha_entrega
	protected $casts = [
		'updated_at' => 'datetime:d/m/Y h:i a',
		'fecha_entrega' => 'datetime:d/m/Y h:i a'
	];

	public static function listar($empresa_id, $tipo, $fecha){
		$where = array('pedidos.empresa_id' => $empresa_id);
		if ($tipo == 'Todo'){
			$where['pedidos.estado'] = 'Pendiente';
		}
		if ($tipo == 'Recepcion'){
			$where['pedidos.estado'] = 'Aceptado';
			$where['pedidos.tipo_id'] = 2;
		}
		if ($tipo == 'Delivery'){
			$where['pedidos.estado'] = 'Aceptado';
			$where['pedidos.tipo_id'] = 1;
		}
		if ($tipo == 'listarPedidos'){
			$where['pedidos.estado'] = 'ENTREGADO';
		}
		$bul = false;
		if ($fecha != 'Hoy'){
			$bul = true;
		}
		else{
			$fecha = '';
		}
		return static::consultaPedido($where, $bul, $fecha);
	}
	public static function obtenerPedido($id_pedido){
		$where = array('pedidos.id' => $id_pedido);
		return static::consultaPedido($where, false, '')->first();
	}
	public static function consultaPedido($where, $bul, $fecha){
		$select = array(
			'pedidos.id as idpedido',
			DB::raw("GROUP_CONCAT(dp.producto_id) as ids"),
			DB::raw("GROUP_CONCAT(dp.cantidad) as cantidades")
		);
		if ($bul){
			$select[] = DB::raw("sum(dp.precio_unit * dp.cantidad) as monto");
			$select[] = 'pedidos.updated_at as fecha_entrega';
		}
		else{
			$select[] = 'personas.id as idusuario';
			$select[] = DB::raw("CONCAT(personas.appaterno, ' ', personas.apmaterno, ', ', personas.nombres) as nombres");
			$select[] = 'personas.celular';
			$select[] = 'personas.direccion';
			$select[] = 'te.nombre as tipo_entrega';
		}
		return Pedidos::whereRaw('pedidos.updated_at like ?', $fecha.'%')->where($where)
			->select($select)
			->join('detalle_pedidos as dp', 'dp.pedido_id', '=', 'pedidos.id')
			->join('users as u', 'u.id', '=', 'pedidos.user_id')
			->join('personas as personas', 'personas.id', '=', 'u.persona_id')
			->join('tipo_entregas as te', 'te.id', '=', 'pedidos.tipo_id')
			->groupBy('pedidos.id')
			->get();
	}
	public static function entregar($idpedido){
		return Pedidos::where('id', $idpedido)
			->update([
				'estado' => 'ENTREGADO'
			]);
	}
	public static function aceptar($idpedido){
		return Pedidos::where('id', $idpedido)
			->update([
				'estado' => 'ACEPTADO'
			]);
	}
	public static function cancelar($idpedido, $comentario){
		return Pedidos::where('id', $idpedido)
			->update([
				'estado' => 'CANCELADO',
				'comentario' => $comentario
			]);
	}
	public static function cancelarvarios($id_pedidos, $comentario){
		return Pedidos::whereIn('id', $id_pedidos)
			->update([
				'estado' => 'CANCELADO',
				'comentario' => $comentario
			]);
	}

	public static function listarEmpleados($empresa_id){
		$where = array(
			'ue.empresa_id' => $empresa_id,
			'permiso_id' => 5
		);
		return DB::table('personas')
			->where($where)
			->select(
				'personas.id as id',
				DB::raw("CONCAT(personas.appaterno, ' ', personas.apmaterno, ', ', personas.nombres) as nombres")
				//'personas.dni',
				//'personas.celular'
			)
			->join('users as u', 'u.persona_id', '=', 'personas.id')
			->join('users_empresas as ue', 'ue.user_id', '=', 'u.id')
			->join('permiso_user as pu', 'pu.user_id', '=', 'ue.user_id')
			->get();
	}
	public static function asignar($idpedido, $idrepartidor){
		Pedidos::where('id', $idpedido)
			->update([
				'estado' => 'ENVIANDO'
			]);
		return PedidosUsers::create([
				'pedidos_id' => $idpedido,
				'users_id' => $idrepartidor
			]);
	}
}





/*
Laravel : Syntax error or access violation: 1055 Error
https://stackoverflow.com/questions/40917189/laravel-syntax-error-or-access-violation-1055-error
-------------- lista de pedidos, datos del pedido y del usuario
select
	pe.id as idpedido,
	GROUP_CONCAT(dp.producto_id) AS ids,
	GROUP_CONCAT(dp.cantidad) AS cantidades,
	p.id as idusuario, p.nombres, p.appaterno, p.apmaterno, p.celular, p.direccion
from pedidos pe
join detalle_pedidos dp on pe.id = dp.pedido_id
join users u on u.id = pe.user_id
join personas p on p.id = u.persona_id
where pe.empresa_id = 1
group by(pe.id)
;

-------------- pedir productos de todos los pedidos de una empresa de manera separada
select distinct pr.id, pr.nombre, pr.descripcion, pr.foto, pr.precio, cm.descripcion
from productos pr
join categorias_menus cm on cm.id = pr.categorias_menu_id
-- join detalle_pedidos dp on dp.producto_id = pr.id
-- join pedidos pe on pe.id = dp.pedido_id
where pr.estado = 1 and pr.empresa_id = 1
;

---------------- empleados con el rol 5, repartidor Deliveryselect p.id, nombres, dni, celular, direccion
from personas p
join users u on u.persona_id = p.id
join users_empresas ue on ue.user_id = u.id
join permiso_user pu on pu.user_id = ue.user_id
where ue.empresa_id = 1 and permiso_id = 5
*/
