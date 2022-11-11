<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model{

	protected $table = 'carritos';
    public $timestamps = false;

    protected $fillable = [
        'idcarrito', 'fk_idcliente', 'fk_idproducto', 'cantidad'
    ];

    protected $hidden = [];

    private $producto;
    private $precio;
    private $cantidad;

	public function cargarDesdeRequest($request) {
        $this->idcarrito = $request->input('id') != "0" ? $request->input('id') : $this->idcarrito;
        $this->fk_idcliente = $request->input('lstCliente');
        $this->fk_idproducto = $request->input('lstProducto');
        $this->cantidad = $request->input('txtCantidad');
    }

	public function obtenerTodos()
    {
        $sql = "SELECT
				idcarrito,
                fk_idcliente, 
				fk_idproducto,
                cantidad             
                FROM carritos A ORDER BY nombre ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
    public function obtenerPorCliente($idCliente)
    {
        $sql = "SELECT DISTINCT
                A.idcarrito,
                A.fk_idcliente, 
				A.fk_idproducto,  
                A.cantidad,
                
                B.precio AS precio,
                B.cantidad AS cantidad
                FROM carritos A
                INNER JOIN productos B ON A.fk_idproducto = B.idproducto
                WHERE fk_idcliente= $idCliente";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
	public function obtenerPorId($idCarrito)
    {
        $sql = "SELECT
                idcarrito,
				fk_idproducto,
				fk_idcliente,
                cantidad 
                FROM carritos WHERE idcarrito = $idCarrito";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcarrito = $lstRetorno[0]->idcarrito;
            $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            $this->cantidad = $lstRetorno[0]->cantidad;
            return $this;
        }
        return null;
    }

	public function guardar() {
        $sql = "UPDATE carritos SET
            fk_idcliente=$this->fk_idcliente,
            fk_idproducto=$this->fk_idproducto,
            cantidad=$this->cantidad
            WHERE idcarrito=?";
        $affected = DB::update($sql, [$this->idcarrito]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM carritos WHERE
            idcarrito=?";
        $affected = DB::delete($sql, [$this->idcarrito]);
    }

	public function insertar()
    {
        $sql = "INSERT INTO carritos (
                fk_idproducto,
				fk_idcliente,
                cantidad 
            ) VALUES (?, ?, ?);";
        $result = DB::insert($sql, [
            $this->fk_idcliente,
            $this->fk_idproducto,
            $this->cantidad,
        ]);
        return $this->idcarrito = DB::getPdo()->lastInsertId();
    }
}
