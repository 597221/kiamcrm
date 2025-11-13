<?php
// --- INICIO DE LA SOLUCIÓN CORS ---
header("Access-Control-Allow-Origin: https://web.whatsapp.com");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// --- FIN DE LA SOLUCIÓN CORS ---

header('Content-Type: application/json; charset=utf-8');

// Incluir la conexión a la base de datos
include("../../include/conn.php");
include("../../include/function.php");

$notificacoes = [];
// Asumo que tu tabla se llama 'notificacoes', basado en el nombre del archivo
$sql = "SELECT * FROM notificacoes"; 

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Convertimos los campos que sean números a tipo numérico
        $row['data'] = (int)$row['data'];
        $notificacoes[] = $row;
    }
}

$response = [
    "success" => true,
    "message" => "Notificações capturas",
    "notificacoes" => $notificacoes
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$conn->close();
?>