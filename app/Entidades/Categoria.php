<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model{

	protected $table = 'categorias';
	public $timestamps = false;

	protected $fillable = [
		'idcategorias', 'nombre',
	];

	protected $hidden = [];

	public function cargarDesdeRequest($request)
	{
		$this->idcategorias = $request->input('id') != "0" ? $request->input('id') : $this->idcategorias;
		$this->nombre = $request->input('txtNombre');
	}

	public function obtenerTodos()
	{
		$sql = "SELECT
				idcategorias,
                nombre              
                FROM categorias A ORDER BY nombre ASC";
		$lstRetorno = DB::select($sql);
		return $lstRetorno;
	}

	public function obtenerPorId($idCategoria)
	{
		$sql = "SELECT
                idcategorias,
				nombre 
                FROM categorias WHERE idcategorias = $idCategoria";
		$lstRetorno = DB::select($sql);

		if (count($lstRetorno) > 0) {
			$this->idcategorias = $lstRetorno[0]->idcategorias;
			$this->nombre = $lstRetorno[0]->nombre;
			return $this;
		}
		return null;
	}

	public function guardar()
	{
		$sql = "UPDATE categorias SET
            nombre='$this->nombre'
            WHERE idcategorias=?";
		$affected = DB::update($sql, [$this->idcategorias]);
	}

	public function eliminar()
	{
		$sql = "DELETE FROM categorias WHERE
            idcategorias=?";
		$affected = DB::delete($sql, [$this->idcategorias]);
	}

	public function insertar()
	{
		$sql = "INSERT INTO categorias (
                nombre 
            ) VALUES (?);";
		$result = DB::insert($sql, [
			$this->nombre,
		]);
		return $this->idcategorias = DB::getPdo()->lastInsertId();
	}

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'nombre',
        );
        $sql = "SELECT DISTINCT
                idcategorias,
                nombre
                    FROM categorias
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}
