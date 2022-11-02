<?php

namespace App\Http\Controllers;

use App\Entidades\Categoria;
use App\Entidades\Producto;
use App\Entidades\Sucursal;

class ControladorWebHome extends Controller
{
    public function index()
    {
        $categoria= new Categoria();
        $aCategorias=$categoria->obtenerTodos();
        $producto= new Producto();
        $aProductos=$producto->obtenerTodos();
        $sucursal= new Sucursal();
        $aSucursal=$sucursal->obtenerTodos();
            return view("web.index", compact("aSucursal", "aProductos", "aCategorias"));
    }
}