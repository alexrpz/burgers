@extends("web.plantilla")
@section("contenido")

<section class="book_section layout_padding">
      <div class="container">
            <div class="row">
                  <div class="heading_container">
                        <h2>Ingresar al sistema</h2>
                  </div>
            </div>
            @if(isset($mensaje))
            <div class="row">
                  <div class="col-md-6">
                        <div class="alert alert-danger" role="alert">
                              {{ $mensaje }}
                        </div>
                  </div>
            </div>
            @endif
            <div class="row">
                  <div class="col-md-6">
                        <div class="form_container">
                              <form action="" method="POST">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                                    <div>
                                          <label for="">Correo</label>
                                          <input type="text" name="txtCorreo" id="txtCorreo" class="form-control">
                                    </div>
                                    <div>
                                          <label for="">Contraseña</label>
                                          <input type="password" name="txtClave" id="txtClave"  class="form-control">
                                    </div>
                                    <div>
                                          <button type="submit" name="btnIngresar">Ingresar</button>
                                    </div>
                              </form>
                              <div class="pt-4 pb-2"> 
                                    <a href="/recuperar-clave">¿Olvidaste tu contraseña? Recuperar ahora.</a>
                              </div>
                              <div class="">
                                    <a href="/registrarse">¿No tenés cuenta? Registrate ahora.</a>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</section>
@endsection