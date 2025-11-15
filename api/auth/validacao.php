<?php
// --- SOLUCIÓN CORS ---
// Permitimos cualquier origen para la API, o puedes ser específico
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Maneja la solicitud pre-flight de OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(204); // No Content
    exit;
}
// --- FIN SOLUCIÓN CORS ---

header('Content-Type: application/json');

// 1. INCLUIR LA CONEXIÓN A LA BD
include "../../include/conn.php";

// 2. OBTENER LA LICENSE_KEY ENVIADA POR LA EXTENSIÓN
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->license_key)) {
    echo json_encode(["success" => false, "message" => "License key no proporcionada"]);
    exit;
}

$license_key = $data->license_key;

// 3. PREPARAR Y EJECUTAR LA CONSULTA A LA BD
// Buscamos la licencia y traemos los datos del usuario asociado
$stmt = $conn->prepare("SELECT l.*, u.name, u.email, u.status as user_status, u.user_type 
                       FROM licenses l 
                       JOIN users u ON l.user_id = u.id 
                       WHERE l.license_key = ?");
$stmt->bind_param("s", $license_key);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // --- INICIO DE LAS VALIDACIONES REALES ---

    // 4. VERIFICAR SI LA LICENCIA ESTÁ ACTIVA
    if ($row['status'] !== 'active') {
        echo json_encode(["success" => false, "message" => "Licença inativa"]);
        exit;
    }

    // 5. VERIFICAR SI EL USUARIO ESTÁ ACTIVO
    if ($row['user_status'] !== 'active') {
        echo json_encode(["success" => false, "message" => "Usuário inativo"]);
        exit;
    }

    // 6. VERIFICAR LA FECHA DE EXPIRACIÓN
    $today = date("Y-m-d");
    $expiration_date = $row['expiration_date'];

    if ($today > $expiration_date) {
        echo json_encode(["success" => false, "message" => "Licença expirada"]);
        exit;
    }

    // --- FIN DE LAS VALIDACIONES ---

    // 7. SI TODO ES CORRECTO, ENVIAR RESPUESTA EXITOSA
    $plan = strtoupper($row['plan']); // Obtenemos el plan de la BD
    
    $response = [
        "status" => true,
        "success" => true,
        "message" => "Validado con éxito",
        "user" => [
            "id" => $row['user_id'],
            "name" => $row['name'],
            "email" => $row['email'],
            "status" => $row['user_status'],
            "plan" => $plan, 
            "user_type" => $row['user_type'],
            "expiration_date" => $row['expiration_date'],
            "permissions" => [
                // Aquí puedes hacer la lógica de permisos más avanzada,
                // pero por ahora, si es premium, damos todo.
                "crm" => true,
                "funnel" => true,
                "schedule" => true,
                "check_sp" => true,
                "multiagent" => ($plan === 'PREMIUM'), // Solo si es PREMIUM
                "audio_transcription" => true
            ]
        ],
        "plan" => $plan,
        "valid" => true
    ];
    
    echo json_encode($response);

} else {
    // 8. SI NO SE ENCONTRÓ LA LICENCIA
    echo json_encode(["success" => false, "message" => "Licença não encontrada"]);
}

$stmt->close();
$conn->close();
?>