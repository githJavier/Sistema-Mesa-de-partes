<?php
include_once("../../models/tramite.php");
include_once("../../models/tipoDocumento.php");
include_once("../../models/usuario.php");
include_once("../../utils/supabaseUploader.php");

class GetIngresarTramite{
    public $message = "";

    private $objTramite;
    private $uploader;

    public function __construct() {
        $this->objTramite = new Tramite();                  // Para lógica de trámites
        $this->uploader = new SupabaseUploader();           // Para subir documentos
    }

    public function validarBoton($nombreBoton) {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "EnviarTramite";
    }

    public function obtenerUltimoTramite(){
        $getIngresarTramite = $this->objTramite;
        $ultimoTramite = $getIngresarTramite->obtenerUltimoTramite();
        return $ultimoTramite;
    }
    
    public function asignarNumeroTramite(){
        $ultimoTramite = $this->obtenerUltimoTramite();
        $anio = date('Y');
        $codigo_Generado = "";
    
        // Si no existe el último trámite, generamos el primer número de trámite
        if (!$ultimoTramite) {
            //Antes era DOC
            $codigo_Generado = $anio . "-EX" . str_pad(1, 10, "0", STR_PAD_LEFT); // Ejemplo: 2024-EX0000000001
        } else {
            // Si existe el último trámite, extraemos el número y lo incrementamos
            // Antes era DOC
            if (preg_match('/(\d{4}-EX)(\d{10})/', $ultimoTramite, $matches)) {
                //Antes era DOC
                // Usamos la expresión regular para capturar el número
                $numeroTramite = $matches[2]; // Número de trámite extraído
                $numeroIncrementado = (int) $numeroTramite + 1; // Incrementamos el número
                $codigo_Generado = $anio . "-EX" . str_pad($numeroIncrementado, 10, "0", STR_PAD_LEFT); // Generamos el nuevo número
            } else {
                //Antes era DOC
                $codigo_Generado = $anio . "-EX" . str_pad(1, 10, "0", STR_PAD_LEFT); // Ejemplo: 2024-EX0000000001
            }
        }
        return $codigo_Generado;
    }
    
    public function obtenerTipoDocumento(){
        $getTipoDocumento = new TipoDocumento();
        $tipoDocumento = $getTipoDocumento->obtenerTipoDocumento();
        return $tipoDocumento;
    }

    public function obtenerDatosRemitente($usuario){
        $getDatosRemitente = new Usuario();
        $datosRemitente = $getDatosRemitente->obtenerDatosRemitenteForm($usuario);
        return $datosRemitente;
    }

    public function validarAsunto($asunto){
        if (!isset($asunto) || trim($asunto) === "") {
            $this->message = "El asunto es obligatorio.";
            return false;
        }

        // Validar longitud máxima 100 caracteres
        if (strlen($asunto) > 100) {
            $this->message = "El asunto no debe exceder los 100 caracteres. Actualmente tiene " . strlen($asunto) . " caracteres.";
            return false;
        }

        // Si pasa todas las validaciones
        return true;
    }
    
    public function validarTipoDocumento($tipoDocumento){
        if (!isset($tipoDocumento) || trim($tipoDocumento) === "") {
            $this->message = "Debe seleccionar un tipo de documento.";
            return false;
        }
        return true;
    }
    
    public function validarNumeroTramite($numeroTramite){
        if (!isset($numeroTramite) || trim($numeroTramite) === "") {
            $this->message = "El número de trámite es obligatorio.";
            return false;
        }
    
        // Validar formato (ej: 2025-DOC0000000123)
        if (!preg_match('/^\d{4}-EX\d{10}$/', $numeroTramite)) {
            $this->message = "El formato del número de trámite no es válido.";
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

    function limpiarNombreArchivo($nombre) {
        // Transforma caracteres con tilde y ñ
        $nombre = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $nombre);
        // Reemplaza cualquier carácter que no sea seguro para URLs
        $nombre = preg_replace('/[^A-Za-z0-9_\-\.]/', '-', $nombre);
        // Opcional: reemplaza múltiples guiones seguidos por uno solo
        $nombre = preg_replace('/-+/', '-', $nombre);
        return $nombre;
    }

    public function moverArchivo($datosArchivo, $nombreArchivo) {
        $url = $this->uploader->subirDocumento($datosArchivo, $nombreArchivo);
        if ($url) {
            $this->message = $this->uploader->message;
            return $url;
        } else {
            $this->message = $this->uploader->message;
            return false;
        }
    }

    public function insertarTramite($tipoTramite, $anio, $codigoGenerado, $codTipoDocumento, $horaReg, $fecReg, $remitente, $asunto, $folios, $comentario, $area_origen, $area_destino, $final_file, $file_type, $new_size){
        $getIngresarTramite = $this->objTramite;
        $getTramite = new Tramite();
        $num_documento = $getTramite->obtenerNuevoNumeroDocumento();
        $orden = $getTramite->obtenerSiguienteOrdenPorDocumento($num_documento);
        $id_detalle_tramite = $getTramite->obtenerNuevoIdDetalleTramite();
        $respuesta = $getIngresarTramite->ingresarTramite($tipoTramite, $anio, $codigoGenerado, $codTipoDocumento, $horaReg, $fecReg, $remitente, $asunto, $folios, $comentario, $area_origen, $area_destino, $num_documento, $orden, $id_detalle_tramite, $final_file, $file_type, $new_size);
        if($respuesta){
            $this->message = "Trámite ingresado correctamente";
        }else{
            $this->message = "Ocurrio un problema al ingresar el trámite";
        }

        return $respuesta;
    }
}
