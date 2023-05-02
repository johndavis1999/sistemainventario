<?php
    require_once("c://xampp/htdocs/sistemainventario/controller/controladorProductos.php");
    $obj = new controladorProducto();
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $estado = $_POST['estado'];
    $marca = $_POST['marca'];
    $idTipo = $_POST['idTipo'];
    $codigo = $_POST['codigo'];
    $obj->guardar($nombre, $precio, $stock, $estado, $marca, $idTipo, $codigo);
?>
