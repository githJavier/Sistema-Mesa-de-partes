<?php
// utils/log_config.php
error_reporting(E_ALL);
ini_set('display_errors', 1); // 🔧 Mostrar errores en pantalla durante desarrollo
ini_set('display_startup_errors', 1); // 🔧 Mostrar errores al iniciar PHP
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/php_error.log');
