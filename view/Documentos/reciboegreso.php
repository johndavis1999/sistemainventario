<?php 
include("../../sidebar.php");
require_once("c://xampp/htdocs/sistemainventario/controller/controladorEgreso.php");
$obj = new controladorEgreso(); 
$rows = $obj->index();
?>
<a type="button" class="btn btn-primary btnadd" href="crearegreso.php">Egresar mercaderia</a>

<table class="table">
    <thead>
      <tr>
        <th scope="col">Num. Egreso</th>
        <th scope="col">Jefe Bodega</th>
        <th scope="col">Fecha</th>
        <th scope="col">Factura</th>
        <th scope="col">Bodega</th>
        <th scope="col">Estado</th>
        <th scope="col">Opciones</th>
      </tr>
    </thead>
    <tbody>
    <?php if($rows): ?>
        <?php foreach($rows as $row):?>
        
        <th scope="row"><?php echo $row['id_egreso']?></th>
        <td><?php echo $row['nombre_jefe'] . ' ' . $row['apellido_jefe']?></td>
        <td><?php echo $row['fechahora']?></td>
        <td><?php echo $row['id_factura']?></td>
        <td><?php echo $row['nombre_bodega']?></td>
        <td>
            <?php if($row['estado']==1){
                echo "En proceso";
            }elseif($row['estado']==2){
                echo "Finalizado";
            }?>
        </td>
        <td class="col-2">
            <a type="button" class="btn btn-secondary"  href="edit_egreso.php?id_egreso=<?=$row["id_egreso"]?>">
                EDITAR
        </a>
            <a class="btn btn-primary" role="button" href="pdf_egreso.php?id_egreso=<?=$row["id_egreso"]?>">PDF</a>
            <button  type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#id<?=$row['id_egreso']?>">
                ELIMINAR
            </button>
            <!-- Modal -->
            <div class="modal fade" id="id<?=$row['id_egreso']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">¿Desea eliminar el registro ID:<?php echo $row['id_egreso'];?>?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Una vez eliminado no se podra recuperar el registro
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cerrar</button>
                            <a href="borraregreso.php?id_egreso=<?= $row['id_egreso']?>" class="btn btn-danger">Eliminar</a>
                            <!-- <button type="button" >Eliminar</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr> 
    <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3" class="text-center">No hay registros actualmente</td>
        </tr>
    <?php endif; ?>
    </tbody>
  </table>