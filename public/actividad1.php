<?php 
$nombre= 'Alex';
$valor_compra= 200;

if($valor_compra < 300){
    $descuento= 0.05;
}
$precio_final = $valor_compra -($valor_compra*$descuento);

echo ("Hola" . $nombre . "el valor de su compra es: ". $valor_compra . "y con descuento es:" . $precio_final);
?>