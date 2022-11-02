<?php

namespace App\Http\Controllers;

use App\Entidades\Categoria;
use App\Entidades\Sucursal;
use App\Entidades\Producto;
require app_path() . '/start/constants.php';
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
}

