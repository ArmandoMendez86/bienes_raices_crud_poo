<?php
require '../../includes/app.php';

estaAutenticado();

$db = conectarDB();

//Usando los namespace
use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;



//Consultar los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);


$errores = [];

//Creando instancia
$propiedad = new Propiedad($_POST);
$vendedores = $propiedad->all();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    //Nombre de la imagen
    $nombreImagen = md5(uniqid(rand(), true));

    //Realizamos un resize con intervention


    if ($_FILES['imagen']['tmp_name']) {

        //Comprobar la extensión MIME
        if ($_FILES['imagen']['type'] === 'image/jpeg') {
            $nombreImagen .= '.jpg';
        }
        if ($_FILES['imagen']['type'] === 'image/png') {
            $nombreImagen .= '.png';
        }
    }

    $propiedad->setImagen($nombreImagen);
    $errores = $propiedad->validar();


    if (empty($errores)) {


        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }

        $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600);
        $image->save(CARPETA_IMAGENES . $nombreImagen);

        $resultado = $propiedad->guardar();

        if ($resultado) {
            header('Location: ../?resultado=1');
        }
    }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear Propiedad</h1>

    <a href="../../admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>

        <div class="alerta error">

            <?php echo $error;  ?>

        </div>
    <?php endforeach ?>

    <form action="" class="formulario" method="POST" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario_propiedades.php';  ?>

        <input type="submit" value="Crear propiedad" class="boton boton-verde">
    </form>



</main>

<?php incluirTemplate('footer'); ?>