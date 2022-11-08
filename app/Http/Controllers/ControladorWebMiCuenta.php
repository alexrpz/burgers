<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Cliente;
use App\Entidades\Sucursal;
require app_path() . '/start/constants.php';

class ControladorWebMiCuenta extends Controller
{
    public function index()
    {
        $sucursal = new Sucursal();
        $aSucursal = $sucursal->obtenerTodos();
        $idCliente = 6;
        $cliente = new Cliente();
        $cliente->obtenerPorId($idCliente);
            return view("web.mi-cuenta", compact("aSucursal", "cliente"));
    }

    public function guardar(Request $request)
    {

    }
}