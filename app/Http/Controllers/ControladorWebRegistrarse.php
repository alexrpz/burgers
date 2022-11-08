<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Cliente;
class ControladorWebRegistrarse extends Controller
{

      public function index()
      {
            return view("web.registrarse");
      }
      public function registrarse(Request $request)
      {
            $titulo="Nuevo registro";
            $entidad = new Cliente();
            $entidad->nombre = $request->input("txtNombre");
            $entidad->clave = password_hash($request->input("txtClave"), PASSWORD_DEFAULT);

            if($entidad->nombre="" || $entidad->apellido="" || $entidad->telefono="" || $entidad->correo="")
            {
                  $msg["ESTADO"]=MSG_ERROR;
                  $msg["MSG"] = "Complete todos los datos";
            }else{

                  $entidad->guardar();

                  $msg["ESTADO"]=MSG_SUCCESS;
                  $msg["MSG"] = "Registro exitoso";
            }
            return view("web.index");
      }
}
?>