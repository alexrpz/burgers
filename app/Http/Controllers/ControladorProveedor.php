<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Proveedor;
use App\Entidades\Rubro;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;

require app_path() . '/start/constants.php';

class ControladorProveedor extends Controller
{
	public function nuevo()
	{
		$titulo = "Nuevo proveedor";
		if (Usuario::autenticado() == true) {
			if (!Patente::autorizarOperacion("PROVEEDORALTA")) {
				$codigo = "PROVEEDORALTA";
				$mensaje = "No tiene permisos para la operaci&oacute;n.";
				return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
			} else {
				$proveedor = new Proveedor();
				$rubro = new Rubro();
				$aRubros = $rubro->obtenerTodos();
				return view('sistema.proveedor-nuevo', compact("titulo", 'proveedor', 'aRubros'));
			}
		} else {
			return redirect('admin/login');
		}
	}
	public function index()
	{
		$titulo = "Listado de proveedores";
		if (Usuario::autenticado() == true) {
			if (!Patente::autorizarOperacion("PROVEEDORCONSULTA")) {
				$codigo = "PROVEEDORCONSULTA";
				$mensaje = "No tiene permisos para la operaci&oacute;n.";
				return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
			} else {
				return view("sistema.proveedor-listar", compact("titulo"));
			}
		} else {
			return redirect('admin/login');
		}
	}

	public function guardar(Request $request)
	{
		try {
			//Define la entidad servicio
			$titulo = "Modificar proveedor";
			$entidad = new Proveedor();
			$entidad->cargarDesdeRequest($request);

			//validaciones
			if ($entidad->nombre == "" || $entidad->domicilio == "" || $entidad->telefono == "" || $entidad->cuit == "" || $entidad->fk_idrubro == "") {
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
				$_POST["id"] = $entidad->idproveedor;
				return view('sistema.proveedor-listar', compact('titulo', 'msg'));
			}
		} catch (Exception $e) {
			$msg["ESTADO"] = MSG_ERROR;
			$msg["MSG"] = ERRORINSERT;
		}

		$id = $entidad->idproveedor;
		$proveedor = new Proveedor();
		$proveedor->obtenerPorId($id);
		$rubro = new Rubro();
		$aRubros = $rubro->obtenerTodos();
		return view('sistema.proveedor-nuevo', compact('msg', 'proveedor', 'titulo', 'aRubros')) . '?id=' . $proveedor->idproveedor;
	}
	public function cargarGrilla()
	{
		$request = $_REQUEST;

		$entidad = new Proveedor();
		$aProveedores = $entidad->obtenerFiltrado();

		$data = array();
		$cont = 0;

		$inicio = $request['start'];
		$registros_por_pagina = $request['length'];


		for ($i = $inicio; $i < count($aProveedores) && $cont < $registros_por_pagina; $i++) {
			$row = array();
			$row[] = "<a href='/admin/proveedor/" . $aProveedores[$i]->idproveedor . "'>" . $aProveedores[$i]->nombre . "</a>";
			$row[] = $aProveedores[$i]->domicilio;
			$row[] = $aProveedores[$i]->telefono;
			$row[] = $aProveedores[$i]->cuit;
			$row[] = $aProveedores[$i]->rubro;
			$cont++;
			$data[] = $row;
		}

		$json_data = array(
			"draw" => intval($request['draw']),
			"recordsTotal" => count($aProveedores), //cantidad total de registros sin paginar
			"recordsFiltered" => count($aProveedores), //cantidad total de registros en la paginacion
			"data" => $data,
		);
		return json_encode($json_data);
	}
	public function editar($idProveedor)
	{
		$titulo = "Editar Proveedor";
		if (Usuario::autenticado() == true) {
			if (!Patente::autorizarOperacion("PROVEEDOREDITAR")) {
				$codigo = "PROVEEDORALTA";
				$mensaje = "No tiene permisos para la operaci&oacute;n.";
				return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
			} else {
				$proveedor = new Proveedor();
				$proveedor->obtenerPorId($idProveedor);
				$rubro = new Rubro();
				$aRubros = $rubro->obtenerTodos();
				return view("sistema.proveedor-nuevo", compact("titulo", "proveedor", 'aRubros'));
			}
		} else {
			return redirect('admin/login');
		}
	}
	public function eliminar(Request $request)
	{
		
		if (Usuario::autenticado() == true) {
			if (!Patente::autorizarOperacion("PROVEEDORELIMINAR")) {
				$resultado["err"] = EXIT_FAILURE;
			} else {
				$idProveedor = $request->input("id");
				$proveedor = new Proveedor();
				$proveedor->idProveedor = $idProveedor;
				$proveedor->eliminar();
				$resultado["err"] = EXIT_SUCCESS;
				$resultado["mensaje"] = "Registro eliminado exitosamente";
		  } 
		}else {
			$resultado["err"] = EXIT_FAILURE;
			$resultado["mensaje"] = "Usuario no autenticado";
		  }
		  return json_encode($resultado);
		}
	}

