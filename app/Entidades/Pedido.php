<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model{

      protected $table = 'pedidos';
    public $timestamps = false;

    protected $fillable = [
        'idpedidos', 'total', 'fecha', 'fk_idcliente', 'fk_idestado', 'fk_idsucursal',
    ];

    protected $hidden = [

    ];

	public function cargarDesdeRequest($request) {
        $this->idpedido = $request->input('id') != "0" ? $request->input('id') : $this->idpedido;
        $this->total = $request->input('txtTotal');
        $this->fecha = $request->input('txtFecha');
        $this->fk_idcliente = $request->input('lstCliente');
        $this->fk_idestado = $request->input('lstEstado');
        $this->fk_idsucursal = $request->input('lstSucursal');
    }

	public function obtenerTodos()
    {
        $sql = "SELECT
				idpedido,
				total,
				fecha,
				fk_idcliente,
				fk_idestado, 
				fk_idsucursal            
                FROM pedidos A ORDER BY idpedido ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

	public function obtenerPorId($idPedido)
    {
        $sql = "SELECT
                idpedido,
				total,
				fecha,
				fk_idcliente,
				fk_idestado, 
				fk_idsucursal 
                FROM pedidos WHERE idpedido = $idPedido";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idpedido = $lstRetorno[0]->idpedido;
            $this->total = $lstRetorno[0]->total;
            $this->fecha = $lstRetorno[0]->fecha;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            $this->fk_idestado = $lstRetorno[0]->fk_idestado;
            $this->fk_idsucursal  = $lstRetorno[0]->fk_idsucursal;
            return $this;
        }
        return null;
    }

	public function guardar() {
        $sql = "UPDATE pedidos SET
            total=$this->total,
            fecha=$this->fecha,
            fk_idcliente=$this->fk_idcliente,
            fk_idestado=$this->fk_idestado,
            fk_idsucursal=$this->fk_idsucursal
            WHERE idpedido=?";
        $affected = DB::update($sql, [$this->idpedido]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM pedidos WHERE
            idpedido=?";
        $affected = DB::delete($sql, [$this->idpedido]);
    }

	public function insertar()
    {
        $sql = "INSERT INTO pedidos (
				total,
				fecha,
				fk_idcliente,
				fk_idestado, 
				fk_idsucursal
            ) VALUES (?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->total,
            $this->fecha,
            $this->fk_idcliente,
            $this->fk_idestado,
            $this->fk_idsucursal,
        ]);
        return $this->idpedido = DB::getPdo()->lastInsertId();
    }
    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'total',
            1 => 'fecha',
            2 => 'fk_idcliente',
            3 => 'fk_idestado',
            4 => 'fk_idsucursal',
        );
        $sql = "SELECT DISTINCT
            idpedido,
            total,
            fecha,
            A.  fk_idcliente,
            A.	fk_idestado, 
            A.	fk_idsucursal,
            B.nombre AS sucursal,
            C.nombre AS cliente,
            D.nombre AS estado
            FROM pedidos A
            INNER JOIN sucursales B ON A.fk_idsucursal = B.idsucursal
            INNER JOIN clientes C ON A.fk_idcliente = C.idcliente
            INNER JOIN estados D ON A.fk_idestado = D.idestado
         WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( idpedido LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR total LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR fecha LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR fk_idcliente LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR fk_idestado LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR fk_idsucursal LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
    public function existePedidosPorCliente($idCliente){
        $sql = "SELECT
                idpedido,
				total,
				fecha,
				fk_idcliente,
				fk_idestado, 
				fk_idsucursal 
                FROM pedidos WHERE fk_idcliente = $idCliente";
        $lstRetorno = DB::select($sql);

        return (count($lstRetorno) > 0);
    }
}
?>