<?php
// --- INICIO DE LA SOLUCIÓN CORS ---
header("Access-Control-Allow-Origin: https://web.whatsapp.com");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// --- FIN DE LA SOLUCIÓN CORS ---

header('Content-Type: application/json; charset=utf-8');

// Incluir la conexión a la base de datos
include("../../include/conn.php");
include("../../include/db.php");
$db = new mysqliDB();

$modelos = [];
// Asumo que tu tabla se llama 'modelos_crm' (si es otro nombre, ajústalo aquí)
$sql = "SELECT * FROM modelos_crm"; 

$result = $db->query($sql); // Usamos la clase de db.php

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Decodificamos el campo 'arquivo' para que sea un objeto JSON
        $row['arquivo'] = json_decode($row['arquivo']);
        $modelos[] = $row;
    }
}

$response = [
    "success" => true,
    "message" => "Modelos cadastrados",
    "modelos" => $modelos
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$db->close();
?>