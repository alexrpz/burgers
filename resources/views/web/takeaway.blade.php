@extends("web.plantilla")
@section("contenido")

<!-- food section -->

<section class="food_section layout_padding">
  <div class="container">
    <div class="row">
      <div class="col-12">

      </div>
    </div>
    <div class="heading_container heading_center">
      <h2>
        Menú
      </h2>
    </div>
    <ul class="filters_menu">
      <li class="active" data-filter="*">Todos</li>
      @foreach($aCategorias AS $categoria)
      <li data-filter=".{{ $categoria->nombre }}">{{ $categoria->nombre }}</li>
      @endforeach
    </ul>
    <div class="filters-content width-0">
      <div class="row grid">
        @foreach($aProductos AS $producto)
        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
        <div class="col-sm-6 col-lg-4 all {{ $producto->categoria }}">
          <div class="box ">
            <div>
              <div class="img-box">
                <img src="/files/{{ $producto->imagen }}" alt="">
              </div>
              <div class="detail-box">
                <h5>
                  {{ $producto->nombre }}
                </h5>
                <p>
                  {{ $producto->descripcion }}
                </p>
                <div class="options">
                  <h5>
                    ${{ $producto->precio, 2,'.' }}
                  </h5>
                  <form action="" method="POST">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    <input style="width : 110px; heigth : 110px" placeholder="Cantidad" type="hidden" name="txtProducto" id="txtProducto" class="form-control" value="{{ $producto->idproducto }}">
                    <input style="width : 80px; heigth : 80px" placeholder="0" type="text" name="txtCantidad" id="txtCantidad" class="form-control float-left text-center">
                    <button type="submit" class="bi bi-cart2 btnCarrito mx-4"></button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="btn-box">
      <a href="">
        Arriba
      </a>
    </div>
  </div>
</section>
<!-- end food section -->
@endsection