<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Rubro;
require app_path() . '/start/constants.php';

class ControladorRubro extends Controller{
      public function nuevo()
      {
			$titulo= "Nuevo rubro";
			$rubro= new Rubro();
            return view('sistema.rubro-nuevo', compact('titulo', 'rubro'));
      }
	public function index(){
		$titulo= "Listado de rubros";
		return view("sistema.rubro-listar", compact("titulo"));
	}
	 
      public function guardar(Request $request){
			try {
				//Define la entidad servicio
				$titulo = "Modificar rubro";
				$entidad = new Rubro();
				$entidad->cargarDesdeRequest($request);
	
				//validaciones
				if ($entidad->nombre == "") {
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
					$_POST["id"] = $entidad->idrubro;
					return view('sistema.rubro-listar', compact('titulo', 'msg'));
				}
			} catch (Exception $e) {
				$msg["ESTADO"] = MSG_ERROR;
				$msg["MSG"] = ERRORINSERT;
			}
	
			$id = $entidad->idrubro;
			$rubro = new Rubro();
			$rubro->obtenerPorId($id);
			return view('sistema.rubro-nuevo', compact('msg', 'rubro', 'titulo')) . '?id=' . $rubro->idrubro;
      }
	public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Rubro();
        $aRubros = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aRubros) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = "<a href='/admin/rubro/" . $aRubros[$i]->idrubro . "'>" . $aRubros[$i]->nombre . "</a>";
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aRubros), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aRubros), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
    public function editar($idRubro){
	$titulo= "Editar rubro";
	$rubro= new Rubro();
	$rubro->obtenerPorId($idRubro);
	return view("sistema.rubro-nuevo", compact("titulo", "rubro"));
    }
    public function eliminar(Request $request){
	$idrubro = $request->input("id");
		$rubro= new Rubro();
		$rubro->idrubro = $idrubro;
		$rubro->eliminar();
		$resultado["err"] = EXIT_SUCCESS;
		$resultado["mensaje"] = "Registro eliminado exitosamente";
	return json_encode($resultado);
    }
}
