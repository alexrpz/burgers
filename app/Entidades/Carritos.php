<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Carritos{

	protected $table = 'carritos';
    public $timestamps = false;

    protected $fillable = [
        'idcarrito', 'fk_idcliente', 'fk_idproducto',
    ];

    protected $hidden = [

    ];

	public function cargarDesdeRequest($request) {
        $this->idcarrito = $request->input('id') != "0" ? $request->input('id') : $this->idcarrito;
        $this->fk_idcliente = $request->input('fk_idcliente');
        $this->fk_idproducto = $request->input('fk_idproducto');
    }

	public function obtenerTodos()
    {
        $sql = "SELECT
				idcliente,
				nombre,
				apellido,
				telefono,
				correo, 
				dni, 
				clave              
                FROM clientes A ORDER BY nombre ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

	public function obtenerPorId($idCliente)
    {
        $sql = "SELECT
                idcliente,
				nombre,
				apellido,
				telefono,
				correo, 
				dni, 
				clave 
                FROM clientes WHERE idcliente = $idCliente";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idmenu = $lstRetorno[0]->idcliente;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->telefono = $lstRetorno[0]->telefono;
            $this->correo = $lstRetorno[0]->correo;
            $this->dni = $lstRetorno[0]->dni;
            $this->clave = $lstRetorno[0]->clave;
            return $this;
        }
        return null;
    }

	public function guardar() {
        $sql = "UPDATE clientes SET
            nombre='$this->nombre',
            apellido='$this->apellido',
            telefono='$this->telefono',
            correo='$this->correo',
            dni='$this->dni',
            clave='$this->clave'
            WHERE idcliente=?";
        $affected = DB::update($sql, [$this->idcliente]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM clientes WHERE
            idcliente=?";
        $affected = DB::delete($sql, [$this->idcliente]);
    }

	public function insertar()
    {
        $sql = "INSERT INTO clientes (
                nombre,
                apellido,
                telefono,
                correo,
                dni,
                clave
            ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->nombre,
            $this->apellido,
            $this->telefono,
            $this->correo,
            $this->dni,
            $this->clave,
        ]);
        return $this->idcliente = DB::getPdo()->lastInsertId();
    }
}
