<?php 
include("../../sidebar.php");
require_once("c://xampp/htdocs/sistemainventario/controller/controladorProductos.php");
$obj = new controladorProducto(); 
$rows = $obj->index();
require_once("c://xampp/htdocs/sistemainventario/controller/controladorTipo.php");
$obj = new controladorTipo(); 
$tipos = $obj->index();
?>
      <div>
        <button type="button" class="btn btn-primary btnadd" data-bs-toggle="modal" data-bs-target="#modalAddProducto">Agregar Producto</button>
        <!-- Modal para agregar nuevo producto -->
        <div class="modal fade" id="modalAddProducto" tabindex="-1" aria-labelledby="modalAddProductoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalAddProductoLabel">Agregar Producto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="addproducto.php" method="POST" autocomplete="off">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" name="nombre" aria-describedby="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio:</label>
                                <input type="text" class="form-control" name="precio" aria-describedby="precio" required pattern="[0-9]+(\.[0-9]{1,2})?">
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock inicial:</label>
                                <input type="number" class="form-control" name="stock" aria-describedby="stock" required>
                            </div>
                            <div class="mb-3">
                                <label for="marca" class="form-label">Marca:</label>
                                <input type="Text" class="form-control" name="marca" aria-describedby="marca" >
                            </div>
                            <div class="mb-3">
                                <label for="codigo" class="form-label">Codigo:</label>
                                <input type="Text" class="form-control" name="codigo" aria-describedby="codigo" required>
                            </div>
                            <div class="mb-3">
                                <label for="idTipo" class="form-label">Tipo:</label>
                                <select class="form-select" name="idTipo" aria-label="Disabled select example">
                                    <option value="" selected>Seleccionar Tipo</option>
                                    <?php foreach ($tipos as $tipo): ?>
                                        <option value="<?php echo $tipo['id']; ?>"><?php echo $tipo['Descripcion']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Activo</label>
                                <input type="hidden" name="estado" value="0">
                                <input type="checkbox"  class="form-check-label" name="estado" value="1">
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <button type="button" class="btn btn-primary btnadd" data-bs-toggle="modal" data-bs-target="#modalAddTipo">Agregar Tipo</button>

        <table class="table">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Precio</th>
                <th scope="col">Stock</th>
                <th scope="col">Tipo</th>
                <th scope="col">Estado</th>
                <th scope="col">Opciones</th>
              </tr>
            </thead>
            <tbody>
            <?php if($rows): ?>
                <?php foreach($rows as $row): 
                    if($row['stock']==0){
                    ?>
                    <tr class="table-danger">
                    <?php
                    } elseif($row['estado']==0){
                    ?>
                    <tr class="table-secondary">
                    <?php
                    } else{
                    ?>
                    <tr class="table-primary">
                    <?php
                    }
                    ?>
                
                <th class="col-1" scope="row"><?php echo $row['id']?></th>
                <td><?php echo $row['nombre']?></td>
                <td><?php echo $row['precio']?></td>
                <td><?php echo $row['stock']?></td>
                <td><?php echo $row['tipo_descripcion']?></td>
                <td>
                    <?php if($row['estado']==1){
                        echo "Activo";
                    }elseif($row['estado']==0){
                        echo "Inactivo";
                    }?>
                </td>
                <td class="col-2">
                    <button type="button" class="btn btn-secondary"  data-bs-toggle="modal" data-bs-target="#editModal<?=$row['id']?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                        </svg>
                    </button>
                    <!-- Modal Edit producto-->
                    <div class="modal fade" id="editModal<?=$row['id']?>" tabindex="-1" aria-labelledby="editModal<?=$row['id']?>Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editModal<?=$row['id']?>Label">Editar Producto <?= $row['nombre']?> </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulario para actualizar una producto existente -->
                                    <form action="update.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">Nombre:</label>
                                            <input type="text" class="form-control" name="nombre" aria-describedby="nombre" value="<?php echo $row['nombre']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="precio" class="form-label">Precio:</label>
                                            <input type="number" class="form-control" name="precio" aria-describedby="precio" value="<?php echo $row['precio']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="stock" class="form-label">Stock inicial:</label>
                                            <input type="number" class="form-control" name="stock" aria-describedby="stock" value="<?php echo $row['stock']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="marca" class="form-label">Marca:</label>
                                            <input type="Text" class="form-control" name="marca" aria-describedby="marca" value="<?php echo $row['marca']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="codigo" class="form-label">Codigo:</label>
                                            <input type="Text" class="form-control" name="codigo" aria-describedby="codigo" value="<?php echo $row['codigo']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="idTipo" class="form-label">Tipo:</label>
                                            <select class="form-select" name="idTipo" aria-label="Disabled select example">
                                                <option selected>Seleccionar Tipo</option>
                                                <?php foreach ($tipos as $tipo): 
                                                    if($tipo['id'] == $row['idTipo']){?>
                                                        <option value="<?php echo $tipo['id']; ?>" selected><?php echo $tipo['Descripcion']; ?></option>
                                                    <?php
                                                    } else{
                                                    ?>
                                                        <option value="<?php echo $tipo['id']; ?>"><?php echo $tipo['Descripcion']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="estado" class="form-label">Activo</label>
                                            <input type="hidden" name="estado" value="0">
                                            <input type="checkbox"  class="form-check-label" name="estado" value="1" <?php echo ($row['estado'] == '1') ? 'checked' : ''; ?>>
                                        </div>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button  type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#id<?=$row['id']?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                        </svg>
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="id<?=$row['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">¿Desea eliminar el registro ID:<?php echo $row['id'];?>?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Una vez eliminado no se podra recuperar el registro
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cerrar</button>
                                    <a href="delete.php?id=<?= $row['id']?>" class="btn btn-danger">Eliminar</a>
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
    <!-- Modal Add Tipo-->
    <div class="modal fade" id="modalAddTipo" tabindex="-1" aria-labelledby="modalAddTipoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAddTipoLabel">Agregar Tipo de Producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="addtipo.php" method="POST" autocomplete="off">
                        <div class="mb-3">
                            <label for="Descripcion" class="form-label">Descripccion Tipo:</label>
                            <input type="text" class="form-control" name="Descripcion" id="Descripcion" aria-describedby="Descripcion">
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>