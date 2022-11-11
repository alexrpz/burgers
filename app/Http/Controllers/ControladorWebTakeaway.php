<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Categoria;
use App\Entidades\Sucursal;
use App\Entidades\Producto;
use App\Entidades\Carrito;
require app_path() . '/start/constants.php';

use Session;

class ControladorWebTakeaway extends Controller
{
    public function index()
    {
        $categoria = new Categoria();
        $aCategorias = $categoria->obtenerTodos();
        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();
        $sucursal = new Sucursal();
        $aSucursal = $sucursal->obtenerTodos();
        return view("web.takeaway", compact("aSucursal", "aProductos", "aCategorias"));
    }
    public function insertar(Request $request)
    {
        $idCliente = Session::get("idCliente");

        $idProducto = $request->input("txtProducto");
        $cantidad = $request->input("txtCantidad");

        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();

        $sucursal = new Sucursal();
        $aSucursal = $sucursal->obtenerTodos();
        
        $categoria = new Categoria();
        $aCategorias = $categoria->obtenerTodos();

        if (isset($idCliente) && $idCliente > 0) {

            if (isset($cantidad) && $cantidad > 0) {
                $carrito= new Carrito;
                $carrito->fk_idcliente = $idCliente;
                $carrito->fk_idproducto = $idProducto;
                $carrito->cantidad = $cantidad;
                $carrito->insertar();

                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = "El producto se ha agregado al carrito";
                return view('web.takeaway', compact('msg', 'aCategorias', 'aSucursal', "aProductos"));
            } else {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "No agregó ningún producto al carrito";
                return view('web.takeaway', compact('msg','aCategorias', 'aSucursal', "aProductos"));
            }
        }else{
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Debe inicar sesión para realizar un pedido";
            return view('web.takeaway', compact('msg','aCategorias', 'aSucursal', "aProductos"));
        }
    }
}
