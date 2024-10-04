<?php

namespace App;

class Propiedad
{
    //Base da datos
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];

    //Errores
    protected static $errores = [];


    //Propiedades
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public static function setDb($database)
    {
        self::$db = $database;
    }

    public function __construct($valores = [])
    {
        $this->id = $valores['id'] ?? '';
        $this->titulo = $valores['titulo'] ?? '';
        $this->precio = $valores['precio'] ?? '';
        $this->imagen = '';
        $this->descripcion = $valores['descripcion'] ?? '';
        $this->habitaciones = $valores['habitaciones'] ?? '';
        $this->wc = $valores['wc'] ?? '';
        $this->estacionamiento = $valores['estacionamiento'] ?? '';
        $this->creado = Date('Y/m/d');
        $this->vendedores_id = $valores['vendedores_id'] ?? 1;
    }

    public function guardar()
    {
        //Sanitizar los datos

        $atributos = $this->sanitizarDatos();

        $camposTablas = join(', ',  array_keys($atributos));
        $valoresTablas = join("', '",  array_values($atributos));

        //Insertar en la base de datos
        $query = "INSERT INTO propiedades($camposTablas) VALUES('$valoresTablas')";

        $resultado = self::$db->query($query);

        return $resultado;
    }

    //Unir los atributos a BD
    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if ($columna == 'id') continue;
            $atributos[$columna] = $this->$columna;
        }

        return $atributos;
    }

    public function sanitizarDatos()
    {

        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    public function setImagen($imagen)
    {
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }
    //Validacion
    public static function getErrores()
    {
        return self::$errores;
    }

    public function validar()
    {
        if (!$this->titulo) {
            self::$errores[] = 'Debes añadir un titulo';
        }
        if (!$this->precio) {
            self::$errores[] = 'Debes añadir un precio';
        }
        if (!$this->descripcion || strlen($this->descripcion) < 50) {
            self::$errores[] = 'Debes añadir una descripción y debe ser menor a 50 caracteres';
        }
        if (!$this->habitaciones) {
            self::$errores[] = 'Indica el número de habitaciones';
        }
        if (!$this->wc) {
            self::$errores[] = 'Indica el número de baños';
        }
        if (!$this->estacionamiento) {
            self::$errores[] = 'Indica el número de estacionamientos';
        }
        if (!$this->vendedores_id) {
            self::$errores[] = 'Elige el vendedor';
        }
        if (!$this->imagen) {
            self::$errores[] = 'La imagen es obligatoria';
        }


        return self::$errores;
    }

    public static function all()
    {
        $query = "SELECT * FROM propiedades";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function consultarSQL($query)
    {
        //Consultar BD
        $resultado = self::$db->query($query);

        //Iterar resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }

        //Libererar memoria
        $resultado->free();

        //Retornar resultados
        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new self;
        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }
}
