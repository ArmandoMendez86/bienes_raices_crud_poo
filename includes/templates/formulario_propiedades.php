<fieldset>
    <legend>Información General</legend>

    <!-- Titulo -->
    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Titulo de propiedad" value="<?php echo escaparHtml($propiedad->titulo) ?>">

    <!-- Precio -->
    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio de propiedad" value="<?php echo escaparHtml($propiedad->precio) ?>">

    <!-- Imagen -->
    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="propiedad[imagen]" placeholder="Precio de propiedad" accept="image/jpeg, image/png">

    <?php if ($propiedad->imagen) : ?>

        <img src="../../imagenes/<?php echo $propiedad->imagen ?>" alt="">

    <?php endif ?>
    <!-- Descripción -->
    <label for="descripcion">Descripcion:</label>
    <textarea id="descripcion" name="propiedad[descripcion]"><?php echo escaparHtml($propiedad->descripcion) ?></textarea>
</fieldset>

<fieldset>
    <legend>Información Propiedad</legend>

    <!-- Habitaciones -->
    <label for="habitaciones">Habitaciones</label>
    <input type="number" id="habitaciones" name="propiedad[habitaciones]" placeholder="Ej: 2" min="1" max="9" value="<?php echo escaparHtml($propiedad->habitaciones) ?>">

    <!-- Baños -->
    <label for="wc">Baños</label>
    <input type="number" id="wc" name="propiedad[wc]" placeholder="Ej: 2" min="1" max="9" value="<?php echo escaparHtml($propiedad->wc) ?>">

    <!-- Estacionamiento -->
    <label for="estacionamiento">Estacionamiento</label>
    <input type="number" id="estacionamiento" name="propiedad[estacionamiento]" placeholder="Ej: 2" min="1" max="9" value="<?php echo escaparHtml($propiedad->estacionamiento) ?>">
</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    <select name="vendedores_id">
        <option value="">Selecciona el vendedor</option>
        <?php while ($row = mysqli_fetch_assoc($resultado)) : ?>
            <option <?php echo $propiedad->id === $row['id'] ? 'selected' : '' ?> value="1"><?php echo $row['nombre'] . ' ' .  $row['apellido'] ?></option>
        <?php endwhile ?>
    </select>
</fieldset>