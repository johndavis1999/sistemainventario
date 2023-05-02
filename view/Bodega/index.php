<?php 
include("../../sidebar.php");

require_once("c://xampp/htdocs/sistemainventario/controller/controladorBodega.php");
$obj = new controladorBodega(); 
$rows = $obj->index();
?>

<!-- Aqui comienza el contenido del sistema-->
<div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarModal">Agregar bodega</button>
    <!-- Modal para agregar nueva bodega -->
    <div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar nueva bodega</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="addbodega.php" method="POST" autocomplete="off">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la bodega</label>
                            <input type="text" name="nombre" required class="form-control" id="nombre" aria-describedby="nombre">
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección de la bodega:</label>
                            <input type="text" name="direccion" required class="form-control" id="direccion" aria-describedby="direccion">
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Activo</label>
                            <input type="hidden" name="estado" value="0">
                            <input type="checkbox"  class="form-check-label" name="estado" value="1">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <table class="table">
            <thead>
              <tr>
                <th scope="col">N. Bodega</th>
                <th scope="col">Bodega</th>
                <th scope="col">Dirección</th>
                <th scope="col">Estado</th>
                <th scope="col">Opciones</th>
              </tr>
            </thead>
            <tbody>
                
        <?php if($rows): ?>
            <?php foreach($rows as $row): ?>
                    <?php 
                        if($row[3]==1){
                            ?>
                    <tr class="table-primary">
                        <?php 
                        } else{
                            ?>
                    <tr class="table-secondary">
                            <?php 
                        }
                    ?>
                    <th class="col-1" scope="row"><?php echo $row[0]?></th>
                    <td><?php echo $row[1]?></td>
                    <td><?php echo $row[2]?></td>
                    <td>
                        <?php 
                        if($row[3]==1){
                            echo "Activo";
                            } else {
                                echo "Inactivo";
                            }
                            
                        ?>
                    </td>
                    <td class="col-2">
                        <button type="button" class="btn btn-secondary"  data-bs-toggle="modal" data-bs-target="#editModal<?=$row[0]?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                            </svg>
                        </button>
                        
                        <!-- Modal Edit Bodega-->
                        <div class="modal fade" id="editModal<?=$row[0]?>" tabindex="-1" aria-labelledby="editModal<?=$row[0]?>Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="editModal<?=$row[0]?>Label">Editar Bodega <?= $row['nombre']?> </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Formulario para actualizar una bodega existente -->
                                        <form action="update.php" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Nombre de la bodega</label>
                                                <input type="text" name="nombre" required class="form-control" id="nombre" value="<?php echo $row['nombre']; ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="direccion" class="form-label">Dirección de la bodega</label>
                                                <input type="text" name="direccion" required class="form-control" id="direccion" value="<?php echo $row['direccion']; ?>">
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="estado" class="form-label">Estado de la bodega</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="estado" id="estado" value="1" <?php echo ($row['estado'] == '1') ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="estado">
                                                        Activo
                                                    </label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Actualizar</button>
                                            <a href="index.php" class="btn btn-danger">Cancelar</a>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <button  type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#id<?=$row[0]?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                            </svg>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="id<?=$row[0]?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">¿Desea eliminar el registro ID:<?php echo $row[0];?>?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Una vez eliminado no se podra recuperar el registro
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cerrar</button>
                                        <a href="delete.php?id=<?= $row[0]?>" class="btn btn-danger">Eliminar</a>
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
      </div>
    </div> 
</section>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.min.js"></script>
<script>
    var agregarModal = document.getElementById('agregarModal');
    var myModal = new bootstrap.Modal(agregarModal, {
        keyboard: false
    });
</script>