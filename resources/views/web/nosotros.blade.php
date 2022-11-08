@extends("web.plantilla")
@section("contenido")
  <!-- about section -->
  <section class="about_section layout_padding">
    <div class="container  ">

      <div class="row">
        <div class="col-md-6 ">
          <div class="img-box">
            <img src="web/images/about-img.png" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                Nosotros
              </h2>
              <h5>
                Somos familia
              </h5>
            </div>
            <p>
            Somos más que una hamburguesería, somos mucho más que un local donde comer comida rápida. Somos Burgers SRL, y si estás preparado para comerte las hamburguesas más espectaculares de la zona, tienes que visitarnos.
            Un negocio de familia con un sueño de llegar a lo más alto.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end about section -->
  <!-- client section -->

  <section class="client_section layout_padding-bottom">
    <div class="container">
      <div class="heading_container heading_center psudo_white_primary mb_45">
        <h2>
          What Says Our Customers
        </h2>
      </div>
      <div class="carousel-wrap row ">
        <div class="owl-carousel client_owl-carousel">
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                </p>
                <h6>
                  Moana Michell
                </h6>
                <p>
                  magna aliqua
                </p>
              </div>
              <div class="img-box">
                <img src="web/images/client1.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                </p>
                <h6>
                  Mike Hamell
                </h6>
                <p>
                  magna aliqua
                </p>
              </div>
              <div class="img-box">
                <img src="web/images/client2.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end client section -->
<!-- postulacion section -->
<div class="container">
  <div class="heading_container heading_center psudo_white_primary mb_45">
    <h2>Trabajá con nosotros</h2>
  </div>
  <form action="" method="POST">
  <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
    <div class="row py-3">
      <div class="col-6">
        <input placeholder="Nombre" type="text" name="txtNombre" id="txtNombre" class="form-control" required>
      </div>
      <div class="col-6">
        <input placeholder="Apellido" type="text" name="txtApellido" id="txtApellido" class="form-control" required>
      </div>
    </div>
    <div class="row">
      <div class="col-6">
        <input placeholder="Teléfono" type="text" name="txtTelefono" id="txtTelefono" class="form-control" required>
      </div>
      <div class="col-6">
        <input placeholder="Correo electrónico" type="text" name="txtCorreo" id="txtCorreo" class="form-control" required>
      </div>
    </div>
    <div class="row py-3">
      <div class="col-6">
        <label for="txtArchivo">Curriculum vitae:</label>
        <input type="file" name="archivo" id="archivo" class="form-control-file" required>
      </div>
    </div>
    <div class="btn_box heading_container heading_center pb-4">
      <button type="submit" class="btn btn-dark">ENVIAR</button>
    </div>
  </form>
</div>
<!-- end postulacion section -->
  @endsection