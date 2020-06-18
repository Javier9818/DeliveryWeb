<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Pedidos;
use App\Producto;
use App\Events\ChangeStateOrderEvent;

class ContabilidadController extends Controller
{
	public function fn1(Request $request){
		return $this->fn('1', $request);
	}
	public function fn2(Request $request){
		return $this->fn('2', $request);
	}
	public function fn($funcion='', Request $request){
		if ($funcion == 'listartodo') return $this->listartodo($request);
		else if ($funcion == '1') return view('admin.negocio.ventas'/*, ["empresa" => session('empresa')]*/);
		else if ($funcion == '2') return view('admin.negocio.pagos'/*, ["empresa" => session('empresa')]*/);
		else return view('admin.pedidos.pedidos',  ["empresa" => session('empresa')]);
    }
}
