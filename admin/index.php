<?php
require '../includes/app.php';

estaAutenticado();

use App\Propiedad;

$propiedades = Propiedad::all();


/* $db = conectarDB();
$query = "SELECT * FROM propiedades";
$propiedades = mysqli_query($db, $query);
*/

$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {

        //Eliminar imagen
        $imagen = "SELECT imagen FROM propiedades WHERE id = '$id'";
        $resultado = mysqli_query($db, $imagen);
        $resultadoImagen = mysqli_fetch_assoc($resultado);
        unlink('../imagenes/' . $resultadoImagen['imagen']);

        //Eliminar propiedad
        $propiedad = "DELETE FROM propiedades WHERE id = '$id'";
        $elminarPropiedad = mysqli_query($db, $propiedad);
        if ($elminarPropiedad) {
            header('Location: ./?resultado=3');
        }
    }
}



incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>

    <?php if (intval($resultado) === 1) : ?>
        <p class="alerta exito">Anuncio Creado Correctamente</p>
    <?php elseif (intval($resultado) === 2) : ?>
        <p class="alerta exito">Anuncio Actualizado Correctamente</p>
    <?php elseif (intval($resultado) === 3) : ?>
        <p class="alerta exito">Anuncio Eliminado Correctamente</p>
    <?php endif ?>
    <a href="./propiedades/crear.php" class="boton boton-verde">Crear propiedad</a>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($propiedades as $propiedad):  ?>
                <tr>
                    <td><?php echo $propiedad->id ?></td>
                    <td><?php echo $propiedad->titulo ?></td>
                    <td><img src="../imagenes/<?php echo $propiedad->imagen ?>" class="imagen-tabla"></td>
                    <td>$ <?php echo $propiedad->precio ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="submit" value="Eliminar" class="boton-rojo-block">
                        </form>
                        <a href="./propiedades/actualizar.php?id=<?php echo $propiedad->id ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>
</main>

<?php

incluirTemplate('footer');
?>