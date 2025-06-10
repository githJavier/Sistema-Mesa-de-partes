<?php
include_once("../../../models/tramite.php");

session_start();
class GetDerivarTramite{
    public $message = "";

    private $objTramite;

    public function __construct() {
        $this->objTramite = new Tramite();
    }

    public function validarBoton($nombreBoton) {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "DerivarTramite";
    }

    public function validarMotivo($motivo){
        if (!isset($motivo) || trim($motivo) === "") {
            $this->message = "El asunto es obligatorio.";
            return false;
        }

        // Validar longitud máxima 100 caracteres
        if (strlen($motivo) > 100) {
            $this->message = "El motivo no debe exceder los 100 caracteres. Actualmente tiene " . strlen($motivo) . " caracteres.";
            return false;
        }

        // Si pasa todas las validaciones
        return true;
    }
    
    public function validarAreaDestino($areaDestino){
        if (!isset($areaDestino) || trim($areaDestino) === "") {
            $this->message = "Debe seleccionar un área de destino.";
            return false;
        }
        return true;
    }
    
    public function validarNumeroExpediente($numeroExpediente) {
        if (!isset($numeroExpediente) || trim($numeroExpediente) === "") {
            $this->message = "El número de expediente es obligatorio.";
            return false;
        }

        // Validar formato: Año (4 dígitos), guion, letras opcionales, seguido de 10 dígitos
        if (!preg_match('/^\d{4}-[A-Z]*\d{10}$/i', $numeroExpediente)) {
            $this->message = "El formato del número de expediente no es válido.";
            return false;
        }

        return true;
    }

    public function validarFolios($folios){
        if (!isset($folios) || trim($folios) === "") {
            $this->message = "El número de folios es obligatorio.";
            return false;
        }
    
        if (!ctype_digit($folios) || (int)$folios <= 0) {
            $this->message = "El número de folios debe ser un número entero positivo.";
            return false;
        }
    
        return true;
    }
    
    public function validarArchivo($archivo) {
        if (!isset($archivo) || $archivo['error'] !== UPLOAD_ERR_OK) {
            $this->message = "Debe subir un archivo. ";
            return false;
        }
    
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        $tipoMime = mime_content_type($archivo['tmp_name']);
        $tamanio = $archivo['size'];
    
        // Lista de extensiones y tipos MIME válidos
        $extensionesValidas = ['pdf', 'doc', 'docx'];
        $tiposMimeValidos = [
            'application/pdf',
            'application/msword',                       // .doc
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' // .docx
        ];
    
        if (!in_array($extension, $extensionesValidas) || !in_array($tipoMime, $tiposMimeValidos)) {
            $this->message = "El archivo debe ser PDF, DOC o DOCX válido.";
            return false;
        }
    
        if ($tamanio > (1000 * 1024)) { // 1000 KB = 1 MB
            $this->message = "El archivo no debe superar los 1000 KB (1 MB).";
            return false;
        }
    
        return true;
    }

    public function moverArchivo($archivo, $rutaDestino) {
        if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
            $this->message = "Archivo subido correctamente.";
            return true;
        } else {
            $this->message = "Error al mover el archivo.";
            return false;
        }
    }

    public function DerivarTramite(
        $codigoGenerado,
        $fecReg,
        $horaReg,
        $area_destino,
        $comentario,
        $num_documento,
        $cod_det_tramite,
        $folios,
        $final_file,
        $file_type,
        $new_size,
    ) {
        try {
            $getDerivarTramite = $this->objTramite;

            // Validar sesión
            if (!isset($_SESSION['datos']['area'])) {
                $this->message = "Sesión inválida.";
                return false;
            }

            $area_origen = $_SESSION['datos']['area'];

            // Obtener orden
            $orden = $getDerivarTramite->obtenerSiguienteOrdenPorDocumento($num_documento);
            if ($orden === null) {
                $this->message = "Error al obtener el orden del trámite.";
                return false;
            }

            $id_detalle_tramite = $getDerivarTramite->obtenerNuevoIdDetalleTramite();
            // Llamar al modelo
            $respuesta = $getDerivarTramite->DerivarTramite(
                $codigoGenerado,
                $fecReg,
                $horaReg,
                $area_origen,
                $area_destino,
                $comentario,
                $num_documento,
                $cod_det_tramite,
                $orden,
                $folios,
                $id_detalle_tramite,
                $final_file,
                $file_type,
                $new_size
            );

            if ($respuesta) {
                $this->message = "Trámite ingresado correctamente";
            } else {
                $this->message = "Ocurrió un problema al ingresar el trámite";
            }

            return $respuesta;

        } catch (Exception $e) {
            $this->message = "Error inesperado al procesar el trámite.";
            return false;
        }
    }
}
