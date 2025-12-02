<?php
require_once __DIR__ . '/../../config/conexion.php'; 

class AuthRepository {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::conectarBD();
    }

    public function verificarEstadoUsuario($num_doc) {
        $sql = "SELECT estado FROM usuario WHERE num_doc = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $num_doc);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return $row['estado']; // Devuelve el estado (ej: 1)
        }
        return null; // Usuario no encontrado
    }

    public function verificarRemitente($num_doc) {
        $sql = "SELECT tipo_remitente, retipo_docu FROM remitente WHERE docu_num = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $num_doc);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc(); // Devuelve datos o null/false
    }
}
?>