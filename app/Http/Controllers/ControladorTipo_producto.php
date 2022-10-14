<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Tipo_producto;
require app_path() . '/start/constants.php';

class ControladorTipo_producto extends Controller{
      public function nuevo()
      {
			$titulo= "Nuevo Tipo de producto";
            return view('sistema.categoria-nuevo', compact('titulo'));
      }
	public function index(){
		$titulo= "Listado de Categorias";
		return view("sistema.categoria-listar", compact("titulo"));
	}
	 
      public function guardar(Request $request){
			try {
				//Define la entidad servicio
				$titulo = "Modificar Tipo de producto";
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
					return view('sistema.categoria-listar', compact('titulo', 'msg'));
				}
			} catch (Exception $e) {
				$msg["ESTADO"] = MSG_ERROR;
				$msg["MSG"] = ERRORINSERT;
			}
	
			$id = $entidad->idTipo_producto;
			$Tipo_producto = new Tipo_producto();
			$Tipo_producto->obtenerPorId($id);
			return view('sistema.categoria-nuevo', compact('msg', 'Tipo_producto', 'titulo')) . '?id=' . $Tipo_producto->idTipo_producto;
      }
	public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Tipo_producto();
        $aCategorias = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aCategorias) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/sistema/categorias/' . $aCategorias[$i]->idCategorias . '">' . $aCategorias[$i]->nombre . '</a>';
            $row[] = "<a href='/admin/categoria/" . $aCategorias[$i]->nombre . "'>" . $aCategorias[$i]->nombre . "</a>";
            $row[] = $aCategorias[$i]->nombre;
            $row[] = $aCategorias[$i]->descripcion;
		$row[] = $aCategorias[$i]->precio;
		$row[] = $aCategorias[$i]->cantidad;
		$row[] = $aCategorias[$i]->imagen;
		$row[] = $aCategorias[$i]->fk_idtipoTipo_producto;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aCategorias), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aCategorias), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
    public function editar($idTipoProducto){
	$titulo= "Editar categoria";
	$TipoProducto= new Tipo_producto();
	$TipoProducto->obtenerPorId($idTipoProducto);
	return view("sistema.categoria-nuevo", compact("titulo", "tipo_producto"));
    }
}
