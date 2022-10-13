<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Tipo_producto;
require app_path() . '/start/constants.php';

class ControladorTipo_producto extends Controller{
      public function nuevo()
      {
			$titulo= "Nueva Tipo_producto";
            return view('sistema.Tipo_producto-nuevo', compact('titulo'));
      }
	public function index(){
		$titulo= "Listado de Tipo_productos";
		return view("sistema.Tipo_producto-listar", compact("titulo"));
	}
	 
      public function guardar(Request $request){
			try {
				//Define la entidad servicio
				$titulo = "Modificar Tipo_producto";
				$entidad = new Tipo_producto();
				$entidad->cargarDesdeRequest($request);
	
				//validaciones
				if ($entidad->nombre == "" || $entidad->telefono == "" || $entidad->correo == "" || $entidad->clave == "") {
					$msg["ESTADO"] = MSG_ERROR;
					$msg["MSG"] = "Complete todos los datos";
				} else {
					if ($_POST["id"] > 0) {
						//Es actualizacion
						$entidad->guardar();
	
						$msg["ESTADO"] = MSG_SUCCESS;
						$msg["MSG"] = OKINSERT;
					} else {
						//Es nuevo
						$entidad->insertar();
	
						$msg["ESTADO"] = MSG_SUCCESS;
						$msg["MSG"] = OKINSERT;
					}
					$_POST["id"] = $entidad->idTipo_producto;
					return view('sistema.Tipo_producto-listar', compact('titulo', 'msg'));
				}
			} catch (Exception $e) {
				$msg["ESTADO"] = MSG_ERROR;
				$msg["MSG"] = ERRORINSERT;
			}
	
			$id = $entidad->idTipo_producto;
			$Tipo_producto = new Tipo_producto();
			$Tipo_producto->obtenerPorId($id);
			return view('sistema.Tipo_producto-nuevo', compact('msg', 'Tipo_producto', 'titulo')) . '?id=' . $Tipo_producto->idTipo_producto;
      }
	public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Tipo_producto();
        $aTipo_productos = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aTipo_productos) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/sistema/Tipo_productos/' . $aTipo_productos[$i]->idTipo_productos . '">' . $aTipo_productos[$i]->nombre . '</a>';
            $row[] = "<a href='/admin/Tipo_producto/" . $aTipo_productos[$i]->nombre . "'>" . $aTipo_productos[$i]->nombre . "</a>";
            $row[] = $aTipo_productos[$i]->nombre;
            $row[] = $aTipo_productos[$i]->descripcion;
		$row[] = $aTipo_productos[$i]->precio;
		$row[] = $aTipo_productos[$i]->cantidad;
		$row[] = $aTipo_productos[$i]->imagen;
		$row[] = $aTipo_productos[$i]->fk_idtipoTipo_producto;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aTipo_productos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aTipo_productos), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
}
