@extends("web.plantilla")
@section("contenido")

<div class="container">
      <div class="row pt-4">
            <div class="col-12">
                  <h2 class="bold">Datos de usuario</h2>
            </div>
      </div>
      <form method="POST" action="">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <div class="row py-3">
                  <div class="col-6">
                        <input placeholder="Nombre" type="text" name="txtNombre" id="txtNombre" class="form-control" value="{{ $cliente->nombre }}">
                  </div>
                  <div class="col-6">
                        <input placeholder="Apellido" type="text" name="txtApellido" id="txtApellido" class="form-control" value="{{ $cliente->apellido }}">
                  </div>
            </div>
            <div class="row pb-3">
                  <div class="col-6">
                        <input placeholder="Telefono" type="text" name="txtTelefono" id="txtTelefono" class="form-control" value="{{ $cliente->telefono }}">
                  </div>
                  <div class="col-6">
                        <input placeholder="Correo" type="text" name="txtCorreo" id="txtCorreo" class="form-control" value="{{ $cliente->correo}}">
                  </div>
            </div>
            <div class="row py-4">
                  <div class="col-12 text-center btn-box1">
                        <button type="submit">GUARDAR</button>
                  </div>
            </div>
      </form>
      <div class="row pt-4">
            <div class="col-12">
                  <h3>Pedidos activos</h3>
            </div>
      </div>
      <table class="table table-hover">
            <tr>
                  <th>Usuario</th>
                  <th>Pedido</th>
                  <th>Sucursal</th>
                  <th>Estado</th>
                  <th>Fecha</th>
                  <th>Total</th>
            </tr>
      </table>
</div>

@endsection