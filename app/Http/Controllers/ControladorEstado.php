<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Estado;
require app_path() . '/start/constants.php';
class ControladorEstado extends Controller{
      public function nuevo()
      {
            
            return view('sistema.estado-nuevo');
      }
      public function guardar(Request $request){
            try {
                  //Define la entidad servicio
                  $titulo = "Modificar estado";
                  $entidad = new Estado();
                  $entidad->cargarDesdeRequest($request);

                  //validaciones
                  if ($entidad->nombre == "") {
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Complete todos los datos";
                  } else {
                        if ($_POST["id"] > 0) {
                              //Es actualizacion
                              $entidad->guardar();

                              $msg["ESTADO"] = MSG_SUCCESS;
                              $msg["MSG"] = OKINSERT;
                        } else {
                              //Es nuevo
                              $entidad->insertar();

                              $msg["ESTADO"] = MSG_SUCCESS;
                              $msg["MSG"] = OKINSERT;
                        }
                        $_POST["id"] = $entidad->idestado;
                        return view('sistema.estado-listar', compact('titulo', 'msg'));
                  }
            } catch (Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = ERRORINSERT;
            }

            $id = $entidad->idestado;
            $estado = new Estado();
            $estado->obtenerPorId($id);
            return view('sistema.estado-nuevo', compact('msg', 'estado', 'titulo')) . '?id=' . $estado->idestado;
}
}
?>