<?php 
$nombre= 'Alex';
$valor_compra= 200;

if($valor_compra < 300){
    $descuento= 0.05;
}
$precio_final = $valor_compra -($valor_compra*$descuento);

echo ("Hola" . $nombre . "el valor de su compra es: ". $valor_compra . "y con descuento es:" . $precio_final);
?>
<div id="customCarousel1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
        <div class="carousel-item active">
        <div class="container ">
          <div class="row">
            <div class="col-md-7 col-lg-6 ">
              <div class="detail-box">
                <h1>
                  Burgers SRL
                </h1>
                <p>
                  Las mejores hamburguesas de Buenos Aires.
                </p>
                <div class="btn-box">
                  <a href="" class="btn1">
                    Crear cuenta
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item ">
        <div class="container ">
          <div class="row">
            <div class="col-md-7 col-lg-6 ">
              <div class="detail-box">
                <h1>
                  Otra experiencia
                </h1>
                <p>
                  No te olvidarás de este sabor.
                </p>
                <div class="btn-box">
                  <a href="" class="btn1">
                    Crear cuenta
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="container ">
          <div class="row">
            <div class="col-md-7 col-lg-6 ">
              <div class="detail-box">
                <h1>
                  No mires para otro lado.
                </h1>
                <p>
                  Danos una oportunidad de cambiar tu lugar preferido.
                </p>
                <div class="btn-box">
                  <a href="" class="btn1">
                    Crear cuenta
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
        <div class="container">
          <ol class="carousel-indicators">
            <li data-target="#customCarousel1" data-slide-to="0" class="active"></li>
            <li data-target="#customCarousel1" data-slide-to="1"></li>
            <li data-target="#customCarousel1" data-slide-to="2"></li>
          </ol>
        </div>
      </div>