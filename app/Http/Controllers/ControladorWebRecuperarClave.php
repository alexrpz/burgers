<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Session;


class ControladorWebRecuperarClave extends Controller
{
    public function index(Request $request)
    {
        $sucursal= new Sucursal();
        $aSucursal=$sucursal->obtenerTodos();
      return view("web.recuperar-clave", compact("aSucursal"));
    }
    public function recuperar(Request $request)
    {
      $sucursal= new Sucursal();
      $aSucursal=$sucursal->obtenerTodos();

      $titulo='Recupero clave';
      $correo=$request->input('txtCorreo');
      $clave= rand (1000, 9999);

      $cliente = new Cliente();
      $cliente->obtenerPorCorreo($correo);
      $cliente->clave = $clave;
      $cliente->guardar();

      if($cliente->correo != "")

      {
            //envia instrucciones
            $data ="Instrucciones";
            $mail = new PHPMailer(true);

            try {
                  //server sttings
                  $mail->SMTPDebug=0;
                  $mail->isSMTP();
                  $mail->Host = env('MAIL_HOST');
                  $mail->SMTPAuth = true;
                  $mail->Username = env('MAIL_USERNAME');
                  $mail->Password = env('MAIL_PASSWORD');
                  $mail->SMTPSecure = env('MAIL_ENCRYPTION');
                  $mail->Port = env('MAIL_PORT');

                  //recipients
                  $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                  $mail->addAddress($correo);

                  //content
                  $mail->isHTML(true);
                  $mail->Subject = 'Recupero de clave';
                  $mail->Body = "Los datos de acceso son:
                  Usuario: $cliente->correo
                  Clave: $clave
                  ";

                  //$mail->$send();
                  $cliente->clave= password_hash($clave, PASSWORD_DEFAULT);
                  $cliente->guardar();

                  $mensaje="La nueva clave es $clave, y te la hemos enviado al correo.";

                  //actualizar en el $cliente la nueva clave ya encriptada (chris)//
                  return view('web.recuperar-clave', compact('titulo', 'mensaje', 'aSucursal'));
            } catch (Exception $e){
                  $mensaje = "Hubo un error al enviar el correo."  .$e->getMessage();
                  return view('web.recuperar-clave', compact('titulo', 'mensaje', 'aSucursal'));
            }
      }else{
            $mensaje= "El correo ingresado no existe";
            return view('web.recuperar-clave', compact('titulo', 'mensaje', 'aSucursal'));
      }
    }
}
