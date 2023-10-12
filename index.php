<?php

function guardarArchivo($nombre, $contenido)
{

}

if (isset($_POST['rutaActual'])) {
    $ruta = $_POST['rutaActual'];
} else {
    $ruta = "data";
}

if(isset($_POST['antiguaRuta'])) {
    $antiguaRuta = $_POST['antiguaRuta'];
} else {
    $antiguaRuta = "";
}

$nombreInicial = "*sintitulo.txt";
$nombreArchivo = $nombreInicial;
$text = "Empezar a escribir aquí.";
$notaSinNombre = false;

// Variables para establecer alerta de Bootstrap
$alertMessage = "Vacío";
$alertStatus = false;
$alertVariant = "success";

if (isset($_POST)) {
    if (isset($_POST['abrirCarpeta'])) {
        if (!empty($_POST['notepad'])) {
            $text = $_POST['notepad'];
        }
        if (!empty($_POST['nombreArchivo'])) {
            $nombreArchivo = $_POST['nombreArchivo'];
        }

        if (isset($_POST['carpetaSeleccionada'])) {
            $carpeta = $_POST['carpetaSeleccionada'];
            $antiguaRuta = $ruta;
            $ruta .= "/" . $carpeta;
        } else {
            $alertStatus = true;
            $alertMessage = "Error al abrir carpeta";
            $alertVariant = "warning";
        }
    }
    if(isset($_POST['btnVolver'])){
        if (!empty($_POST['notepad'])) {
            $text = $_POST['notepad'];
        }
        if (!empty($_POST['nombreArchivo'])) {
            $nombreArchivo = $_POST['nombreArchivo'];
        }

        //echo 'Ruta: ', $ruta, ' | Antigua ruta: ', $_POST['antiguaRuta'];
        
        $ruta = $antiguaRuta;

    }
    if (isset($_POST['btnGuardar']) || isset($_POST['btnGuardarComo'])) {
        $text = $_POST['notepad'];

        if (isset($_POST['nombreArchivo']) && !empty($_POST['nombreArchivo'])) {
            $nombreArchivo = $_POST['nombreArchivo'];
            $archivo = $nombreArchivo . ".txt";
            $archivoRuta = $ruta . "/" . $archivo;

            if (isset($_POST['notepad'])) {
                $text = $_POST['notepad'];

                if (isset($_POST['btnGuardar'])) {
                    if (file_exists($archivoRuta)) {
                        if ($operarArchivo = fopen($archivoRuta, "w+")) {
                            fwrite($operarArchivo, $text);
                            fclose($operarArchivo);
                        } else {
                            $alertStatus = true;
                            $alertMessage = "No se pudo guardar el archivo";
                            $alertMessage = "danger";
                        }
                    } else {
                        if ($operarArchivo = fopen($archivoRuta, "w+")) {
                            fwrite($operarArchivo, $text);
                            fclose($operarArchivo);
                        } else {
                            $alertStatus = true;
                            $alertMessage = "No se pudo guardar el archivo";
                            $alertMessage = "danger";
                        }
                    }
                }
            }
        } else {
            $notaSinNombre = true;
            $alertStatus = true;
            $alertMessage = "El archivo a guardar debe tener un nombre. ";
            $alertVariant = "warning";
        }
    }
    if (isset($_POST['btnNuevo'])) {
        $nombreArchivo = $nombreInicial;
    }
    if (isset($_POST['btnAbrir'])) {
        if (isset($_POST['archivoSeleccionado'])) {
            $filename = $_POST['archivoSeleccionado'];
            $archivoRuta = $ruta . "/" . $filename;

            if (file_exists($archivoRuta)) {
                if ($operarArchivo = fopen($archivoRuta, "r")) {
                    $text = fread($operarArchivo, filesize($archivoRuta));
                    fclose($operarArchivo);

                    $nombreArchivo = $filename;
                } else {
                    echo "No se pudo abrir el archivo: ", $filename;
                }
            }
        }
    }
    if (isset($_POST['btnEliminar'])) {
        if (isset($_POST['archivoSeleccionado'])) {
            $filename = $_POST['archivoSeleccionado'];
            $archivoRuta = $ruta . "/" . $filename;

            if (unlink($archivoRuta)) {
                $alertStatus = true;
                $alertVariant = "success";
                $alertMessage = "Archivo eliminado";
            } else {
                $alertStatus = true;
                $alertVariant = "danger";
                $alertMessage = "Error al eliminar archivo";
            }
        }
    }
    if (isset($_POST['btnNuevaCarpeta'])) {
        if (!empty($_POST['notepad'])) {
            $text = $_POST['notepad'];
        }
        if (!empty($_POST['nombreArchivo'])) {
            $nombreArchivo = $_POST['nombreArchivo'];
        }

        
    }

}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloc de Notas - PHP</title>
    <link rel="shortcut icon" href="assets/icons/Notepad.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/styles/index.css">
</head>

<body>
    <header class="header container-fluid d-flex justify-content-between p-2">
        <h4 class="header-title">Bloc de Notas </h4>
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" class="header-buttons d-flex px-2">
            <button type="submit" name="btnNuevo" class="mx-2 btn btn-success">Nuevo archivo</button>
        </form>
    </header>
    <main class="main-container d-flex my-3 justify-content-center">
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>"
            class="notepad-container container-xxl row justify-content-between mx-2">
            <fieldset class="notepad-card card px-0 col-7">
                <div class="card-header">
                    <span class="text-muted fw-semibold">
                        <?php
                        echo $nombreArchivo;
                        ?>
                    </span>
                </div>
                <div id="notepadForm" class="notepad-form card-body p-0">
                    <?php
                    if ($nombreArchivo != $nombreInicial) {
                        echo "<textarea class='notepad form-control' name='notepad' id='notepad'>{$text}</textarea>";
                    } else {
                        if ($notaSinNombre) {
                            echo "<textarea class='notepad form-control' name='notepad' id='notepad'>{$text}</textarea>";
                        } else {
                            echo "<textarea class='notepad form-control' name='notepad' id='notepad' placeholder='Empieza a escribir aquí...'></textarea>";
                        }
                    }
                    ?>
                </div>
            </fieldset>

            <fieldset class="control-panel card col-2 px-0 col-4">
                <div class="card-header d-flex">
                    <span class="fw-semibold">Opciones</span>
                </div>
                <div class="card-body">
                    <?php
                    if ($alertStatus == true) {
                        echo '<div class="alert alert-', $alertVariant, ' alert-dismissible" role="alert">
                            <div>', $alertMessage, '</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                    }
                    ?>
                    <div class="panel-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <?php
                            echo '<span class="dir-card-title">Directorio: ',$ruta,'</span>'
                            ?>
                            <button type="submit" name="btnNuevaCarpeta" class="btn btn-secondary">Nueva carpeta</button>
                            
                        </div>
                        
                        <?php
                            if(isset($_POST['btnNuevaCarpeta'])){
                                echo '<div class="d-flex justify-content-between" >
                                <div class="form-group">
                                    <label for="nameCarpeta">Nombre de carpeta: </label>
                                    <input type="text" name="nameCarpeta" id="nameCarpeta" class="form-control" required>
                                </div>
                                <button type="submit" name="crearCarpeta" class="btn btn-primary">Aceptar</button>
                            </div>';
                            }
                        ?>
                        <div class="card dir-container mb-2 mt-2">
                            <div class="card-body dir-content">
                                <ul class="lista-archivos ps-1">
                                    <?php
                                    
                                    $files = scandir($ruta);
                                    foreach ($files as $archivo) {
                                        $rutaArchivo = $ruta . "/" . $archivo;
                                        if ($archivo == "..") {
                                            if($ruta != "data"){
                                                echo '<li class="archivo-lista d-flex justify-content-between align-items-center mb-2">
                                                <div class="d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#fac517" class="bi bi-folder-fill" viewBox="0 0 16 16">
                                                            <path
                                                                d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z" />
                                                        </svg>
                                                <span class="ms-2">', $archivo, '</span>
                                                </div>
                                                <button type="submit" name="btnVolver" class="btn btn-warning">
                                                    <span class="me-1">Volver</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                        class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z" />
                                                    </svg>
                                                </button>
                                                </li>';
                                            }
                                        } else if (filetype($rutaArchivo) == "file") {
                                            echo '<li class="archivo-lista d-flex justify-content-between align-items-center mb-2">
                                                <div class="d-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#535353" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z" />
                                                        </svg>    
                                                    <span class="ms-2">', $archivo, '</span>
                                                </div>
                                                <div class="d-flex">';
                                            ?>
                                                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                                                    <?php
                                                    echo '<label for=', $archivo . '-id', ' class="valor-invisible">', $archivo . "-label", '</label>
                                                    <input type="text" id=', $archivo . '-id', ' name="archivoSeleccionado" class="valor-invisible"
                                                        value= ', $archivo, '>
                                                    <button type="submit" name="btnAbrir"
                                                        class="btn btn-success me-2">Abrir</button>
                                                    <button type="submit" name="btnEliminar"
                                                        class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            </li>';
                                        } else if (filetype($rutaArchivo) == "dir" && $archivo != ".") {
                                            echo '<li class="archivo-lista d-flex justify-content-between align-items-center mb-2">
                                                <div class="d-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#fac517" class="bi bi-folder-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z" />
                                                    </svg>
                                                    <span class="ms-2">', $archivo, '</span>
                                                </div>
                                                <div class="d-flex">';
                                            ?>
                                                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                                                            <?php
                                                            echo '<label for=', $archivo . '-id', ' class="valor-invisible">', $archivo . "-label", '</label>
                                                        <input type="text" id=', $archivo . '-id', ' name="carpetaSeleccionada" class="valor-invisible"
                                                        value= ', $archivo, '>

                                                        <button type="submit" name="abrirCarpeta" class="btn btn-primary me-2">Abrir</button>
                                                    </form>  
                                                </div>
                                            </li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nombreArchivo" class="form-label">Nombre: </label>
                            <?php
                            if ($nombreArchivo != $nombreInicial) {
                                if (isset($_POST['btnGuardarComo'])) {
                                    echo '<input type="text" class="form-control" name="nombreArchivo" id="nombreArchivo"
                                            placeholder="Nombre del archivo" autofocus value=', $nombreArchivo, '>';
                                } else {
                                    echo '<input type="text" class="form-control disabled-input" name="nombreArchivo" id="nombreArchivo"
                                            placeholder="Nombre del archivo" readonly value=', $nombreArchivo, '>';
                                }
                            } else {
                                if (isset($_POST['btnGuardar']) && empty($_POST['notepad'])) {
                                    echo '<input type="text" class="form-control" name="nombreArchivo" id="nombreArchivo"
                                        placeholder="Nombre del archivo" autofocus>';
                                } else {
                                    echo '<input type="text" class="form-control" name="nombreArchivo" id="nombreArchivo"
                                            placeholder="Nombre del archivo">';
                                }
                            }

                            echo "<label for='rutaActual' class='valor-invisible'></label>
                                <input type='text' name='rutaActual' id='rutaActual' class='valor-invisible' value={$ruta}>
                                <label for='antiguaRuta' class='valor-invisible'></label>
                                <input type='text' name='antiguaRuta' id='antiguaRuta' class='valor-invisible' value={$antiguaRuta}>
                                ";
                            ?>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" name="btnGuardar" class="btn btn-primary">Guardar</button>
                        <button type="submit" name="btnGuardarComo" class="btn btn-secondary">Guardar como</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>