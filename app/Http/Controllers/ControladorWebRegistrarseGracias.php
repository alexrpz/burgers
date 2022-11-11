<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sucursal;

require app_path() . '/start/constants.php';

class ControladorWebRegistrarseGracias extends Controller
{

      public function index()
      {
            $sucursal= new Sucursal();
            $aSucursal=$sucursal->obtenerTodos();
            return view("web.registrarse-gracias", compact("aSucursal"));
      }
      }