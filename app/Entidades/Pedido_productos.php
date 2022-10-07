<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido_Productos{

	protected $table = 'pedido_productos';
    public $timestamps = false;

    protected $fillable = [
        'idpedidoproducto', 'fk_idproducto', 'fk_idpedido',
    ];

    protected $hidden = [

    ];

	public function cargarDesdeRequest($request) {
        $this->idpedidoproducto = $request->input('id') != "0" ? $request->input('id') : $this->idpedidoproducto;
        $this->fk_idproducto = $request->input('lstProducto');
        $this->fk_idpedido = $request->input('lstPedido');
    }

	public function obtenerTodos()
    {
        $sql = "SELECT
				idpedidoproducto,
                fk_idproducto,
				fk_idpedido              
                FROM pedido_productos A ORDER BY nombre ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

	public function obtenerPorId($idPedidoProducto)
    {
        $sql = "SELECT
                idpedidoproducto,
                fk_idproducto,
				fk_idpedido 
                FROM pedido_productos WHERE idpedidoproducto = $idPedidoProducto";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idpedidoproducto = $lstRetorno[0]->idpedidoproducto;
            $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
			$this->fk_idpedido = $lstRetorno[0]->fk_idpedido;
            return $this;
        }
        return null;
    }

	public function guardar() {
        $sql = "UPDATE pedido_productos SET
            fk_idproducto='$this->fk_idproducto', 
			fk_idpedido='$this->fk_idpedido',          
            WHERE idpedidoproducto=?";
        $affected = DB::update($sql, [$this->idpedidoproducto]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM pedido_productos WHERE
            idpedidoproducto=?";
        $affected = DB::delete($sql, [$this->idpedidoproducto]);
    }

	public function insertar()
    {
        $sql = "INSERT INTO pedido_productos (
                fk_idproducto,
				fk_idpedido 
            ) VALUES (?);";
        $result = DB::insert($sql, [
            $this->fk_idproducto,
			$this->fk_idpedido,
        ]);
        return $this->idpedidoproducto = DB::getPdo()->lastInsertId();
    }
}
