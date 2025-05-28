<?php
header('Content-Type: application/json'); // Indica que la respuesta será JSON

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['documento'])) {
    $documento = trim($_POST['documento']);

    if (empty($documento)) {
        echo json_encode(["success" => false, "message" => "El documento es obligatorio."]);
        exit;
    }

    if (preg_match('/^\d{8}$/', $documento)) {
        $consulta = new consultaDocumento();
        $persona = $consulta->consultarDNI($documento);

        if ($persona && isset($persona->nombres)) {
            echo json_encode([
                "success" => true,
                "tipo" => "DNI",
                "nombres" => $persona->nombres,
                "apellidoPaterno" => $persona->apellidoPaterno,
                "apellidoMaterno" => $persona->apellidoMaterno
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "No se encontraron datos para el DNI ingresado."]);
        }
    } elseif (preg_match('/^\d{11}$/', $documento)) {
        $consulta = new consultaDocumento();
        $empresa = $consulta->consultarRUC($documento);

        if ($empresa && isset($empresa->razonSocial)) {
            echo json_encode([
                "success" => true,
                "tipo" => "RUC",
                "razonSocial" => $empresa->razonSocial
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "No se encontraron datos para el RUC ingresado."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "El documento debe tener 8 (DNI) o 11 (RUC) dígitos."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido o datos incompletos."]);
}

class consultaDocumento {
    public function consultarDNI($dni) {
        $token = 'apis-token-13630.AmaUtxkVuxBnquFGwOQOJhcc7EAqDmhH';

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.apis.net.pe/v2/reniec/dni?numero=' . $dni,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Referer: https://apis.net.pe/consulta-dni-api',
                'Authorization: Bearer ' . $token
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response); // Devuelve los datos en formato JSON
    }

    public function consultarRUC($ruc) {
        $token = 'apis-token-13630.AmaUtxkVuxBnquFGwOQOJhcc7EAqDmhH';

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.apis.net.pe/v2/sunat/ruc?numero=' . $ruc,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Referer: http://apis.net.pe/api-ruc',
                'Authorization: Bearer ' . $token
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }
}
