<?php
    require_once("c://xampp/htdocs/sistemainventario/controller/controladorBodega.php");
    $obj = new controladorBodega();
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $estado = $_POST['estado'];
    $obj->update($_POST['id'],$_POST['nombre'],$_POST['direccion'],$_POST['estado']);

?>