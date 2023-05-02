

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script> 
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>
<body>
    <div>
        <!-- Esta seccion es el navbar se uso bootstrap para optimizar el diseño y añadir los desplegables-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
            <div class="container-fluid">
                <a href="/sistemainventario/index.php" class="d-flex align-items-center text-light text-decoration-none">
                    <img src="/sistemainventario/assets/img/logo_itb.png" width="40" height="40" class="me-2" viewBox="0 0 118 94" alt="">
                    <span class="fs-4">Sistema Inventario</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Menu</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <!-- 1er elemento -->
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/sistemainventario/index.php">Inicio</a>
                            </li>
                            <!-- Desplegable Documentos-->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Documentos
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/sistemainventario/view/Documentos/Pedidos/index.php">Pedidos</a></li>
                                    <li><a class="dropdown-item" href="/sistemainventario/view/Documentos/reciboingreso.php">Recibo Ingreso</a></li>
                                    <li><a class="dropdown-item" href="/sistemainventario/view/Documentos/reciboegreso.php">Recibo Egreso</a></li>
                                </ul>
                            </li>
                            <!-- elemento -->
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/sistemainventario/view/Productos/index.php">Inventario</a>
                            </li>
                            <!--  elemento -->
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/sistemainventario/view/Bodega/index.php">Bodega</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>   
    </div>
    <!-- Aqui comienza el contenido del sistema-->
    <section>