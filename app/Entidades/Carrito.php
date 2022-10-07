<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model{

	protected $table = 'carritos';
    public $timestamps = false;

    protected $fillable = [
        'idcarrito', 'fk_idcliente', 'fk_idproducto',
    ];

    protected $hidden = [

    ];

	public function cargarDesdeRequest($request) {
        $this->idcarrito = $request->input('id') != "0" ? $request->input('id') : $this->idcarrito;
        $this->fk_idcliente = $request->input('lstCliente');
        $this->fk_idproducto = $request->input('lstProducto');
    }

	public function obtenerTodos()
    {
        $sql = "SELECT
				idcarrito,
                fk_idcliente, 
				fk_idproducto              
                FROM carritos A ORDER BY nombre ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

	public function obtenerPorId($idCarrito)
    {
        $sql = "SELECT
                idcarrito,
				fk_idproducto,
				fk_idcliente 
                FROM carritos WHERE idcarrito = $idCarrito";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcarrito = $lstRetorno[0]->idcarrito;
            $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            return $this;
        }
        return null;
    }

	public function guardar() {
        $sql = "UPDATE carritos SET
            fk_idcliente=$this->fk_idcliente,
            fk_idproducto=$this->fk_idproducto
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
				fk_idcliente 
            ) VALUES (?, ?);";
        $result = DB::insert($sql, [
            $this->fk_idcliente,
            $this->fk_idproducto,
        ]);
        return $this->idcarrito = DB::getPdo()->lastInsertId();
    }
}
