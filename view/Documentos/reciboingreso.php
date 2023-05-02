<?php 
include("../../sidebar.php");
require_once("c://xampp/htdocs/sistemainventario/controller/controladorIngreso.php");
$obj = new controladorIngreso(); 
$rows = $obj->index();
?>
<a type="button" class="btn btn-primary btnadd" href="crearingreso.php">Ingresar mercaderia</a>

<table class="table">
    <thead>
      <tr>
        <th scope="col">Num. Ingreso</th>
        <th scope="col">Jefe Bodega</th>
        <th scope="col">Fecha</th>
        <th scope="col">Pedido</th>
        <th scope="col">Bodega</th>
        <th scope="col">Estado</th>
        <th scope="col">Opciones</th>
      </tr>
    </thead>
    <tbody>
    <?php if($rows): ?>
        <?php foreach($rows as $row):?>
        
        <th scope="row"><?php echo $row['id_ingreso']?></th>
        <td><?php echo $row['nombre_jefe'] . ' ' . $row['apellido_jefe']?></td>
        <td><?php echo $row['fechahora']?></td>
        <td><?php echo $row['id_pedido']?></td>
        <td><?php echo $row['nombre_bodega']?></td>
        <td>
            <?php if($row['estado']==1){
                echo "En proceso";
            }elseif($row['estado']==2){
                echo "Finalizado";
            }?>
        </td>
        <td class="col-">
            <a type="button" class="btn btn-secondary"  href="edit_ingreso.php?id_ingreso=<?=$row["id_ingreso"]?>">
                EDITAR
            </a>
            <a class="btn btn-primary" role="button" href="pdf_ingreso.php?id_ingreso=<?=$row["id_ingreso"]?>">PDF</a>
            <button  type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#id_ingreso<?=$row['id_ingreso']?>">
                ELIMINAR
            </button>
            <!-- ModalConfirmarBorrar -->
            <div class="modal fade"  id="id_ingreso<?=$row['id_ingreso']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 600px" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1>¿Realmente quiere borrar el ingreso #<?=$row['id_ingreso']?>?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-footer">
                            <a href="borraringreso.php?id_ingreso=<?= $row['id_ingreso']?>" class="btn btn-success">Confirmar</a>
                            <button type="button" data-bs-dismiss="modal" class="btn btn-success">Cancelar</button>
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