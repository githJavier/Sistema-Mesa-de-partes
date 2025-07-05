<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../utils/log_config.php';

class Ayuda{

    public function guardarConsulta($id_remitente, $asunto, $mensaje) {
        $conexion = Conexion::conectarBD();

        // Zona horaria de Lima
        date_default_timezone_set('America/Lima');
        $fecha = date('Y-m-d');
        $hora  = date('H:i:s');

        $sql = "INSERT INTO ayuda (id_remitente, id_usuario, asunto, mensaje, fecha, hora)
                VALUES (?, '1', ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("issss", $id_remitente, $asunto, $mensaje, $fecha, $hora);

        $resultado = $stmt->execute();
        $stmt->close();
        Conexion::desconectarBD();

        return $resultado;
    }

    public function obtenerConsultasConRemitente() {
        $conexion = Conexion::conectarBD();

        $sql = "SELECT 
                    a.id_ayuda,
                    a.asunto,
                    a.mensaje,
                    a.fecha,
                    a.hora,
                    a.fecha_ultimo_mensaje_remitente,
                    a.hora_ultimo_mensaje_remitente,
                    a.fecha_ultimo_mensaje_admin,
                    a.hora_ultimo_mensaje_admin,
                    a.estado,
                    r.idremite,
                    r.tipo_remitente,
                    r.retipo_docu,
                    r.docu_num,
                    r.nombres,
                    r.correo,
                    r.telefono_celular,
                    r.departamento,
                    r.provincia,
                    r.distrito
                FROM ayuda a
                LEFT JOIN remitente r ON a.id_remitente = r.idremite
                ORDER BY a.fecha DESC, a.hora DESC";

        $resultado = $conexion->query($sql);

        $consultas = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $consultas[] = [
                    "ayuda" => [
                        "id_ayuda" => (int)$fila["id_ayuda"],
                        "asunto"   => $fila["asunto"],
                        "mensaje"  => $fila["mensaje"],
                        "fecha"    => $fila["fecha"],
                        "hora"     => $fila["hora"],
                        "fecha_ultimo_mensaje_remitente"    => $fila["fecha_ultimo_mensaje_remitente"],
                        "hora_ultimo_mensaje_remitente"     => $fila["hora_ultimo_mensaje_remitente"],
                        "fecha_ultimo_mensaje_admin"    => $fila["fecha_ultimo_mensaje_admin"],
                        "hora_ultimo_mensaje_admin"     => $fila["hora_ultimo_mensaje_admin"],
                        "estado"   => $fila["estado"]
                    ],
                    "remitente" => [
                        "id_remitente"     => (int)$fila["idremite"],
                        "tipo_remitente"   => $fila["tipo_remitente"],
                        "tipo_documento"   => $fila["retipo_docu"],
                        "numero_documento" => $fila["docu_num"],
                        "nombre_completo"  => $fila["nombres"],
                        "correo"           => $fila["correo"],
                        "telefono_celular" => $fila["telefono_celular"],
                        "departamento"     => $fila["departamento"],
                        "provincia"        => $fila["provincia"],
                        "distrito"         => $fila["distrito"]
                    ]
                ];
            }
        }

        Conexion::desconectarBD();
        return $consultas;
    }

    public function obtenerConsultasPorIdRemitente($idRemitente) {
        $conexion = Conexion::conectarBD();

        $sql = "SELECT 
                    a.id_ayuda,
                    a.asunto,
                    a.mensaje,
                    a.fecha,
                    a.hora,
                    a.fecha_ultimo_mensaje_remitente,
                    a.hora_ultimo_mensaje_remitente,
                    a.fecha_ultimo_mensaje_admin,
                    a.hora_ultimo_mensaje_admin,
                    a.estado,
                    r.idremite,
                    r.tipo_remitente,
                    r.retipo_docu,
                    r.docu_num,
                    r.nombres,
                    r.correo,
                    r.telefono_celular,
                    r.departamento,
                    r.provincia,
                    r.distrito
                FROM ayuda a
                LEFT JOIN remitente r ON a.id_remitente = r.idremite
                WHERE r.idremite = ?
                ORDER BY a.fecha DESC, a.hora DESC";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idRemitente);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $consultas = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $consultas[] = [
                    "ayuda" => [
                        "id_ayuda" => (int)$fila["id_ayuda"],
                        "asunto"   => $fila["asunto"],
                        "mensaje"  => $fila["mensaje"],
                        "fecha"    => $fila["fecha"],
                        "hora"     => $fila["hora"],
                        "fecha_ultimo_mensaje_remitente"    => $fila["fecha_ultimo_mensaje_remitente"],
                        "hora_ultimo_mensaje_remitente"     => $fila["hora_ultimo_mensaje_remitente"],
                        "fecha_ultimo_mensaje_admin"    => $fila["fecha_ultimo_mensaje_admin"],
                        "hora_ultimo_mensaje_admin"     => $fila["hora_ultimo_mensaje_admin"],
                        "estado"   => $fila["estado"]
                    ],
                    "remitente" => [
                        "id_remitente"     => (int)$fila["idremite"],
                        "tipo_remitente"   => $fila["tipo_remitente"],
                        "tipo_documento"   => $fila["retipo_docu"],
                        "numero_documento" => $fila["docu_num"],
                        "nombre_completo"  => $fila["nombres"],
                        "correo"           => $fila["correo"],
                        "telefono_celular" => $fila["telefono_celular"],
                        "departamento"     => $fila["departamento"],
                        "provincia"        => $fila["provincia"],
                        "distrito"         => $fila["distrito"]
                    ]
                ];
            }
        }

        $stmt->close();
        Conexion::desconectarBD();
        return $consultas;
    }

    public function obtenerAyudaYRemitentePorIdAyuda($idAyuda) {
        $conexion = Conexion::conectarBD();

        $sql = "SELECT 
                    a.id_ayuda,
                    a.asunto,
                    a.mensaje,
                    a.fecha,
                    a.hora,
                    a.fecha_ultimo_mensaje_remitente,
                    a.hora_ultimo_mensaje_remitente,
                    a.fecha_ultimo_mensaje_admin,
                    a.hora_ultimo_mensaje_admin,
                    a.estado,
                    r.idremite,
                    r.tipo_remitente,
                    r.retipo_docu,
                    r.docu_num,
                    r.nombres,
                    r.correo,
                    r.telefono_celular,
                    r.departamento,
                    r.provincia,
                    r.distrito
                FROM ayuda a
                LEFT JOIN remitente r ON a.id_remitente = r.idremite
                WHERE a.id_ayuda = ?
                LIMIT 1";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idAyuda);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $resultadoFinal = null;
        if ($resultado && $fila = $resultado->fetch_assoc()) {
            $resultadoFinal = [
                "ayuda" => [
                    "id_ayuda" => (int)$fila["id_ayuda"],
                    "asunto"   => $fila["asunto"],
                    "mensaje"  => $fila["mensaje"],
                    "fecha"    => $fila["fecha"],
                    "hora"     => $fila["hora"],
                    "fecha_ultimo_mensaje_remitente"    => $fila["fecha_ultimo_mensaje_remitente"],
                    "hora_ultimo_mensaje_remitente"     => $fila["hora_ultimo_mensaje_remitente"],
                    "fecha_ultimo_mensaje_admin"    => $fila["fecha_ultimo_mensaje_admin"],
                    "hora_ultimo_mensaje_admin"     => $fila["hora_ultimo_mensaje_admin"],
                    "estado"   => $fila["estado"]
                ],
                "remitente" => [
                    "id_remitente"     => (int)$fila["idremite"],
                    "tipo_remitente"   => $fila["tipo_remitente"],
                    "tipo_documento"   => $fila["retipo_docu"],
                    "numero_documento" => $fila["docu_num"],
                    "nombre_completo"  => $fila["nombres"],
                    "correo"           => $fila["correo"],
                    "telefono_celular" => $fila["telefono_celular"],
                    "departamento"     => $fila["departamento"],
                    "provincia"        => $fila["provincia"],
                    "distrito"         => $fila["distrito"]
                ]
            ];
        }

        Conexion::desconectarBD();
        return $resultadoFinal;
    }

    public function marcarMensajeAdminComoResuelto($idAyuda) {
        $conexion = Conexion::conectarBD();

        // Verificar el estado actual
        $sqlSelect = "SELECT estado FROM ayuda WHERE id_ayuda = ? LIMIT 1";
        $stmtSelect = $conexion->prepare($sqlSelect);

        if (!$stmtSelect) {
            Conexion::desconectarBD();
            return false;
        }

        $stmtSelect->bind_param("i", $idAyuda);
        $stmtSelect->execute();
        $stmtSelect->bind_result($estadoActual);
        $stmtSelect->fetch();
        $stmtSelect->close();

        // Solo actualizar si el estado actual es "En proceso"
        if ($estadoActual === 'En proceso') {
            $sqlUpdate = "UPDATE ayuda SET estado = 'Resuelto' WHERE id_ayuda = ?";
            $stmtUpdate = $conexion->prepare($sqlUpdate);

            if (!$stmtUpdate) {
                Conexion::desconectarBD();
                return false;
            }

            $stmtUpdate->bind_param("i", $idAyuda);
            $resultado = $stmtUpdate->execute();
            $stmtUpdate->close();

            Conexion::desconectarBD();
            return $resultado;
        }

        // Si el estado no es "En proceso", no actualiza
        Conexion::desconectarBD();
        return false;
    }

    public function obtenerConsultasOrdenadasPorUltimoMensajeRemitente() {
        $conexion = Conexion::conectarBD();

        $sql = "
            SELECT 
                a.id_ayuda,
                a.asunto,
                a.mensaje,
                a.fecha,
                a.hora,
                a.fecha_ultimo_mensaje_remitente,
                a.hora_ultimo_mensaje_remitente,
                a.fecha_ultimo_mensaje_admin,
                a.hora_ultimo_mensaje_admin,
                a.estado,
                r.idremite,
                r.tipo_remitente,
                r.retipo_docu,
                r.docu_num,
                r.nombres,
                r.correo,
                r.telefono_celular,
                r.departamento,
                r.provincia,
                r.distrito
            FROM ayuda a
            LEFT JOIN remitente r ON a.id_remitente = r.idremite
            ORDER BY 
                COALESCE(a.fecha_ultimo_mensaje_remitente, a.fecha) DESC,
                COALESCE(a.hora_ultimo_mensaje_remitente, a.hora) DESC
        ";

        $resultado = $conexion->query($sql);
        $consultas = [];

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $consultas[] = [
                    "ayuda" => [
                        "id_ayuda" => (int)$fila["id_ayuda"],
                        "asunto"   => $fila["asunto"],
                        "mensaje"  => $fila["mensaje"],
                        "fecha"    => $fila["fecha"],
                        "hora"     => $fila["hora"],
                        "fecha_ultimo_mensaje_remitente" => $fila["fecha_ultimo_mensaje_remitente"],
                        "hora_ultimo_mensaje_remitente"  => $fila["hora_ultimo_mensaje_remitente"],
                        "fecha_ultimo_mensaje_admin"     => $fila["fecha_ultimo_mensaje_admin"],
                        "hora_ultimo_mensaje_admin"      => $fila["hora_ultimo_mensaje_admin"],
                        "estado"   => $fila["estado"]
                    ],
                    "remitente" => [
                        "id_remitente"     => (int)$fila["idremite"],
                        "tipo_remitente"   => $fila["tipo_remitente"],
                        "tipo_documento"   => $fila["retipo_docu"],
                        "numero_documento" => $fila["docu_num"],
                        "nombre_completo"  => $fila["nombres"],
                        "correo"           => $fila["correo"],
                        "telefono_celular" => $fila["telefono_celular"],
                        "departamento"     => $fila["departamento"],
                        "provincia"        => $fila["provincia"],
                        "distrito"         => $fila["distrito"]
                    ]
                ];
            }
        }

        Conexion::desconectarBD();
        return $consultas;
    }

    public function obtenerMisConsultasOrdenadasPorUltimoMensajeAdmin($idRemitente) {
        $conexion = Conexion::conectarBD();

        $sql = "
            SELECT 
                a.id_ayuda,
                a.asunto,
                a.mensaje,
                a.fecha,
                a.hora,
                a.fecha_ultimo_mensaje_remitente,
                a.hora_ultimo_mensaje_remitente,
                a.fecha_ultimo_mensaje_admin,
                a.hora_ultimo_mensaje_admin,
                a.estado,
                r.idremite,
                r.tipo_remitente,
                r.retipo_docu,
                r.docu_num,
                r.nombres,
                r.correo,
                r.telefono_celular,
                r.departamento,
                r.provincia,
                r.distrito
            FROM ayuda a
            LEFT JOIN remitente r ON a.id_remitente = r.idremite
            WHERE r.idremite = ?
            ORDER BY 
                COALESCE(a.fecha_ultimo_mensaje_admin, a.fecha) DESC,
                COALESCE(a.hora_ultimo_mensaje_admin, a.hora) DESC
        ";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idRemitente);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $consultas = [];

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $consultas[] = [
                    "ayuda" => [
                        "id_ayuda" => (int)$fila["id_ayuda"],
                        "asunto"   => $fila["asunto"],
                        "mensaje"  => $fila["mensaje"],
                        "fecha"    => $fila["fecha"],
                        "hora"     => $fila["hora"],
                        "fecha_ultimo_mensaje_remitente" => $fila["fecha_ultimo_mensaje_remitente"],
                        "hora_ultimo_mensaje_remitente"  => $fila["hora_ultimo_mensaje_remitente"],
                        "fecha_ultimo_mensaje_admin"     => $fila["fecha_ultimo_mensaje_admin"],
                        "hora_ultimo_mensaje_admin"      => $fila["hora_ultimo_mensaje_admin"],
                        "estado"   => $fila["estado"]
                    ],
                    "remitente" => [
                        "id_remitente"     => (int)$fila["idremite"],
                        "tipo_remitente"   => $fila["tipo_remitente"],
                        "tipo_documento"   => $fila["retipo_docu"],
                        "numero_documento" => $fila["docu_num"],
                        "nombre_completo"  => $fila["nombres"],
                        "correo"           => $fila["correo"],
                        "telefono_celular" => $fila["telefono_celular"],
                        "departamento"     => $fila["departamento"],
                        "provincia"        => $fila["provincia"],
                        "distrito"         => $fila["distrito"]
                    ]
                ];
            }
        }

        $stmt->close();
        Conexion::desconectarBD();
        return $consultas;
    }

}