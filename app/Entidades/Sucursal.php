<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model{

	protected $table = 'sucursales';
	public $timestamps = false;

	protected $fillable = [
		'idsucursal', 'nombre', 'direccion', 'telefono', 'link', 'horario',
	];

	protected $hidden = [];

	public function cargarDesdeRequest($request)
	{
		$this->idsucursal = $request->input('id') != "0" ? $request->input('id') : $this->idsucursal;
		$this->nombre = $request->input('txtNombre');
		$this->direccion = $request->input('txtDireccion');
		$this->telefono = $request->input('txtTelefono');
		$this->link = $request->input('txtLink');
		$this->horario = $request->input('txtHorario');
	}

	public function obtenerTodos()
	{
		$sql = "SELECT
				idsucursal,
				nombre,
				direccion,
				telefono,
				link,
				horario             
                FROM sucursales A ORDER BY nombre ASC";
		$lstRetorno = DB::select($sql);
		return $lstRetorno;
	}

	public function obtenerPorId($idSucursal)
	{
		$sql = "SELECT
                idsucursal,
				nombre,
				direccion,
				telefono,
				link,
				horario
                FROM sucursales WHERE idsucursal = $idSucursal";
		$lstRetorno = DB::select($sql);

		if (count($lstRetorno) > 0) {
			$this->idsucursal = $lstRetorno[0]->idsucursal;
			$this->nombre = $lstRetorno[0]->nombre;
			$this->direccion = $lstRetorno[0]->direccion;
			$this->telefono = $lstRetorno[0]->telefono;
			$this->link = $lstRetorno[0]->link;
			$this->horario = $lstRetorno[0]->horario;
			return $this;
		}
		return null;
	}

	public function guardar()
	{
		$sql = "UPDATE sucursales SET
            nombre='$this->nombre',
            direccion='$this->direccion',
            telefono=$this->telefono,
            link='$this->link',
		horario='$this->horario'
            WHERE idsucursal=?";
		$affected = DB::update($sql, [$this->idsucursal]);
	}

	public function eliminar()
	{
		$sql = "DELETE FROM sucursales WHERE idsucursal=?";
		$affected = DB::delete($sql, [$this->idsucursal]);
	}

	public function insertar()
	{
		$sql = "INSERT INTO sucursales (
                nombre,
                direccion,
                telefono,
                link,
		    horario
            ) VALUES (?, ?, ?, ?, ?);";
		$result = DB::insert($sql, [
			$this->nombre,
			$this->direccion,
			$this->telefono,
			$this->link,
			$this->horario,
		]);
		return $this->idsucursal = DB::getPdo()->lastInsertId();
	}
}
