<?php
namespace App\Http\Controllers;

use App\Entidades\Cliente;
use Illuminate\Http\Request;
use App\Entidades\Pedido;
use App\Entidades\Estado;

require app_path() . '/start/constants.php';
class ControladorPedido extends Controller{
      public function nuevo()
      {		
			$titulo= "Nuevo pedido";
            	$estado= new Estado();
			$aEstados= $estado->obtenerTodos();
			$pedido= new Pedido();
			$aPedidos= $pedido->obtenerTodos();
			$cliente= new Cliente();
			$aClientes= $cliente->obtenerTodos();
            return view("sistema.pedido-nuevo",compact("titulo", 'estado', 'pedido', 'cliente'));
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
				if ($entidad->total == "" || $entidad->fecha == "" || $entidad->fk_idPedido == "" || $entidad->fk_idestado == "" || $entidad->fk_idsucursal == "" ) {
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
			return view('sistema.pedido-nuevo', compact('msg', 'pedido', 'titulo')) . '?id=' . $pedido->idpedido;
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
            $row[] = $aPedidos[$i]->total;
            $row[] = $aPedidos[$i]->fecha;
		$row[] = $aPedidos[$i]->fk_idcliente;
		$row[] = $aPedidos[$i]->fk_idestado;
		$row[] = $aPedidos[$i]->fk_idsucursal;
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
	return view("sistema.pedido-nuevo", compact("titulo", "pedido"));
    }
}

?>