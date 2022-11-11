@extends("web.plantilla")
@section("contenido")

<section class="book_section layout_padding">
	<div class="container">
		<div class="heading_container">
			<h2>
				Recuperar contraseña
			</h2>
			<p>Ingresa la dirección de correo con la que te registraste y te enviaremos las instrucciones de acceso.</p>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form_container">
					<form action="" method="POST">
						<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
						
						<div>
							<label for="">Correo</label>
							<input type="text" name="txtCorreo" id="txtCorreo" class="form-control">@if(isset($mensaje)) <div class="alert alert-secondary" role="alert"> {{$mensaje}} </div>@endif
						</div>
						<div>
							<button type="submit" name="btnIngresar">Recuperar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection