<?php 
include_once("../../config/conexion.php");

class Tramite{
    
    public function obtenerUltimoTramite() {
        $conexion = Conexion::conectarBD();
        $sql = "SELECT MAX(codigo_generado) AS ultimo_tramite FROM tramite";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $resultado = null;
        $stmt->bind_result($resultado);
        $stmt->fetch();
        $stmt->close();
        Conexion::desconectarBD();
        return $resultado;
    }

    public function ingresarTramite($tipoTramite, $anio, $codigoGenerado, $codTipoDocumento, $horaReg, $fecReg, $remitente, $asunto) {
        $conexion = Conexion::conectarBD();
        $sql = "INSERT INTO tramite (tipo_tramite, anio, codigo_generado, cod_tipodocumento, hora_reg, fec_reg, remitente, asunto)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }
        $stmt->bind_param(
            "sissssss",  // Tipos: i=int, s=string (ajústalo según tus datos)
            $tipoTramite,
            $anio,
            $codigoGenerado,
            $codTipoDocumento,
            $horaReg,
            $fecReg,
            $remitente,
            $asunto
        );
        $stmt->execute();
        // Puedes retornar true/false o el ID insertado si lo deseas:
        $resultado = $stmt->affected_rows > 0;
        $stmt->close();
        Conexion::desconectarBD();
        return $resultado;
    }

    public function obtenerTramites() {
        $conexion = Conexion::conectarBD();

        // Consulta principal: trae los datos generales de cada trámite
        $sql = "SELECT 
                    t.codigo_generado, 
                    td.tipodocumento, 
                    t.fec_reg,
                    (
                        SELECT e.estado
                        FROM flujo f
                        JOIN estado e ON f.idestadoflujo = e.idestado
                        WHERE f.codigo_generado = t.codigo_generado
                        ORDER BY STR_TO_DATE(
                            CONCAT(f.fec_recep, ' ', TIME_FORMAT(STR_TO_DATE(f.hora_recep, '%l:%i-%p'), '%H:%i:%s')),
                            '%Y-%m-%d %H:%i:%s'
                        ) DESC
                        LIMIT 1
                    ) AS estado,
                    t.asunto,
                    (
                    SELECT remitente FROM tramite WHERE codigo_generado = t.codigo_generado
                    ) AS remitente
                FROM tramite t
                JOIN tipodocumento td ON t.cod_tipodocumento = td.cod_tipodocumento
                ORDER BY
                    CAST(SUBSTRING_INDEX(t.codigo_generado, '-', 1) AS UNSIGNED) DESC,
                    CAST(TRIM(LEADING '0' FROM SUBSTRING(t.codigo_generado, LOCATE('-', t.codigo_generado) + 3)) AS UNSIGNED) DESC";

        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $tramites = [];

        // Recorremos cada trámite
        while ($row = $resultado->fetch_assoc()) {
            $codigo_generado = $row['codigo_generado'];

            // Subconsulta: traer detalles del flujo para este trámite
            $sqlDetalle = "SELECT 
                                f.area_origen,
                                e.estado,
                                f.area_destino,
                                f.fec_recep,
                                f.hora_recep,
                                f.folio,
                                f.comentario
                            FROM flujo f
                            JOIN estado e ON f.idestadoflujo = e.idestado
                            WHERE f.codigo_generado = ?
                            ORDER BY STR_TO_DATE(
                                CONCAT(f.fec_recep, ' ', TIME_FORMAT(STR_TO_DATE(f.hora_recep, '%l:%i-%p'), '%H:%i:%s')),
                                '%Y-%m-%d %H:%i:%s'
                            ) ASC";

            $stmtDetalle = $conexion->prepare($sqlDetalle);
            $stmtDetalle->bind_param("s", $codigo_generado);
            $stmtDetalle->execute();
            $resultadoDetalle = $stmtDetalle->get_result();

            $detallestramite = [];

            while ($detalle = $resultadoDetalle->fetch_assoc()) {
                $detallestramite[] = $detalle;
            }

            $stmtDetalle->close();

            // Construimos el trámite con los detalles
            $tramites[] = [
                'codigo_generado' => $row['codigo_generado'],
                'tipodocumento' => $row['tipodocumento'],
                'fec_reg' => $row['fec_reg'],
                'estado' => $row['estado'],
                'asunto' => $row['asunto'],
                'remitente' => $row['remitente'],
                'detallestramite' => $detallestramite
            ];
        }

        $stmt->close();
        Conexion::desconectarBD();

        return $tramites;
    }
    
    
    
}