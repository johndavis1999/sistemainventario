<?php
    require_once("c://xampp/htdocs/sistemainventario/controller/controladorIngreso.php");
    $obj = new controladorIngreso(); 
    $id_jefebodega = $_POST['id_jefebodega'];
    $estado = $_POST['estado'];
    $id_pedido = $_POST['id_pedido'];
    $id_bodega = $_POST['id_bodega'];
    $obj->guardarIngreso($id_jefebodega, $estado, $id_pedido, $id_bodega);
?>
 