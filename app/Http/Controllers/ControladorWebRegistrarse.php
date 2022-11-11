<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Cliente;
use App\Entidades\Sucursal;

require app_path() . '/start/constants.php';

class ControladorWebRegistrarse extends Controller
{

      public function index()
      {
            $sucursal= new Sucursal();
            $aSucursal=$sucursal->obtenerTodos();
            return view("web.registrarse", compact("aSucursal"));
      }
      public function registrarse(Request $request)
      {
            $titulo="Nuevo registro";
            $entidad = new Cliente();
            $entidad->nombre = $request->input("txtNombre");
            $entidad->apellido = $request->input("txtApellido");
            $entidad->dni = $request->input("txtDni");
            $entidad->telefono = $request->input("txtTelefono");
            $entidad->correo = $request->input("txtCorreo");
            $entidad->clave = password_hash($request->input("txtClave"), PASSWORD_DEFAULT);

            $sucursal= new Sucursal();
            $aSucursal=$sucursal->obtenerTodos();

            if ($entidad->nombre == "" || $entidad->apellido== "" || $entidad->dni== "" || $entidad->telefono == "" || $entidad->correo == "" || $entidad->clave == "") {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = "Complete todos los datos";
                  return view("web.registrarse", compact("aSucursal", 'titulo', 'msg'));
            }else{
                        $entidad->guardar();
                  }  
                  {
                        //Es nuevo
                        $entidad->insertar();
      
                  }
                  return redirect("/registrarse-gracias");
            }
      }