@extends("web.plantilla")
@section("contenido")
<!-- carrito -->
<div class="container">
	<div class="row">
		<div class="col-12 my-4">
			<h2>Mi carrito</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<table class="table">
				<div class="row">
					<div class="col-12">
						<thead>
							<tr>
								<th></th>
								<th></th>
								<th>Precio</th>
								<th>Cantidad</th>
								<th>Subtotal</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$total= 0;
							?>
							@foreach($aCarritos AS $carrito)
							<?php 
							$subtotal = $carrito->precio * $carrito->cantidad;
							$total += $subtotal;
							?>
							<tr>
								<form method="POST" action="">
									<td>
										<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
										<input type="text" name="txtCarrito" id="txtCarrito" class="form-control" value="{{ $carrito->idcarrito }}">
									</td>
									<td>
										<img src="/files/{{ $carrito->imagen }}" class="img-thumbnail">
									</td>
									<td>
										{{ $carrito->producto }}
									</td>
									<td>
										{{ $carrito->precio }}
									</td>
									<td style="width: 15px;">
										<input type="hidden" name="txtProducto" id="txtProducto" class="form-control" value="{{ $carrito->fk_idproducto }}">
										<input type="number" min="1" name="txtCantidad" id="txtCantidad" class="form-control" value="{{ $carrito->cantidad }}">
									</td>
									<td>
										{{ number_format($subtotal, 2, ",", ".")}}
									</td>
									<td>
										<div class="btn-group">
											<button type="submit" class="btn btn-info" id="btnActualizar" name="btnActualizar">
											</button>
											<button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">
											</button>

										</div>

									</td>
									<td>
									<div>
										<label for="">Sucursal</label>
                        				<select name="lstSucursal" id="lstSucursal" class="form-control" value="{{$pedido->fk_idSucursal}}" required>
											<option value="" disabled selected>Seleccionar</option>
											@foreach($aSucursal as $sucursal)
												<option value="{{ $sucursal->idsucursal }}">{{ $sucursal->nombre }}</option> 
											@endforeach
										</select>
									</div>
									<div>
										<label for="">Método de pago</label>
                        				<select name="lstPago" id="lstPago" class="form-control" required>
											<option value="" disabled selected>Seleccionar</option>						
												<option value="Mercado pago">Mercado pago</option> 	
												<option value="Efectivo">Efectivo</option> 	
										</select>
									</div>
									</td>
								</form>
							</tr>
							@endforeach
							<tr>
								<td colspan="4" style="text-align: right;">¿Te faltó algo?</td>
								<td colspan="4" style="text-align: right;"><a class="btn btn-primary" href="/takeaway">Continuar la compra</a></td>
							</tr>
						</tbody>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<tr>
							<?php
								$resultado = 0;
								foreach ($aCarritos as $carrito){
									($resultado  = $carrito->cantidad * $carrito->precio);
									break;
								}
							?>
							<th>TOTAL: $ {{ number_format($resultado, 2, ",", ".") }}</th>
						</tr>
					</div>
				</div>
			</table>
		</div>
	</div>
</div>
<!-- end carrito -->
@endsection