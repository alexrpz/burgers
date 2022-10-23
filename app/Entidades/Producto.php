<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

    protected $table = 'productos';
    public $timestamps = false;

    protected $fillable = [
        'idproducto', 'nombre', 'descripcion', 'precio', 'cantidad', 'imagen', 'fk_idcategoria',
    ];

    protected $hidden = [];

    public function cargarDesdeRequest($request)
    {
        $this->idproducto = $request->input('id') != "0" ? $request->input('id') : $this->idproducto;
        $this->nombre = $request->input('txtNombre');
        $this->descripcion = $request->input('txtDescripcion');
        $this->precio = $request->input('txtPrecio');
        $this->cantidad = $request->input('txtCantidad');
        $this->imagen = $request->input('archivo');
        $this->fk_idcategoria = $request->input('lstCategoria');
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
				idproducto,
				nombre,
				descripcion,
				precio,
				cantidad, 
				imagen, 
				fk_idcategoria              
                FROM productos A ORDER BY nombre ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idProducto)
    {
        $sql = "SELECT
                idproducto,
				nombre,
				descripcion,
				precio,
				cantidad, 
				imagen, 
				fk_idcategoria 
                FROM productos WHERE idproducto = $idProducto";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idproducto = $lstRetorno[0]->idproducto;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->descripcion = $lstRetorno[0]->descripcion;
            $this->precio = $lstRetorno[0]->precio;
            $this->cantidad = $lstRetorno[0]->cantidad;
            $this->imagen = $lstRetorno[0]->imagen;
            $this->fk_idcategoria = $lstRetorno[0]->fk_idcategoria;
            return $this;
        }
        return null;
    }

    public function guardar()
    {
        $sql = "UPDATE productos SET
            nombre='$this->nombre',
            descripcion='$this->descripcion',
            precio=$this->precio,
            cantidad=$this->cantidad,
            imagen='$this->imagen',
            fk_idcategoria=$this->fk_idcategoria
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
                nombre,
                descripcion,
                precio,
                cantidad,
                imagen,
                fk_idcategoria
            ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->nombre,
            $this->descripcion,
            $this->precio,
            $this->cantidad,
            $this->imagen,
            $this->fk_idcategoria,
        ]);
        return $this->idproducto = DB::getPdo()->lastInsertId();
    }
    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.nombre',
            1 => 'A.descripcion',
            2 => 'A.precio',
            3 => 'A.cantidad',
            4 => 'A.imagen',
            5 => 'B.nombre'
        );
        $sql = "SELECT DISTINCT
                A.idproducto,
                A.nombre,
                A.descripcion,
                A.precio,
                A.cantidad,
                A.imagen,
                A.fk_idcategoria,
                B.nombre AS categoria
                FROM productos A
                INNER JOIN categorias B ON A.fk_idcategoria = B.idcategoria
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR descripcion LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR precio LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR cantidad LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR imagen LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR B.nombre LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}
