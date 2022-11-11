<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\Producto;
use App\Entidades\Categoria;

use Session;
class ControladorWebLogin extends Controller
{
    public function index(Request $request)
    {
        $sucursal= new Sucursal();
        $aSucursal=$sucursal->obtenerTodos();
            return view("web.login", compact("aSucursal"));
    }
    public function ingresar(Request $request)
	{
            $categoria = new Categoria();
            $aCategorias = $categoria->obtenerTodos();
            $producto= new Producto();
            $aProductos=$producto->obtenerTodos();
		$sucursal= new Sucursal();
            $aSucursal=$sucursal->obtenerTodos();
            $correo= $request->input("txtCorreo");
            $clave= $request->input("txtClave");

            $cliente= new Cliente();
            $cliente->obtenerPorCorreo($correo);
            if($cliente->correo != ""){
                  if(password_verify($clave, $cliente->clave)){
                        Session::put("idCliente", $cliente->idcliente);
                        return view("web.index", compact("aSucursal", "aProductos", "aCategorias"));
                  }else{
                        $mensaje= "Credenciales incorrectas.";
                        return view('web.login', compact('aSucursal', 'mensaje'));
                  }
            }
            
	}
      public function logout(){
            Session::put("idCliente", "");
            return redirect("/");
      }
}
