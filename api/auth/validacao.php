<?php
// --- SOLUCIÓN CORS ---
header("Access-Control-Allow-Origin: https://web.whatsapp.com");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// ---------------------

header('Content-Type: application/json');

// Simulamos una fecha de vencimiento lejana (año 2030)
$fecha_vencimiento = date('Y-m-d', strtotime('+5 years'));

$response = [
    "status" => true,
    "success" => true,
    "message" => "Validado con éxito",
    "user" => [
        "id" => 1,
        "name" => "Admin Kiamber",
        "email" => "admin@kiamber.com",
        "status" => "active",
        "plan" => "PREMIUM", // Forzamos el plan Premium
        "user_type" => "admin",
        "expiration_date" => $fecha_vencimiento,
        "permissions" => [
            "crm" => true,
            "funnel" => true,
            "schedule" => true,
            "check_sp" => true,
            "multiagent" => true, // IMPORTANTE: Activamos multiagente explícitamente
            "audio_transcription" => true
        ]
    ],
    // Algunos sistemas buscan la licencia fuera del objeto usuario
    "plan" => "PREMIUM",
    "valid" => true
];

echo json_encode($response);
?>