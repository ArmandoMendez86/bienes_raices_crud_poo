<?php


require '../../includes/app.php';

use App\Propiedad;

estaAutenticado();

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /bienes_raices/admin');
}


//Obtener datos de la propiedad
$propiedad = Propiedad::propiedadXid($id);


//Consultar los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);


$errores = Propiedad::getErrores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $args = $_POST['propiedad'];
    $propiedad->sincronizar($args);

    $errores = $propiedad->validar();
  

    if (empty($errores)) {
        /* SUBIDA DE ARCHIVOS */

        //Crear carpeta
        $carpetaImagenes = '../../imagenes';

        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        //Nombre de la imagen
        $nombreImagen = md5(uniqid(rand(), true));

        if ($imagen['name']) {
            unlink($carpetaImagenes . '/' . $propiedad['imagen']);

            //Comprobar la extensión MIME
            if ($imagen['type'] === 'image/jpeg') {
                $nombreImagen .= '.jpg';
            }
            if ($imagen['type'] === 'image/png') {
                $nombreImagen .= '.png';
            }
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . '/' . $nombreImagen);
        } else {
            $nombreImagen = $propiedad['imagen'];
        }

        //Insertar en la base de datos
        $query = "UPDATE propiedades SET titulo ='$titulo', precio='$precio', imagen= '$nombreImagen', descripcion='$descripcion', habitaciones='$habitaciones', wc='$wc', estacionamiento='$estacionamiento', creado='$creado', vendedores_id='$vendedorId' WHERE id='$id'";
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('Location: ../?resultado=2');
            exit;
        }
    }
}


incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>

    <a href="../../admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error;  ?>
        </div>
    <?php endforeach ?>

    <form action="" class="formulario" method="POST" enctype="multipart/form-data">

        <?php require '../../includes/templates/formulario_propiedades.php'  ?>

        <input type="submit" value="Actualizar propiedad" class="boton boton-verde">
    </form>



</main>

<?php incluirTemplate('footer'); ?>