<?php
include_once __DIR__ . '/../config/conexion.php';

class MensajesAyuda{

    public function obtenerMensajesPorIdAyuda($idAyuda) {
        $conexion = Conexion::conectarBD();

        $sql = "SELECT 
                    id,
                    id_ayuda,
                    id_remitente,
                    id_usuario,
                    remitente_tipo,
                    mensaje,
                    url_archivo,
                    fecha,
                    hora,
                    leido_por_admin,
                    leido_por_remitente
                FROM mensajes_ayuda
                WHERE id_ayuda = ?
                ORDER BY fecha ASC, hora ASC";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idAyuda);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $mensajes = [];

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $mensajes[] = [
                    "id"                 => (int)$fila["id"],
                    "id_ayuda"           => (int)$fila["id_ayuda"],
                    "id_remitente"       => isset($fila["id_remitente"]) ? (int)$fila["id_remitente"] : null,
                    "id_usuario"         => isset($fila["id_usuario"]) ? (int)$fila["id_usuario"] : null,
                    "remitente_tipo"     => $fila["remitente_tipo"], // 'remitente' o 'admin'
                    "mensaje"            => $fila["mensaje"],
                    "url_archivo"        => $fila["url_archivo"],
                    "fecha"              => $fila["fecha"],
                    "hora"               => $fila["hora"],
                    "leido_por_admin"    => (int)$fila["leido_por_admin"],
                    "leido_por_remitente"=> (int)$fila["leido_por_remitente"]
                ];
            }
        }

        $stmt->close();
        Conexion::desconectarBD();

        return $mensajes;
    }

    public function obtenerMensajesRecientes($idAyuda, $ultimoIdMensaje) {
        $conexion = Conexion::conectarBD();

        $sql = "SELECT 
                    id,
                    id_ayuda,
                    id_remitente,
                    id_usuario,
                    remitente_tipo,
                    mensaje,
                    url_archivo,
                    fecha,
                    hora,
                    leido_por_admin,
                    leido_por_remitente
                FROM mensajes_ayuda
                WHERE id_ayuda = ? AND id > ?
                ORDER BY fecha ASC, hora ASC";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ii", $idAyuda, $ultimoIdMensaje);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $mensajes = [];

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $mensajes[] = [
                    "id"                 => (int)$fila["id"],
                    "id_ayuda"           => (int)$fila["id_ayuda"],
                    "id_remitente"       => isset($fila["id_remitente"]) ? (int)$fila["id_remitente"] : null,
                    "id_usuario"         => isset($fila["id_usuario"]) ? (int)$fila["id_usuario"] : null,
                    "remitente_tipo"     => $fila["remitente_tipo"],
                    "mensaje"            => $fila["mensaje"],
                    "url_archivo"        => $fila["url_archivo"],
                    "fecha"              => $fila["fecha"],
                    "hora"               => $fila["hora"],
                    "leido_por_admin"    => (int)$fila["leido_por_admin"],
                    "leido_por_remitente"=> (int)$fila["leido_por_remitente"]
                ];
            }
        }

        $stmt->close();
        Conexion::desconectarBD();

        return $mensajes;
    }

    public function registrarMensajeAyuda($idAyuda, $idRemitente, $idUsuarioSistema, $tipo, $mensaje) {
        // Establecer la zona horaria
        date_default_timezone_set('America/Lima');
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');

        // Conexión a la base de datos
        $conexion = Conexion::conectarBD();

        // Paso 1: Insertar el mensaje en la tabla mensajes_ayuda
        $sqlInsert = "INSERT INTO mensajes_ayuda (
                        id_ayuda,
                        id_remitente,
                        id_usuario,
                        remitente_tipo,
                        mensaje,
                        fecha,
                        hora,
                        leido_por_admin,
                        leido_por_remitente
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmtInsert = $conexion->prepare($sqlInsert);
        if (!$stmtInsert) {
            return false;
        }

        $leidoPorAdmin = $tipo === 'remitente' ? 0 : 1;
        $leidoPorRemitente = $tipo === 'admin' ? 0 : 1;

        $stmtInsert->bind_param(
            "iiissssii",
            $idAyuda,
            $idRemitente,
            $idUsuarioSistema,
            $tipo,
            $mensaje,
            $fecha,
            $hora,
            $leidoPorAdmin,
            $leidoPorRemitente
        );

        $insertOk = $stmtInsert->execute();
        $stmtInsert->close();

        // Si insertó correctamente, paso 2: actualizar la tabla ayuda
        if ($insertOk) {
            if ($tipo === 'remitente') {
                $sqlUpdate = "UPDATE ayuda SET 
                                fecha_ultimo_mensaje_remitente = ?, 
                                hora_ultimo_mensaje_remitente = ? 
                            WHERE id_ayuda = ?";
            } elseif ($tipo === 'admin') {
                $sqlUpdate = "UPDATE ayuda SET 
                                fecha_ultimo_mensaje_admin = ?, 
                                hora_ultimo_mensaje_admin = ? 
                            WHERE id_ayuda = ?";
            } else {
                Conexion::desconectarBD();
                return false;
            }

            $stmtUpdate = $conexion->prepare($sqlUpdate);
            if (!$stmtUpdate) {
                Conexion::desconectarBD();
                return false;
            }

            $stmtUpdate->bind_param("ssi", $fecha, $hora, $idAyuda);
            $stmtUpdate->execute();
            $stmtUpdate->close();

            // Paso 3 (opcional): Si es admin, actualizar estado solo si estaba en 'Enviado'
            if ($tipo === 'admin') {
                $sqlEstado = "UPDATE ayuda SET estado = 'En proceso' 
                            WHERE id_ayuda = ? AND estado = 'Enviado'";
                $stmtEstado = $conexion->prepare($sqlEstado);
                if (!$stmtEstado) {
                    Conexion::desconectarBD();
                    return false;
                }

                $stmtEstado->bind_param("i", $idAyuda);
                $stmtEstado->execute();
                $stmtEstado->close();
            }
        }

        Conexion::desconectarBD();
        return $insertOk;
    }

}