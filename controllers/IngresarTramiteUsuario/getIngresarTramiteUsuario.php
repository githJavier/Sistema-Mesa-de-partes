<?php
include_once("../../models/tramite.php");
include_once("../../models/tipoDocumento.php");
include_once("../../models/usuario.php");
include_once("../../models/area.php");
include_once("../../utils/supabaseUploader.php");
include_once("../../utils/log_config.php");

class GetIngresarTramiteUsuario {
    public $message = "";

    private $objTramite;
    private $objArea;
    private $objTipoDocumento;
    private $objRemitente;
    private $uploader;

    public function __construct() {
        $this->objTramite = new Tramite();
        $this->objArea = new Area();
        $this->objTipoDocumento = new TipoDocumento();
        $this->objRemitente = new Usuario();
        $this->uploader = new SupabaseUploader();
    }

    public function validarBoton($nombreBoton) {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "EnviarTramiteUsuario";
    }

    public function obtenerUltimoTramiteExterno() {
        $ultimoTramite = $this->objTramite->obtenerUltimoTramiteExterno();

        if (!$ultimoTramite) {
            $this->message = "No se pudo obtener el último trámite externo.";
            return false;
        }

        return $ultimoTramite;
    }

    public function obtenerUltimoTramiteInterno() {
        $ultimoTramite = $this->objTramite->obtenerUltimoTramiteInterno();

        if (!$ultimoTramite) {
            $this->message = "No se pudo obtener el último trámite interno.";
            return false;
        }

        return $ultimoTramite;
    }

    public function asignarNumeroTramite() {
        $anio = date('Y');
        $codigo = [
            'codigo_externo' => '',
            'codigo_interno' => ''
        ];

        $ultimoExterno = $this->obtenerUltimoTramiteExterno();
        if ($ultimoExterno === false || !preg_match('/(\d{4}-EX)(\d{10})/', $ultimoExterno, $matchesEx)) {
            $codigo['codigo_externo'] = $anio . "-EX" . str_pad(1, 10, "0", STR_PAD_LEFT);
        } else {
            $numeroEx = (int) $matchesEx[2] + 1;
            $codigo['codigo_externo'] = $anio . "-EX" . str_pad($numeroEx, 10, "0", STR_PAD_LEFT);
        }

        $ultimoInterno = $this->obtenerUltimoTramiteInterno();
        if ($ultimoInterno === false || !preg_match('/(\d{4}-IN)(\d{10})/', $ultimoInterno, $matchesIn)) {
            $codigo['codigo_interno'] = $anio . "-IN" . str_pad(1, 10, "0", STR_PAD_LEFT);
        } else {
            $numeroIn = (int) $matchesIn[2] + 1;
            $codigo['codigo_interno'] = $anio . "-IN" . str_pad($numeroIn, 10, "0", STR_PAD_LEFT);
        }

        return $codigo;
    }

    public function obtenerTipoDocumento() {
        $tipos = $this->objTipoDocumento->obtenerTipoDocumento();

        if (!is_array($tipos) || empty($tipos)) {
            $this->message = "No se pudo obtener la lista de tipos de documento.";
            return false;
        }

        return $tipos;
    }

    public function obtenerDatosRemitente($usuario) {
        $remitente = (new Usuario())->obtenerDatosRemitenteForm($usuario);

        if (!is_array($remitente) || empty($remitente)) {
            $this->message = "No se encontraron datos para el remitente especificado.";
            return false;
        }

        return $remitente;
    }

    public function validarAsunto($asunto) {
        if (!isset($asunto) || trim($asunto) === "") {
            $this->message = "El asunto es obligatorio.";
            return false;
        }

        if (strlen($asunto) > 100) {
            $this->message = "El asunto no debe exceder los 100 caracteres. Actualmente tiene " . strlen($asunto) . " caracteres.";
            return false;
        }

        return true;
    }

    public function validarObservacion($observacion) {
        if (!isset($observacion) || trim($observacion) === "") {
            $this->message = "La observación es obligatoria.";
            return false;
        }

        if (strlen($observacion) > 100) {
            $this->message = "La observación no debe exceder los 100 caracteres. Actualmente tiene " . strlen($observacion) . " caracteres.";
            return false;
        }

        return true;
    }

    public function validarTipoTramite($tipoTramite) {
        $tiposPermitidos = ['INTERNO', 'EXTERNO'];

        if (!isset($tipoTramite) || trim($tipoTramite) === "") {
            $this->message = "El tipo de trámite es obligatorio.";
            return false;
        }

        if (!in_array($tipoTramite, $tiposPermitidos)) {
            $this->message = "El tipo de trámite debe ser INTERNO o EXTERNO. Valor recibido: '{$tipoTramite}'.";
            return false;
        }

        return true;
    }

    public function validarUrgencia($urgente) {
        $valoresPermitidos = ['SI', 'NO'];

        if (!isset($urgente) || trim($urgente) === "") {
            $this->message = "Debe indicar si el trámite es urgente o no.";
            return false;
        }

        if (!in_array(strtoupper($urgente), $valoresPermitidos)) {
            $this->message = "El campo 'urgente' solo puede ser 'SI' o 'NO'. Valor recibido: '{$urgente}'.";
            return false;
        }

        return true;
    }

    public function validarTipoDocumento($tipoDocumento) {
        if (!isset($tipoDocumento) || trim($tipoDocumento) === "") {
            $this->message = "Debe seleccionar un tipo de documento.";
            return false;
        }

        $tiposDocumento = $this->obtenerTipoDocumento();
        if ($tiposDocumento === false) return false;

        $IDDeTiposDocumento = array_column($tiposDocumento, 'cod_tipodocumento');

        if (!in_array($tipoDocumento, $IDDeTiposDocumento)) {
            $this->message = "El tipo de documento seleccionado no es válido.";
            return false;
        }

        return true;
    }

    public function validarNumeroTramite($numeroTramite) {
        if (!isset($numeroTramite) || trim($numeroTramite) === "") {
            $this->message = "El número de trámite es obligatorio.";
            return false;
        }

        if (!preg_match('/^\d{4}-(EX|IN)\d{10}$/', $numeroTramite)) {
            $this->message = "El formato del número de trámite no es válido. Debe ser: AAAA-EX########## o AAAA-IN##########.";
            return false;
        }

        return true;
    }

    public function validarAreaDestino($areaDestino) {
        if (!isset($areaDestino) || trim($areaDestino) === "") {
            $this->message = "Debe seleccionar un área de destino.";
            return false;
        }

        $areas = $this->objArea->obtenerAreas();

        if (!is_array($areas) || empty($areas)) {
            $this->message = "No se pudo obtener la lista de áreas disponibles.";
            return false;
        }

        $nombresDeAreas = array_column($areas, 'area');

        if (!in_array($areaDestino, $nombresDeAreas)) {
            $this->message = "El área de destino seleccionada no es válida.";
            return false;
        }

        return true;
    }

    public function validarRemitente($remitente) {
        if (!isset($remitente) || trim($remitente) === "") {
            $this->message = "Debe seleccionar un remitente.";
            return false;
        }

        $remitentes = $this->objRemitente->listarRemitentes();

        if (!is_array($remitentes) || empty($remitentes)) {
            $this->message = "No se pudo obtener la lista de remitentes disponibles.";
            return false;
        }

        $nombresDeRemitentes = array_map(function($nombre) {
            return trim(mb_strtoupper($nombre)); // homogeniza
        }, array_column($remitentes, 'nombres'));

        $remitenteNormalizado = trim(mb_strtoupper($remitente)); // homogeniza

        if (!in_array($remitenteNormalizado, $nombresDeRemitentes)) {
            $this->message = "El remitente seleccionado no es válido.";
            return false;
        }

        return true;
    }

    public function validarFolios($folios) {
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
            $this->message = "Debe subir un archivo.";
            return false;
        }

        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        $tipoMime = mime_content_type($archivo['tmp_name']);
        $tamanio = $archivo['size'];

        $extensionesValidas = ['pdf', 'doc', 'docx'];
        $tiposMimeValidos = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        if (!in_array($extension, $extensionesValidas) || !in_array($tipoMime, $tiposMimeValidos)) {
            $this->message = "El archivo debe ser PDF, DOC o DOCX válido.";
            return false;
        }

        if ($tamanio > (1000 * 1024)) {
            $this->message = "El archivo no debe superar los 1000 KB (1 MB).";
            return false;
        }

        return true;
    }

    function limpiarNombreArchivo($nombre) {
        $nombre = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $nombre);
        $nombre = preg_replace('/[^A-Za-z0-9_\-\.]/', '-', $nombre);
        $nombre = preg_replace('/-+/', '-', $nombre);
        return $nombre;
    }

    public function moverArchivo($datosArchivo, $nombreArchivo) {
        $url = $this->uploader->subirDocumento($datosArchivo, $nombreArchivo);

        if (!$url) {
            $this->message = $this->uploader->message;
            return false;
        }

        $this->message = $this->uploader->message;
        return $url;
    }

    public function insertarTramiteUsuario($tipoTramite, $anio, $codigoGenerado, $codTipoDocumento, $horaReg, $fecReg, $remitente, $asunto, $folios, $comentario, $area_origen, $area_destino, $cod_usuario, $urgente, $final_file, $file_type, $new_size) {
        $getTramite = new Tramite();
        $num_documento = $getTramite->obtenerNuevoNumeroDocumento($tipoTramite);
        $orden = $getTramite->obtenerSiguienteOrdenPorDocumento($num_documento, $codigoGenerado);
        $id_detalle_tramite = $getTramite->obtenerNuevoIdDetalleTramite();

        $respuesta = $this->objTramite->ingresarTramiteUsuario(
            $tipoTramite, $anio, $codigoGenerado, $codTipoDocumento, $horaReg, $fecReg,
            $remitente, $asunto, $folios, $comentario, $area_origen, $area_destino,
            $cod_usuario, $urgente, $num_documento, $orden, $id_detalle_tramite,
            $final_file, $file_type, $new_size
        );

        if (!$respuesta) {
            $this->message = "Ocurrió un problema al ingresar el trámite.";
            return false;
        }

        $this->message = "Trámite ingresado correctamente";
        return $respuesta;
    }
}