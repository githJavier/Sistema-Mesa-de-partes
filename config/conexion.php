<?php
class Conexion
{
    private static $conexion;

    public static function conectarBD()
    {
        if (!self::$conexion) {
            // Obtener los datos desde variables de entorno
            $host = getenv('DB_HOST');
            $user = getenv('DB_USER');
            $pass = getenv('DB_PASSWORD');
            $db   = getenv('DB_NAME');
            $port = getenv('DB_PORT') ?: 3306; // valor por defecto si no se define

            self::$conexion = new mysqli($host, $user, $pass, $db, $port);

            if (self::$conexion->connect_error) {
                die("Error al conectar a la base de datos: " . self::$conexion->connect_error);
            }
        }

        return self::$conexion;
    }

    public static function desconectarBD()
    {
        if (self::$conexion) {
            self::$conexion->close();
            self::$conexion = null;
        }
    }
}