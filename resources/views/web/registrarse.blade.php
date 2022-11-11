@extends("web.plantilla")
@section("contenido")
<section class="book_section layout_padding">
	<div class="container">
		<div class="row">
			<div class="heading_container">
				<h2>Registrate</h2>
			</div>
			@if(isset($msg))
			<div class="row">
				<div class="col-6">
					<div class="alert alert-{{ $msg['ESTADO'] }} " role="alert">
						{{ $msg['MSG'] }}
					</div>
				</div>
			</div>
			@endif
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form_container">
					<form action="" method="POST">
						<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
						<div>
							<input placeholder="Nombre" type="text" name="txtNombre" id="txtNombre" class="form-control">
						</div>
						<div>

							<input placeholder="Apellido" type="text" name="txtApellido" id="txtApellido" class="form-control">
						</div>
						<div>

							<input placeholder="Teléfono" type="number" name="txtTelefono" id="txtTelefono" class="form-control">
						</div>
						<div>

							<input placeholder="Correo electrónico" type="email" name="txtCorreo" id="txtCorreo" class="form-control">
						</div>

						<div>
							<input placeholder="DNI" type="text" name="txtDni" id="txtDni" class="form-control">
						</div>
						<div>
							<input placeholder="Contraseña" type="password" name="txtClave" id="txtClave" class="form-control">
						</div>
						<div>
							<button type="submit" name="btnIngresar">Registrarse</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection