<?php 
require_once __DIR__ . '/../utils/log_config.php';
include_once("../../config/conexion.php");

class Tramite{
    
    public function obtenerUltimoTramite() {
        $conexion = Conexion::conectarBD();
        $sql = "SELECT codigo_generado 
                FROM tramite 
                WHERE tipo_tramite = 'EXTERNO' 
                ORDER BY num_documento DESC 
                LIMIT 1;";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $resultado = null;
        $stmt->bind_result($resultado);
        $stmt->fetch();
        $stmt->close();
        Conexion::desconectarBD();
        return $resultado;
    }

    public function obtenerNuevoNumeroDocumento(): int {
        $conexion = Conexion::conectarBD();

        $sql = "SELECT MAX(num_documento) 
                FROM tramite 
                WHERE tipo_tramite = 'EXTERNO';";

        $stmt = $conexion->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación: " . $conexion->error);
        }

        $stmt->execute();

        $resultado = null;
        $stmt->bind_result($resultado);
        $stmt->fetch();

        $stmt->close();
        Conexion::desconectarBD();

        return $resultado !== null ? (int)$resultado + 1 : 1;
    }

    public function obtenerSiguienteOrdenPorDocumento(int $numDocu): int {
        $conexion = Conexion::conectarBD();

        $sql = "SELECT MAX(orden) 
                FROM flujo 
                WHERE num_documento = ?";

        $stmt = $conexion->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conexion->error);
        }

        $stmt->bind_param("i", $numDocu);
        $stmt->execute();

        $resultado = null;
        $stmt->bind_result($resultado);
        $stmt->fetch();

        $stmt->close();
        Conexion::desconectarBD();

        return $resultado !== null ? (int)$resultado + 1 : 1;
    }

    public function obtenerNuevoIdDetalleTramite(): int {
        $conexion = Conexion::conectarBD();

        $sql = "SELECT MAX(cod_detalletramite) FROM detalletramite";

        $stmt = $conexion->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conexion->error);
        }

        $stmt->execute();

        $resultado = null;
        $stmt->bind_result($resultado);
        $stmt->fetch();

        $stmt->close();
        Conexion::desconectarBD();

        return $resultado !== null ? (int)$resultado + 1 : 1;
    }

    public function ingresarTramite($tipoTramite, $anio, $codigoGenerado, $codTipoDocumento, $horaReg, $fecReg, $remitente, $asunto, $folios, $comentario, $area_origen, $area_destino, $num_documento, $orden, $id_detalle_tramite, $final_file, $file_type, $new_size) {
        $conexion = Conexion::conectarBD();
        $resultado = false;

        try {
            $conexion->begin_transaction();

            // 1. Insertar en la tabla 'tramite'
            $sqlTramite = "INSERT INTO tramite (
                                tipo_tramite, anio, codigo_generado, cod_tipodocumento,
                                hora_reg, fec_reg, remitente, asunto, num_documento
                        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt0 = $conexion->prepare($sqlTramite);
            if (!$stmt0) {
                throw new Exception("Error al preparar stmt0: " . $conexion->error);
            }

            $stmt0->bind_param("ssssssssi", $tipoTramite, $anio, $codigoGenerado, $codTipoDocumento, $horaReg, $fecReg, $remitente, $asunto, $num_documento);
            $stmt0->execute();
            //error_log("✅ Registro en 'tramite' insertado correctamente: $codigoGenerado");

            // 2. Insertar en la tabla 'detalletramite'
            $sqlDetalle = "INSERT INTO detalletramite (
                                fec_recep, hora_recep, folio, comentario,
                                codigo_generado, area_origen, area_destino,
                                idusuario, idestadode, urgente
                        ) VALUES (?, ?, ?, ?, ?, ?, ?, 1, 11, 'NO')";
            $stmt1 = $conexion->prepare($sqlDetalle);
            if (!$stmt1) {
                throw new Exception("Error al preparar stmt1: " . $conexion->error);
            }

            $stmt1->bind_param("ssissss", $fecReg, $horaReg, $folios, $comentario, $codigoGenerado, $area_origen, $area_destino);
            $stmt1->execute();
            //error_log("✅ Registro en 'detalletramite' insertado correctamente para código: $codigoGenerado");

            // 2. Insertar en la tabla 'flujo'
            $sqlFlujo = "INSERT INTO flujo (
                                codigo_generado, fec_recep, hora_recep, 
                                folio, idestadoflujo, comentario, area_origen, 
                                area_destino, num_documento, orden
                        ) VALUES (?, ?, ?, ?, 11, ?, ?, ?, ?, ?)";
            $stmt2 = $conexion->prepare($sqlFlujo);
            if (!$stmt2) {
                throw new Exception("Error al preparar stmt2: " . $conexion->error);
            }

            $stmt2->bind_param("sssisssii", $codigoGenerado, $fecReg, $horaReg, $folios, $comentario, $area_origen, $area_destino, $num_documento, $orden);
            $stmt2->execute();
            //error_log("✅ Registro en 'flujo' insertado correctamente para código: $codigoGenerado");

            // 3. Insertar en la tabla 'adjunto'
            $sqlAdjunto = "INSERT INTO adjunto (
                                iddetalletramite, file, type, size
                        ) VALUES (?, ?, ?, ?)";
            $stmt3 = $conexion->prepare($sqlAdjunto);
            if (!$stmt3) {
                throw new Exception("Error al preparar stmt3: " . $conexion->error);
            }

            $stmt3->bind_param("isss", $id_detalle_tramite, $final_file, $file_type, $new_size);
            $stmt3->execute();
            //error_log("✅ Registro en 'adjunto' insertado correctamente para código: $id_detalle_tramite");

            // Confirmar transacción
            $conexion->commit();
            $resultado = true;

        } catch (Exception $e) {
            $conexion->rollback();
            //error_log("❌ Error al ingresar trámite: " . $e->getMessage());
        } finally {
            if (isset($stmt0)) $stmt0->close();
            if (isset($stmt1)) $stmt1->close();
            if (isset($stmt2)) $stmt2->close();
            if (isset($stmt3)) $stmt3->close();
            Conexion::desconectarBD();
        }

        return $resultado;
    }


    public function obtenerMisTramites($nombre_usuario) {
    $conexion = Conexion::conectarBD();
    $tramites = [];

    try {
        $area_usuario = null;

        // 2. Obtener trámites archivados por área
        $sql = "SELECT 
                    e.estado as dt_estado,
                    dt.urgente as dt_urgente,
                    dt.area_origen as dt_area_origen,
                    dt.area_destino as dt_area_destino,
                    dt.codigo_generado as dt_codigo_generado,
                    dt.fec_recep as dt_fec_recep,
                    dt.hora_recep as dt_hora_recep
                FROM detalletramite dt
                INNER JOIN estado e ON dt.idestadode = e.idestado
                INNER JOIN tramite t ON dt.codigo_generado = t.codigo_generado
                WHERE t.remitente = ?
                ORDER BY dt.codigo_generado DESC";
        $stmt1 = $conexion->prepare($sql);
        $stmt1->bind_param("s", $nombre_usuario);
        $stmt1->execute();
        $data_detalle_tramite = $stmt1->get_result();

        if ($data_detalle_tramite->num_rows === 0) {
            //error_log("ℹ️ No hay trámites archivados para el área: " . $area_usuario);
            return [];
        }

        // 3. Recorrer trámites encontrados
        while ($row = $data_detalle_tramite->fetch_assoc()) {
            $codigo_generado = $row['dt_codigo_generado'];
            $detalle = $row;

            // 3.1 Obtener datos del trámite principal
            $sql_tramite = "SELECT 
                                td.tipodocumento as t_tipodocumento,
                                t.fec_reg as t_fec_reg,
                                t.asunto as t_asunto,
                                t.remitente as t_remitente,
                                t.codigo_generado as t_codigo_generado
                            FROM tramite t
                            INNER JOIN tipodocumento td ON t.cod_tipodocumento = td.cod_tipodocumento
                            WHERE t.codigo_generado = ?";
            $stmt2 = $conexion->prepare($sql_tramite);
            $stmt2->bind_param("s", $codigo_generado);
            $stmt2->execute();
            $data_tramite = $stmt2->get_result();

            if ($row_tramite = $data_tramite->fetch_assoc()) {
                $detalle = array_merge($detalle, $row_tramite);
            } else {
                //error_log("⚠️ Trámite no encontrado para código: " . $codigo_generado);
            }

            // 3.2 Obtener historial de flujo
            $sql_flujo = "SELECT 
                            e.estado as f_estado,
                            f.area_origen as f_area_origen,
                            f.area_destino as f_area_destino,
                            f.comentario as f_comentario,
                            f.folio as f_folio,
                            f.hora_recep as f_hora_recep,
                            f.fec_recep as f_fec_recep,
                            f.codigo_generado as f_codigo_generado,
                            f.idflujo as f_idflujo
                        FROM flujo f
                        INNER JOIN estado e ON f.idestadoflujo = e.idestado
                        WHERE f.codigo_generado = ?
                        ORDER BY f.orden DESC";
            $stmt3 = $conexion->prepare($sql_flujo);
            $stmt3->bind_param("s", $codigo_generado);
            $stmt3->execute();
            $data_flujo = $stmt3->get_result();

            $flujo = [];
            while ($detalle_flujo = $data_flujo->fetch_assoc()) {
                $flujo[] = $detalle_flujo;
            }

            // 3.3 Construcción final
            $tramites[] = [
                'dt_estado'           => $detalle['dt_estado'],
                'dt_urgente'          => $detalle['dt_urgente'],
                'dt_area_origen'      => $detalle['dt_area_origen'],
                'dt_area_destino'     => $detalle['dt_area_destino'],
                'dt_codigo_generado'  => $detalle['dt_codigo_generado'],
                'dt_fec_recep'        => $detalle['dt_fec_recep'],
                'dt_hora_recep'       => $detalle['dt_hora_recep'],
                't_tipodocumento'     => $detalle['t_tipodocumento'] ?? null,
                't_fec_reg'           => $detalle['t_fec_reg'] ?? null,
                't_asunto'            => $detalle['t_asunto'] ?? null,
                't_remitente'         => $detalle['t_remitente'] ?? null,
                't_codigo_generado'   => $detalle['t_codigo_generado'] ?? $codigo_generado,
                'flujo'               => $flujo
            ];
        }
    } catch (Exception $e) {
        //error_log("❌ Error al obtener trámites archivados: " . $e->getMessage());
        return [];
    } finally {
        if (isset($stmt0)) $stmt0->close();
        if (isset($stmt1)) $stmt1->close();
        if (isset($stmt2)) $stmt2->close();
        if (isset($stmt3)) $stmt3->close();
        Conexion::desconectarBD();
    }

    return $tramites;
}

    //Consulta exclusiva para administradores
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

public function obtenerTramitesArchivados($nombre_usuario) {
    $conexion = Conexion::conectarBD();
    $tramites = [];

    try {
        // 1. Obtener área del usuario
        $sql = "SELECT u.usuario, u.cod_usuario, a.area
                FROM usuario u
                INNER JOIN area a ON u.cod_area = a.cod_area
                WHERE u.usuario = ?";
        $stmt0 = $conexion->prepare($sql);
        $stmt0->bind_param("s", $nombre_usuario);
        $stmt0->execute();
        $data_usuario = $stmt0->get_result();

        $area_usuario = null;
        if ($row = $data_usuario->fetch_assoc()) {
            $area_usuario = $row['area'];
        } else {
            //error_log("⚠️ Usuario no encontrado o sin área asignada.");
            return [];
        }

        // 2. Obtener trámites archivados por área
        $sql = "SELECT 
                    e.estado as dt_estado,
                    dt.urgente as dt_urgente,
                    dt.area_origen as dt_area_origen,
                    dt.area_destino as dt_area_destino,
                    dt.codigo_generado as dt_codigo_generado,
                    dt.fec_recep as dt_fec_recep,
                    dt.hora_recep as dt_hora_recep
                FROM detalletramite dt
                INNER JOIN estado e ON dt.idestadode = e.idestado
                WHERE e.estado = 'Archivado' AND dt.area_origen = ?
                ORDER BY dt.codigo_generado DESC";
        $stmt1 = $conexion->prepare($sql);
        $stmt1->bind_param("s", $area_usuario);
        $stmt1->execute();
        $data_detalle_tramite = $stmt1->get_result();

        if ($data_detalle_tramite->num_rows === 0) {
            //error_log("ℹ️ No hay trámites archivados para el área: " . $area_usuario);
            return [];
        }

        // 3. Recorrer trámites encontrados
        while ($row = $data_detalle_tramite->fetch_assoc()) {
            $codigo_generado = $row['dt_codigo_generado'];
            $detalle = $row;

            // 3.1 Obtener datos del trámite principal
            $sql_tramite = "SELECT 
                                td.tipodocumento as t_tipodocumento,
                                t.fec_reg as t_fec_reg,
                                t.asunto as t_asunto,
                                t.remitente as t_remitente,
                                t.codigo_generado as t_codigo_generado
                            FROM tramite t
                            INNER JOIN tipodocumento td ON t.cod_tipodocumento = td.cod_tipodocumento
                            WHERE t.codigo_generado = ?";
            $stmt2 = $conexion->prepare($sql_tramite);
            $stmt2->bind_param("s", $codigo_generado);
            $stmt2->execute();
            $data_tramite = $stmt2->get_result();

            if ($row_tramite = $data_tramite->fetch_assoc()) {
                $detalle = array_merge($detalle, $row_tramite);
            } else {
                //error_log("⚠️ Trámite no encontrado para código: " . $codigo_generado);
            }

            // 3.2 Obtener historial de flujo
            $sql_flujo = "SELECT 
                            e.estado as f_estado,
                            f.area_origen as f_area_origen,
                            f.area_destino as f_area_destino,
                            f.comentario as f_comentario,
                            f.folio as f_folio,
                            f.hora_recep as f_hora_recep,
                            f.fec_recep as f_fec_recep,
                            f.codigo_generado as f_codigo_generado,
                            f.idflujo as f_idflujo
                        FROM flujo f
                        INNER JOIN estado e ON f.idestadoflujo = e.idestado
                        WHERE f.codigo_generado = ?
                        ORDER BY f.orden DESC";
            $stmt3 = $conexion->prepare($sql_flujo);
            $stmt3->bind_param("s", $codigo_generado);
            $stmt3->execute();
            $data_flujo = $stmt3->get_result();

            $flujo = [];
            while ($detalle_flujo = $data_flujo->fetch_assoc()) {
                $flujo[] = $detalle_flujo;
            }

            // 3.3 Construcción final
            $tramites[] = [
                'dt_estado'           => $detalle['dt_estado'],
                'dt_urgente'          => $detalle['dt_urgente'],
                'dt_area_origen'      => $detalle['dt_area_origen'],
                'dt_area_destino'     => $detalle['dt_area_destino'],
                'dt_codigo_generado'  => $detalle['dt_codigo_generado'],
                'dt_fec_recep'        => $detalle['dt_fec_recep'],
                'dt_hora_recep'       => $detalle['dt_hora_recep'],
                't_tipodocumento'     => $detalle['t_tipodocumento'] ?? null,
                't_fec_reg'           => $detalle['t_fec_reg'] ?? null,
                't_asunto'            => $detalle['t_asunto'] ?? null,
                't_remitente'         => $detalle['t_remitente'] ?? null,
                't_codigo_generado'   => $detalle['t_codigo_generado'] ?? $codigo_generado,
                'flujo'               => $flujo
            ];
        }
    } catch (Exception $e) {
        //error_log("❌ Error al obtener trámites archivados: " . $e->getMessage());
        return [];
    } finally {
        if (isset($stmt0)) $stmt0->close();
        if (isset($stmt1)) $stmt1->close();
        if (isset($stmt2)) $stmt2->close();
        if (isset($stmt3)) $stmt3->close();
        Conexion::desconectarBD();
    }

    return $tramites;
}
    
public function obtenerTramitesDerivados($nombre_usuario) {
    $conexion = Conexion::conectarBD();
    $tramites = [];

    try {
        // 1. Obtener área del usuario
        $sql = "SELECT u.usuario, u.cod_usuario, a.area
                FROM usuario u
                INNER JOIN area a ON u.cod_area = a.cod_area
                WHERE u.usuario = ?";
        $stmt0 = $conexion->prepare($sql);
        $stmt0->bind_param("s", $nombre_usuario);
        $stmt0->execute();
        $data_usuario = $stmt0->get_result();

        $area_usuario = null;
        if ($row = $data_usuario->fetch_assoc()) {
            $area_usuario = $row['area'];
        } else {
            //error_log("⚠️ Usuario no encontrado o sin área asignada.");
            return []; // No se continúa sin área
        }

        // 2. Obtener trámites derivados por área
        $sql = "SELECT 
                    e.estado as dt_estado,
                    dt.urgente as dt_urgente,
                    dt.area_origen as dt_area_origen,
                    dt.area_destino as dt_area_destino,
                    dt.codigo_generado as dt_codigo_generado,
                    dt.fec_recep as dt_fec_recep,
                    dt.hora_recep as dt_hora_recep
                FROM detalletramite dt
                INNER JOIN estado e ON dt.idestadode = e.idestado
                WHERE e.estado = 'Derivado' AND dt.area_origen = ?
                ORDER BY dt.codigo_generado DESC";
        $stmt1 = $conexion->prepare($sql);
        $stmt1->bind_param("s", $area_usuario);
        $stmt1->execute();
        $data_detalle_tramite = $stmt1->get_result();

        if ($data_detalle_tramite->num_rows === 0) {
            //error_log("ℹ️ No hay trámites derivados para el área: " . $area_usuario);
            return [];
        }

        // 3. Procesar trámites
        while ($row = $data_detalle_tramite->fetch_assoc()) {
            $codigo_generado = $row['dt_codigo_generado'];
            $detalle = $row;

            // 3.1 Obtener datos del trámite principal
            $sql_tramite = "SELECT 
                                td.tipodocumento as t_tipodocumento,
                                t.fec_reg as t_fec_reg,
                                t.asunto as t_asunto,
                                t.remitente as t_remitente,
                                t.codigo_generado as t_codigo_generado
                            FROM tramite t
                            INNER JOIN tipodocumento td ON t.cod_tipodocumento = td.cod_tipodocumento
                            WHERE t.codigo_generado = ?";
            $stmt2 = $conexion->prepare($sql_tramite);
            $stmt2->bind_param("s", $codigo_generado);
            $stmt2->execute();
            $data_tramite = $stmt2->get_result();

            if ($row_tramite = $data_tramite->fetch_assoc()) {
                $detalle = array_merge($detalle, $row_tramite);
            } else {
                //error_log("⚠️ Trámite no encontrado para código: " . $codigo_generado);
            }

            // 3.2 Obtener historial del flujo del trámite
            $sql_flujo = "SELECT 
                            e.estado as f_estado,
                            f.area_origen as f_area_origen,
                            f.area_destino as f_area_destino,
                            f.comentario as f_comentario,
                            f.folio as f_folio,
                            f.hora_recep as f_hora_recep,
                            f.fec_recep as f_fec_recep,
                            f.codigo_generado as f_codigo_generado,
                            f.idflujo as f_idflujo
                        FROM flujo f
                        INNER JOIN estado e ON f.idestadoflujo = e.idestado
                        WHERE f.codigo_generado = ?
                        ORDER BY f.orden DESC";
            $stmt3 = $conexion->prepare($sql_flujo);
            $stmt3->bind_param("s", $codigo_generado);
            $stmt3->execute();
            $data_flujo = $stmt3->get_result();

            $flujo = [];
            while ($detalle_flujo = $data_flujo->fetch_assoc()) {
                $flujo[] = $detalle_flujo;
            }

            // 3.3 Construcción final del trámite
            $tramites[] = [
                'dt_estado'           => $detalle['dt_estado'],
                'dt_urgente'          => $detalle['dt_urgente'],
                'dt_area_origen'      => $detalle['dt_area_origen'],
                'dt_area_destino'     => $detalle['dt_area_destino'],
                'dt_codigo_generado'  => $detalle['dt_codigo_generado'],
                'dt_fec_recep'        => $detalle['dt_fec_recep'],
                'dt_hora_recep'       => $detalle['dt_hora_recep'],
                't_tipodocumento'     => $detalle['t_tipodocumento'] ?? null,
                't_fec_reg'           => $detalle['t_fec_reg'] ?? null,
                't_asunto'            => $detalle['t_asunto'] ?? null,
                't_remitente'         => $detalle['t_remitente'] ?? null,
                't_codigo_generado'   => $detalle['t_codigo_generado'] ?? $codigo_generado,
                'flujo'               => $flujo
            ];
        }

    } catch (Exception $e) {
        //error_log("❌ Error al obtener trámites derivados: " . $e->getMessage());
        return [];
    } finally {
        // Cierre de conexiones
        if (isset($stmt0)) $stmt0->close();
        if (isset($stmt1)) $stmt1->close();
        if (isset($stmt2)) $stmt2->close();
        if (isset($stmt3)) $stmt3->close();
        Conexion::desconectarBD();
    }

    return $tramites;
}

    
}