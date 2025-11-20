<?php
// Indica que la respuesta será de tipo JSON
header('Content-Type: application/json');

// Verifica si la solicitud es POST y si se recibió el campo 'documento'
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['documento'])) {
    $documento = trim($_POST['documento']); // Limpia espacios en blanco

    // Valida que no esté vacío
    if (empty($documento)) {
        echo json_encode(["success" => false, "message" => "El documento es obligatorio."]);
        exit;
    }

    // Si es un DNI (8 dígitos)
    if (preg_match('/^\d{8}$/', $documento)) {
        $consulta = new consultaDocumento();
        $persona = $consulta->consultarDNI($documento);

        // Si se obtuvo respuesta válida
        if ($persona && isset($persona->data->nombres)) {
            echo json_encode([
                "success" => true,
                "tipo" => "DNI",
                "data" => [
                    "nombre_completo" => $persona->data->nombre_completo,
                    "nombres"         => $persona->data->nombres,
                    "apellidoPaterno" => $persona->data->apellido_paterno,
                    "apellidoMaterno" => $persona->data->apellido_materno
                ]
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "No se encontraron datos para el DNI ingresado."
            ]);
        }

    // Si es un RUC (11 dígitos)
    } elseif (preg_match('/^\d{11}$/', $documento)) {
        $consulta = new consultaDocumento();
        $empresa = $consulta->consultarRUC($documento);

        // Si se obtuvo respuesta válida
        if ($empresa && isset($empresa->data->nombre_o_razon_social)) {
            echo json_encode([
                "success" => true,
                "tipo" => "RUC",
                "data" => [
                    "razon_social" => $empresa->data->nombre_o_razon_social
                ]
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "No se encontraron datos para el RUC ingresado."
            ]);
        }

    // Si el documento no cumple con el formato esperado
    } else {
        echo json_encode([
            "success" => false,
            "message" => "El documento debe tener 8 (DNI) o 11 (RUC) dígitos."
        ]);
    }

} else {
    // Si la solicitud no es POST o falta el campo requerido
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido o datos incompletos."
    ]);
}

// Clase para realizar consultas a la API de Factiliza
class consultaDocumento {

    // Consulta datos de una persona a partir de su DNI
    public function consultarDNI($dni) {
        $token = getenv('FACTILIZA_TOKEN'); // Token de autorización

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => "https://api.factiliza.com/v1/dni/info/" . urlencode($dni),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "GET",
            CURLOPT_HTTPHEADER     => [
                "Authorization: Bearer " . $token
            ],
        ]);

        $response  = curl_exec($curl);
        $httpCode  = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error     = curl_error($curl);

        curl_close($curl);

        // Manejo de errores de conexión
        if ($error) {
            throw new Exception("Error cURL al consultar DNI en Factiliza: $error");
        }

        $data = json_decode($response);

        // Verifica si la respuesta fue exitosa
        if ($httpCode !== 200 || !$data || !$data->success) {
            throw new Exception("Consulta DNI fallida. Código HTTP: $httpCode.");
        }

        return $data;
    }

    // Consulta datos de una empresa a partir de su RUC
    public function consultarRUC($ruc) {
        $token = getenv('FACTILIZA_TOKEN'); // Token de autorización

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => "https://api.factiliza.com/v1/ruc/info/" . urlencode($ruc),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "GET",
            CURLOPT_HTTPHEADER     => [
                "Authorization: Bearer " . $token
            ],
        ]);

        $response  = curl_exec($curl);
        $httpCode  = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error     = curl_error($curl);

        curl_close($curl);

        // Manejo de errores de conexión
        if ($error) {
            throw new Exception("Error cURL al consultar RUC en Factiliza: $error");
        }

        $data = json_decode($response);

        // Verifica si la respuesta fue exitosa
        if ($httpCode !== 200 || !$data || !$data->success) {
            throw new Exception("Consulta RUC fallida. Código HTTP: $httpCode.");
        }

        return $data;
    }
}