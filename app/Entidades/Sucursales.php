<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Sucursales
{

	protected $table = 'sucursales';
	public $timestamps = false;

	protected $fillable = [
		'idsucursales', 'nombre', 'direccion', 'telefono', 'link',
	];

	protected $hidden = [];

	public function cargarDesdeRequest($request)
	{
		$this->idsucursales = $request->input('id') != "0" ? $request->input('id') : $this->idsucursales;
		$this->nombre = $request->input('txtNombre');
		$this->direccion = $request->input('txtDireccion');
		$this->telefono = $request->input('txtTelefono');
		$this->link = $request->input('txtLink');
	}

	public function obtenerTodos()
	{
		$sql = "SELECT
				idsucursales,
				nombre,
				direccion,
				telefono,
				link             
                FROM sucursales A ORDER BY nombre ASC";
		$lstRetorno = DB::select($sql);
		return $lstRetorno;
	}

	public function obtenerPorId($idSucursales)
	{
		$sql = "SELECT
                idsucursales,
				nombre,
				direccion,
				telefono,
				link
                FROM sucursales WHERE idsucursales = $idSucursales";
		$lstRetorno = DB::select($sql);

		if (count($lstRetorno) > 0) {
			$this->idsucursales = $lstRetorno[0]->idsucursales;
			$this->nombre = $lstRetorno[0]->nombre;
			$this->direccion = $lstRetorno[0]->direccion;
			$this->telefono = $lstRetorno[0]->telefono;
			$this->link = $lstRetorno[0]->link;
			return $this;
		}
		return null;
	}

	public function guardar()
	{
		$sql = "UPDATE sucursales SET
            nombre='$this->nombre',
            direccion='$this->direccion',
            telefono='$this->telefono',
            link='$this->link',
            WHERE idsucursales=?";
		$affected = DB::update($sql, [$this->idsucursales]);
	}

	public function eliminar()
	{
		$sql = "DELETE FROM sucursales WHERE
            idsucursales=?";
		$affected = DB::delete($sql, [$this->idsucursales]);
	}

	public function insertar()
	{
		$sql = "INSERT INTO sucursales (
                nombre,
                direccion,
                telefono,
                link
            ) VALUES (?, ?, ?, ?);";
		$result = DB::insert($sql, [
			$this->nombre,
			$this->direccion,
			$this->telefono,
			$this->link,
		]);
		return $this->idsucursales = DB::getPdo()->lastInsertId();
	}
}
