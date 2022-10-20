<?php
namespace App\Http\Controllers;

use App\Entidades\Cliente;
use Illuminate\Http\Request;
use App\Entidades\Pedido;
use App\Entidades\Estado;
use App\Entidades\Sucursal;

require app_path() . '/start/constants.php';
class ControladorPedido extends Controller{
      public function nuevo()
      {		
			$titulo= "Nuevo pedido";
			$pedido= new Pedido();
			$aPedidos= $pedido->obtenerTodos();
            	$estado= new Estado();
			$aEstados= $estado->obtenerTodos();
			$cliente= new Cliente();
			$aClientes= $cliente->obtenerTodos();
			$sucursal= new Sucursal();
			$aSucursal= $sucursal->obtenerTodos();
            return view("sistema.pedido-nuevo",compact("titulo", 'aEstados', 'pedido', 'aClientes', 'aSucursal'));
      }
      public function index(){
		$titulo= "Listado de pedidos";
		return view("sistema.pedido-listar", compact("titulo"));
	}
      public function guardar(Request $request){
			try {
				//Define la entidad servicio
				$titulo = "Modificar pedido";
				$entidad = new Pedido();
				$entidad->cargarDesdeRequest($request);
	
				//validaciones
				if ($entidad->total == "" || $entidad->fecha == "" || $entidad->fk_idcliente == "" || $entidad->fk_idestado == "" || $entidad->fk_idsucursal == "" ) {
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
					$_POST["id"] = $entidad->idpedido;
					return view('sistema.pedido-listar', compact('titulo', 'msg'));
				}
			} catch (Exception $e) {
				$msg["ESTADO"] = MSG_ERROR;
				$msg["MSG"] = ERRORINSERT;
			}
	
			$id = $entidad->idpedido;
			$pedido = new Pedido();
			$pedido->obtenerPorId($id);
			return view('sistema.pedido-nuevo', compact('msg', 'titulo', 'aEstados', 'pedido', 'aClientes', 'aSucursal')) . '?id=' . $pedido->idpedido;
      }
	public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Pedido();
        $aPedidos = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aPedidos) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = "<a href='/admin/pedido/" . $aPedidos[$i]->idpedido . "'>" . $aPedidos[$i]->idpedido . "</a>";
            $row[] = "$". number_format($aPedidos[$i]->total, 2,".");
            $row[] = date_format(date_create($aPedidos[$i]->fecha),"Y/m/d H:i:s");
		$row[] = $aPedidos[$i]->cliente;
		$row[] = $aPedidos[$i]->estado;
		$row[] = $aPedidos[$i]->sucursal;
            $cont++;
            $data[] = $row;
        }
        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aPedidos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aPedidos), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
    public function editar($idPedido){
	$titulo= "Editar pedido";
	$pedido= new Pedido();
	$pedido->obtenerPorId($idPedido);
	$estado= new Estado();
	$aEstados= $estado->obtenerTodos();
	$cliente= new Cliente();
	$aClientes= $cliente->obtenerTodos();
	$sucursal= new Sucursal();
	$aSucursal= $sucursal->obtenerTodos();
	return view("sistema.pedido-nuevo", compact("titulo", 'aEstados', 'pedido', 'aClientes', 'aSucursal'));
    }
    public function eliminar(Request $request){
	$idPedido = $request->input("id");
		//Sino si
		$pedido= new Pedido();
		$pedido->idpedido = $idPedido;
		$pedido->eliminar();
		$resultado["err"] = EXIT_SUCCESS;
		$resultado["mensaje"] = "Pedido eliminado exitosamente";
	return json_encode($resultado);
    }
}

?>