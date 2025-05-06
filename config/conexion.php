<?php
class Conexion
{
    private static $conexion;

    // Define las constantes de configuración fuera de los métodos
    private const SERVIDOR_MYSQL = 'localhost';
    private const USUARIO_MYSQL = 'root';
    private const PASSWORD_MYSQL = '';
    private const BASE_DATOS = 'mesa_partes';

    // Método para conectar a la base de datos
    public static function conectarBD()
    {
        if (!self::$conexion) {
            // Crear una nueva conexión mysqli
            self::$conexion = new mysqli(
                self::SERVIDOR_MYSQL,
                self::USUARIO_MYSQL,
                self::PASSWORD_MYSQL,
                self::BASE_DATOS
            );

            // Verificar si hay errores al conectar
            if (self::$conexion->connect_error) {
                die("Error al conectar a la base de datos: " . self::$conexion->connect_error);
            }
        }

        return self::$conexion;
    }

    // Método para desconectar la base de datos
    public static function desconectarBD()
    {
        if (self::$conexion) {
            self::$conexion->close();
            self::$conexion = null;
        }
    }
}
