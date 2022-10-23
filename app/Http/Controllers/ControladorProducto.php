<?php

namespace App\Http\Controllers;

use App\Entidades\Categoria;
use Illuminate\Http\Request;
use App\Entidades\Producto;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;

require app_path() . '/start/constants.php';

class ControladorProducto extends Controller
{
	public function nuevo()
	{
		$titulo = "Nuevo producto";
		if (Usuario::autenticado() == true) {
			if (!Patente::autorizarOperacion("PRODUCTOSALTA")) {
				$codigo = "PRODUCTOSALTA";
				$mensaje = "No tiene permisos para la operaci&oacute;n.";
				return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
			} else {
				$producto = new Producto();
				$categoria = new Categoria();
				$aCategorias = $categoria->obtenerTodos();
				return view('sistema.producto-nuevo', compact('titulo', 'producto', 'aCategorias'));
			}
		} else {
			return redirect('admin/login');
		}
	}
	public function index()
	{
		$titulo = "Listado de productos";
		if (Usuario::autenticado() == true) {
			if (!Patente::autorizarOperacion("PRODUCTOCONSULTA")) {
				$codigo = "PRODUCTOCONSULTA";
				$mensaje = "No tiene permisos para la operaci&oacute;n.";
				return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
			} else {
				return view("sistema.producto-listar", compact("titulo"));
			}
		} else {
			return redirect('admin/login');
		}
	}

	public function guardar(Request $request)
	{
		try {
			//Define la entidad servicio
			$titulo = "Modificar producto";
			$entidad = new Producto();
			$entidad->cargarDesdeRequest($request);
			if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) { //Se adjunta imagen
				$extension = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);
				 $nombre = date("Ymdhmsi") . ".$extension";
				 $archivo = $_FILES["archivo"]["tmp_name"];
				 move_uploaded_file($archivo, env('APP_PATH') . "/public/files/$nombre"); //guardaelarchivo
				 $entidad->imagen = $nombre;
			   }	    
			//validaciones
			if ($entidad->nombre == "" || $entidad->fk_idcategoria == "" || $entidad->cantidad == "" || $entidad->descripcion == "" || $entidad->precio == "") {
				$msg["ESTADO"] = MSG_ERROR;
				$msg["MSG"] = "Complete todos los datos";
			} else {
				if ($_POST["id"] > 0) {
					$productAnt = new Producto();
                   		$productAnt->obtenerPorId($entidad->idproducto);

					if($_FILES["archivo"]["error"] === UPLOAD_ERR_OK){
						//Eliminar imagen anterior
						@unlink(env('APP_PATH') . "/public/files/$productAnt->imagen");                          
					  } else {
						$entidad->imagen = $productAnt->imagen;
					  }		
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
				$_POST["id"] = $entidad->idproducto;
				return view('sistema.producto-listar', compact('titulo', 'msg'));
			}
		} catch (Exception $e) {
			$msg["ESTADO"] = MSG_ERROR;
			$msg["MSG"] = ERRORINSERT;
		}

		$id = $entidad->idproducto;
		$producto = new Producto();
		$producto->obtenerPorId($id);
		$categoria = new Categoria();
		$aCategorias = $categoria->obtenerTodos();
		return view('sistema.producto-nuevo', compact('msg', 'producto', 'titulo', 'aCategorias')) . '?id=' . $producto->idproducto;
	}
	public function cargarGrilla()
	{
		$request = $_REQUEST;

		$entidad = new Producto();
		$aProductos = $entidad->obtenerFiltrado();

		$data = array();
		$cont = 0;

		$inicio = $request['start'];
		$registros_por_pagina = $request['length'];


		for ($i = $inicio; $i < count($aProductos) && $cont < $registros_por_pagina; $i++) {
			$row = array();
			$row[] = "<img class='img-thumbnail' src='/files/" . $aProductos[$i]->imagen . "'>";
			$row[] = "<a href='/admin/producto/" . $aProductos[$i]->idproducto . "'>" . $aProductos[$i]->nombre . "</a>";
			$row[] = $aProductos[$i]->descripcion;
			$row[] = $aProductos[$i]->cantidad;
			$row[] = $aProductos[$i]->categoria;
			$row[] = "$" . number_format($aProductos[$i]->precio, 2, ".");
			$cont++;
			$data[] = $row;
		}

		$json_data = array(
			"draw" => intval($request['draw']),
			"recordsTotal" => count($aProductos), //cantidad total de registros sin paginar
			"recordsFiltered" => count($aProductos), //cantidad total de registros en la paginacion
			"data" => $data,
		);
		return json_encode($json_data);
	}
	public function editar($idProducto)
	{
		$titulo = "Editar producto";
		if (Usuario::autenticado() == true) {
			if (!Patente::autorizarOperacion("PRODUCTOEDITAR")) {
				$codigo = "PRODUCTOEDITAR";
				$mensaje = "No tiene permisos para la operaci&oacute;n.";
				return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
			} else {
				$producto = new Producto();
				$producto->obtenerPorId($idProducto);
				$categoria = new Categoria();
				$aCategorias = $categoria->obtenerTodos();
				return view("sistema.producto-nuevo", compact("titulo", "producto", 'aCategorias'));
			}
		} else {
			return redirect('admin/login');
		}
	}
	public function eliminar(Request $request)
	{
		if (Usuario::autenticado() == true) {
			if (!Patente::autorizarOperacion("PRODUCTOELIMINAR")) {
				$resultado["err"] = EXIT_FAILURE;
			} else {
				$idproducto = $request->input("id");
				$producto = new Producto();
				$producto->idproducto = $idproducto;
				$producto->eliminar();
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
