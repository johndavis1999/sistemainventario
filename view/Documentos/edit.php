<?php
    require_once("c://xampp/htdocs/sistemainventario/controller/controladorIngreso.php");
    $obj = new controladorIngreso();
    $id_ingreso = $_POST['id_ingreso'];
    $id_jefebodega = $_POST['id_jefebodega'];;
    $estado = $_POST['estado'];
    $id_pedido = $_POST['id_pedido'];
    $id_bodega = $_POST['id_bodega'];
    $obj->updateIng($id_ingreso, $id_jefebodega, $estado, $id_pedido, $id_bodega);