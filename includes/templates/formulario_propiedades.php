<fieldset>
    <legend>Información General</legend>

    <!-- Titulo -->
    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="titulo" placeholder="Titulo de propiedad" value="<?php echo $propiedad->titulo ?>">

    <!-- Precio -->
    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="precio" placeholder="Precio de propiedad" value="<?php echo $propiedad->precio ?>">

    <!-- Imagen -->
    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="imagen" placeholder="Precio de propiedad" accept="image/jpeg, image/png">

    <!-- Descripción -->
    <label for="descripcion">Descripcion:</label>
    <textarea id="descripcion" name="descripcion"><?php echo $propiedad->descripcion ?></textarea>
</fieldset>

<fieldset>
    <legend>Información Propiedad</legend>

    <!-- Habitaciones -->
    <label for="habitaciones">Habitaciones</label>
    <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 2" min="1" max="9" value="<?php echo $propiedad->habitaciones ?>">

    <!-- Baños -->
    <label for="wc">Baños</label>
    <input type="number" id="wc" name="wc" placeholder="Ej: 2" min="1" max="9" value="<?php echo $propiedad->wc ?>">

    <!-- Estacionamiento -->
    <label for="estacionamiento">Estacionamiento</label>
    <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 2" min="1" max="9" value="<?php echo $propiedad->estacionamiento ?>">
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