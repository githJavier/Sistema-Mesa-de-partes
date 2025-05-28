<?php
include_once("../../models/ubicacion.php");
include_once("../../models/usuario.php");

class GetAjustes {
    public $message = "";

    public function validarBoton($nombreBoton) {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "GuardarDatos";
    }

    public function obtenerDepartamento(){
        $getDepartamento = new Ubicacion;
        return $getDepartamento->obtenerDepartamento();
    }

    public function obtenerProvincia($departamento){
        $getProvincia = new Ubicacion;
        return $getProvincia->obtenerProvincia($departamento);
    }

    public function obtenerDistrito($provincia){
        $getDistrito = new Ubicacion;
        return $getDistrito->obtenerDistrito($provincia);
    }

    public function obtenerDatosRemitente($remitente){
        $getDatosRemitente = new Usuario();
        return $getDatosRemitente->obtenerDatosRemitenteForm($remitente);
    }

    public function actualizarUbicacionRemitente($numeroDocumento, $departamento, $provincia, $distrito, $direccion, $telefono){
        $getDatosRemitente = new Usuario();
        if($getDatosRemitente->actualizarUbicacionRemitente($numeroDocumento, $departamento, $provincia, $distrito, $direccion,$telefono)){
            $this->message = "Datos guardados correctamente.";
            return true;
        }else{
            $this->message = "Ocurrio un error.";
            return false;
        }
        
    }

    public function validarCelular($celular) {
        if (empty($celular)) {
            $this->message = "El campo celular es obligatorio.";
            return false;
        } elseif (!preg_match('/^9\d{8}$/', $celular)) {
            $this->message = "El número de celular no es válido.";
            return false;
        }
        return true;
    }
    public function validarDepartamento($departamento) {
        if (empty($departamento) || $departamento === '-- Selecciona un departamento --' || $departamento === '0') {
            $this->message = "El campo departamento es obligatorio.";
            return false;
        }
        return true;
    }
    
    public function validarProvincia($provincia) {
        if (empty($provincia) || $provincia === '-- Selecciona una provincia --' || $provincia === '0') {
            $this->message = "El campo provincia es obligatorio.";
            return false;
        }
        return true;
    }
    
    public function validarDistrito($distrito) {
        if (empty($distrito) || $distrito === '-- Selecciona un distrito --' || $distrito === '0') {
            $this->message = "El campo distrito es obligatorio.";
            return false;
        }
        return true;
    }
    

    public function validarDireccion($direccion) {
        if (empty(trim($direccion))) {
            $this->message = "El campo dirección es obligatorio.";
            return false;
        }
        return true;
    }

    public function obtenerRemitenteId($id){
        $getDatosRemitente = new Usuario();
        $datosRemitente = $getDatosRemitente->obtenerRemitentePorId($id);
        if ($datosRemitente) {
            return $datosRemitente;
        } else {
            return null;
        }
    }

    public function obtenerUsuarioId($id){
        $getDatosUsuario = new Usuario();
        $datosUsuario = $getDatosUsuario->obtenerUsuarioPorId($id);
        if ($datosUsuario) {
            return $datosUsuario;
        } else {
            return null;
        }
    }

    public function actualizarRegistroRemitente($correo, $telefono_celular, $clave, $idremite){
        $getUsuario = new Usuario();
        $respuesta = $getUsuario->actualizarDatosRemitente($correo, $telefono_celular, $clave, $idremite);
        if($respuesta){
            $this->message = "Los datos fueron actualizados correctamente";
        }else{
            $this->message = "No se pudieron actualizar los datos"; 
        }
    }

    public function actualizarRegistroUsuario($id, $tipoDocumento, $numeroDocumento, $nombre, $apellidoPaterno, $apellidoMaterno, $tipoUsuario, $estadoUsuario, $areaUsuario, $remitente, $claveHash){
        $getUsuario = new Usuario();
        $respuesta = $getUsuario->actualizarDatosUsuario($id, $tipoDocumento, $numeroDocumento, $nombre, $apellidoPaterno, $apellidoMaterno, $tipoUsuario, $estadoUsuario, $areaUsuario, $remitente, $claveHash);
        if($respuesta){
            $this->message = "Los datos fueron actualizados correctamente";
        }else{
            $this->message = "No se pudieron actualizar los datos"; 
        }
    }

    public function eliminarRemitente($id){
        $getUsuario = new Usuario();
        $respuesta = $getUsuario->eliminarRemitente($id);
        if($respuesta){
            $this->message = "Remitente eliminado correctamente";
        }else{
            $this->message = "No se pudo eliminar el registro"; 
        }
    }

    public function eliminarUsuario($id){
        $getUsuario = new Usuario();
        $respuesta = $getUsuario->eliminarUsuario($id);
        if($respuesta){
            $this->message = "Usuario eliminado correctamente";
        }else{
            $this->message = "No se pudo eliminar el registro"; 
        }
    }

}

?>
