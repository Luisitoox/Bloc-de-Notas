<?php

function guardarArchivo($nombre, $contenido)
{

}

$nombreInicial = "*sintitulo.txt";
$nombreArchivo = $nombreInicial;
$text = "Empezar a escribir aquí.";

if (isset($_POST)) {
    if (isset($_POST['btnNombrar'])) {
        $nombreArchivo = $_POST['nombreArchivo'] . ".txt";

        if (isset($_POST['notepad'])) {
            $text = $_POST['notepad'];


        }
    }
    if (isset($_POST['btnGuardar'])) {

    }
    if (isset($_POST['btnGuardarComo'])) {
        $nombreArchivo = "Save As";
    }
    if (isset($_POST['btnNuevo'])) {
        $nombreArchivo = "Nuevo";
    }
    if (isset($_POST['btnAbrir'])) {
        $nombreArchivo = "Abrir";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloc de Notas Online | PHP</title>
    <link rel="shortcut icon" href="assets/icons/Notepad.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/styles/index.css">
</head>

<body>
    <header class="header container-fluid d-flex justify-content-between p-2">
        <h4 class="header-title">Bloc de Notas Online</h4>
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" class="header-buttons d-flex px-2">
            <button type="submit" name="btnNuevo" class="mx-2 btn btn-success">Nuevo archivo</button>
            <button type="submit" name="btnAbrir" class="mx-2 btn btn-secondary">Abrir archivo</button>
        </form>
    </header>
    <main class="main-container d-flex my-3 justify-content-center">
        <form method="post" class="notepad-container container-xxl row justify-content-between mx-2">
            <article class="notepad-card card px-0 col-7">
                <div class="card-header">
                    <span class="text-muted">
                        <?php
                        echo $nombreArchivo;
                        ?>
                    </span>
                </div>
                <form method="post" id="notepadForm" action="<?php $_SERVER['PHP_SELF'] ?>" class="card-body p-0">
                    <?php
                    if ($nombreArchivo != $nombreInicial) {
                        echo "<textarea class='notepad form-control' name='notepad' id='notepad'>{$text}</textarea>";
                    } else {
                        echo "<textarea class='notepad form-control' name='notepad' id='notepad' placeholder='Empieza a escribir aquí...'></textarea>";
                    }
                    ?>

                    <section class="footer-buttons d-flex my-3 justify-content-end">
                        <?php
                        if ($nombreArchivo == $nombreInicial) {
                            echo '<button type="submit" name="btnInicial" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#ModalGuardar"
                                >Guardar...</button>';
                        } else {
                            echo '<button type="submit" name="btnGuardar" class="btn btn-primary me-2">Guardar</button>';
                        }
                        ?>
                        <button type="button" name="btnGuardarComo" class="btn btn-secondary">Guardar como</button>
                    </section>
                    <article class="modal-container">
                        <div class="modal fade" id="ModalGuardar" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Guardar como</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <span class="dir-card-title fw-semibold">Directorio: </span>
                                            <div class="card dir-container mb-2 mt-2">
                                                <div class="card-body dir-content">
                                                    <?php
                                                    $ruta = "";
                                                    $files = scandir(getcwd());
                                                    foreach ($files as $archivo) {
                                                        echo $archivo; ?>
                                                        <br>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nombreArchivo" class="form-label">Nombre: </label>
                                                <input type="text" class="form-control" name="nombreArchivo"
                                                    id="nombreArchivo" placeholder="Nombre del archivo" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="btnNombrar"
                                                class="btn btn-primary">Guardar</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                </form>
            </article>
            <div class="control-panel card col-4 px-0">
                <div class="card-header">
                    <span>Opciones</span>
                </div>
                <div class="card-body">
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                        <div class="modal-body">
                            <span class="dir-card-title fw-semibold">Directorio: </span>
                            <div class="card dir-container mb-2 mt-2">
                                <div class="card-body dir-content">
                                    <?php
                                    $ruta = "";
                                    $files = scandir(getcwd());
                                    foreach ($files as $archivo) {
                                        echo $archivo; ?>
                                        <br>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nombreArchivo" class="form-label">Nombre: </label>
                                <input type="text" class="form-control" name="nombreArchivo" id="nombreArchivo"
                                    placeholder="Nombre del archivo" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="btnNombrar" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>