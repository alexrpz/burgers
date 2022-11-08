@extends("web.plantilla")
@section("contenido")
  <!-- book section -->
  <section class="book_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Contacto
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            <form method="POST" action="">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
              <div>
                <input type="text" class="form-control" placeholder="Nombre completo" />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Teléfono" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Correo electrónico" />
              </div>
              <div>
                <textarea placeholder="Mensaje" name="txtMensaje" id="txtMensaje" class="form-control" cols="12" rows="10" ></textarea>
              </div>
              <div class="btn_box">
                <button>
                  ENVIAR
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="map_container ">
            <div id="googleMap"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end book section -->
@endsection