<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sucursal;
use App\Entidades\Carrito;
use App\Entidades\Pedido;
require app_path().'/start/constants.php';

use Session;
class ControladorWebCarrito extends Controller
{
    public function index()
    {
		$idCliente= Session::get("idCliente");
        $carrito= new Carrito();
		$aCarritos= $carrito->obtenerPorCliente($idCliente);
        $sucursal= new Sucursal();
        $aSucursal=$sucursal->obtenerTodos();
		print_r($aCarritos);exit;
            return view("web.carrito", compact("aSucursal", "aCarritos"));
    }
    public function procesar(Request $request)
    {
        if(isset($_POST["btnBorrar"])){
            $this->eliminar($request);
        }else if(isset($_POST["btnActualizar"])){
            $this->actualizar($request);
        }else if(isset($_POST["btnBorrar"])){
            $this->insertarPedido($request);
        }
    }
    public function actualizar(Request $request)
	{

        $carrito= new Carrito();
        $idCarrito= $request->input("txtCarrito");
		$cantidad= $request->input("txtCantidad");
        $idProducto= $request->input("txtProducto");
        $idCliente= Session::get("idCliente");

        $carrito->idcarrito= $idCarrito;
        $carrito->cantidad= $cantidad;
        $carrito->fk_idcliente= $idCliente;
        $carrito->fk_idproducto= $idProducto;
		$carrito->guardar();
        $resultado["err"] = EXIT_SUCCESS;
        $resultado["mensaje"]= "Producto actualizado exitosamente.";

        $carrito= new Carrito();
		$aCarritos= $carrito->obtenerPorCliente($idCliente);
        $sucursal= new Sucursal();
        $aSucursal=$sucursal->obtenerTodos();
        return view('web.carrito', compact('resultado',"aSucursal", "aCarritos"));
	}
    public function eliminar(Request $request)
    {
        $idCliente= Session::get("idCliente");
        $idCarrito= $request->input("txtCarrito");
        $carrito = new Carrito();
        $carrito->idcarrito= $idCarrito;
        $carrito->eliminar();
        $resultado["err"] = EXIT_SUCCESS;
        $resultado["mensaje"]= "Producto eliminado exitosamente.";
        $carrito= new Carrito();
		$aCarritos= $carrito->obtenerPorCliente($idCliente);
        $sucursal= new Sucursal();
        $aSucursal=$sucursal->obtenerTodos();
        return view('web.carrito', compact('resultado',"aSucursal", "aCarritos"));
	
    }
    public function insertarPedido(Request $request){
        $idCliente= Session::get("idCliente");
        $carrito= new Carrito();
		$aCarritos= $carrito->obtenerPorCliente($idCliente);
        $sucursal= new Sucursal();
        $aSucursal=$sucursal->obtenerTodos();

        $total = 0;
        foreach ($aCarritos as $carrito){
            $total = $carrito->cantidad * $carrito->precio;
        }
        $sucursal = $request->input("lstSucursal");
        $pago = $request->input("lstPago");
        $fecha = date("Y-m-d");

        $pedido= new Pedido();
        $pedido->fk_idsucursal = $sucursal;
        $pedido->fk_idcliente = $idCliente;
        $pedido->fk_idestado = 1;
        $pedido->fecha = $fecha;
        $pedido->total = $total;

        $pedido->insertar();

        $msg["err"]= MSG_SUCCESS;
        $msg["mensaje"] = "El pedido se ha confirmado correctamente.";
        return view ('web.carrito', compact('msg', 'aSucursal', 'aCarritos'));
    }
}
