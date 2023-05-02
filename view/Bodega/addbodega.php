<?php
    require_once("c://xampp/htdocs/sistemainventario/controller/controladorBodega.php");
    $obj = new controladorBodega();
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $estado = $_POST['estado'];
    $obj->guardar($nombre, $direccion, $estado);
?>
