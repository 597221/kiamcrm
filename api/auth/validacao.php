<?php
// --- SOLUCIÓN CORS ---
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(204);
    exit;
}
// --- FIN SOLUCIÓN CORS ---

header('Content-Type: application/json');

// 1. INCLUIR LA CONEXIÓN A LA BD
include "../../include/conn.php";

// 2. OBTENER EL TOKEN (que el frontend llama 'license_key')
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->token)){
    echo json_encode(["success" => false, "message" => "Token no proporcionado"]);
    exit;
}

$token = $data->token;

// 3. PREPARAR Y EJECUTAR LA CONSULTA A LA TABLA 'users'
$stmt = $conn->prepare("SELECT * FROM users WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // --- INICIO DE LAS VALIDACIONES REALES ---

    // 4. VERIFICAR SI EL USUARIO ESTÁ ACTIVO
    // (Tu tabla usa 1 para 'active', 0 para 'inactive')
    if ($user['status'] != 1) {
        echo json_encode(["success" => false, "message" => "Usuário inativo"]);
        exit;
    }

    // 5. VERIFICAR LA FECHA DE EXPIRACIÓN (¡la columna de tu panel!)
    $today = date("Y-m-d");
    $expiration_date = $user['plan_expiry_date'];

    if ($today > $expiration_date) {
        echo json_encode(["success" => false, "message" => "Licença expirada"]);
        exit;
    }

    // --- FIN DE LAS VALIDACIONES ---

    // 6. SI TODO ES CORRECTO, ENVIAR RESPUESTA EXITOSA
    // (Determinamos el plan basado en la fecha de expiración, o puedes añadir una columna "plan")
    $plan = "PREMIUM"; // Asumimos que si tiene fecha válida, es premium.

    $response = [
        "status" => true,
        "success" => true,
        "message" => "Validado con éxito",
        "user" => [
            "id" => $user['id'],
            "name" => $user['client_name'],
            "email" => $user['email'],
            "status" => ($user['status'] == 1) ? 'active' : 'inactive',
            "plan" => $plan, 
            "user_type" => "user", // Asumimos que todos son 'user'
            "expiration_date" => $user['plan_expiry_date'],
            "permissions" => [
                "crm" => true,
                "funnel" => true,
                "schedule" => true,
                "check_sp" => true,
                "multiagent" => ($plan === 'PREMIUM'),
                "audio_transcription" => true
            ]
        ],
        "plan" => $plan,
        "valid" => true
    ];
    
    echo json_encode($response);

} else {
    // 8. SI NO SE ENCONTRÓ EL TOKEN (sesión inválida)
    echo json_encode(["success" => false, "message" => "Sessão inválida ou não encontrada"]);
}

$stmt->close();
$conn->close();
?>