<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model{

	protected $table = 'productos';
    public $timestamps = false;

    protected $fillable = [
        'idproducto', 'titulo', 'descripcion', 'precio', 'cantidad', 'imagen', 'fk_idtipoproducto',
    ];

    protected $hidden = [

    ];

	public function cargarDesdeRequest($request) {
        $this->idproducto = $request->input('id') != "0" ? $request->input('id') : $this->idproducto;
        $this->titulo = $request->input('txtTitulo');
        $this->descripcion = $request->input('txtDescripcion');
        $this->precio = $request->input('txtPrecio');
        $this->cantidad = $request->input('txtCantidad');
        $this->imagen = $request->input('txtImagen');
        $this->fk_idtipoproducto = $request->input('lstTipoProducto');
    }

	public function obtenerTodos()
    {
        $sql = "SELECT
				idproducto,
				titulo,
				descripcion,
				precio,
				cantidad, 
				imagen, 
				fk_idtipoproducto              
                FROM productos A ORDER BY titulo ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

	public function obtenerPorId($idProducto)
    {
        $sql = "SELECT
                idproducto,
				titulo,
				descripcion,
				precio,
				cantidad, 
				imagen, 
				fk_idtipoproducto 
                FROM productos WHERE idproducto = $idProducto";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idproducto = $lstRetorno[0]->idproducto;
            $this->titulo = $lstRetorno[0]->titulo;
            $this->descripcion = $lstRetorno[0]->descripcion;
            $this->precio = $lstRetorno[0]->precio;
            $this->cantidad = $lstRetorno[0]->cantidad;
            $this->imagen = $lstRetorno[0]->imagen;
            $this->fk_idtipoproducto = $lstRetorno[0]->fk_idtipoproducto;
            return $this;
        }
        return null;
    }

	public function guardar() {
        $sql = "UPDATE productos SET
            titulo='$this->titulo',
            descripcion='$this->descripcion',
            precio=$this->precio,
            cantidad=$this->cantidad,
            imagen='$this->imagen',
            fk_idtipoproducto=$this->fk_idtipoproducto
            WHERE idproducto=?";
        $affected = DB::update($sql, [$this->idproducto]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM productos WHERE
            idproducto=?";
        $affected = DB::delete($sql, [$this->idproducto]);
    }

	public function insertar()
    {
        $sql = "INSERT INTO productos (
                titulo,
                descripcion,
                precio,
                cantidad,
                imagen,
                fk_idtipoproducto
            ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->titulo,
            $this->descripcion,
            $this->precio,
            $this->cantidad,
            $this->imagen,
            $this->fk_idtipoproducto,
        ]);
        return $this->idproducto = DB::getPdo()->lastInsertId();
    }
}
